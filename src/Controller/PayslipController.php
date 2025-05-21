<?php
namespace App\Controller;

use App\Controller\AppController;
use phpDocumentor\Reflection\Types\This;
use PhpParser\Builder\Function_;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use DateTime;
use DateInterval;
use DatePeriod;
use Cake\Http\Exception\NotFoundException;

/**
 * Payslip Controller
 *
 * @property \App\Model\Table\PayslipTable $Payslip
 * @property \App\Model\Table\EmpDataTable $EmpData
 * @property \App\Model\Table\PayslipTable $Bouded
 * @property \App\Model\Table\AttendenceTable $Attendence
 *
 * @method \App\Model\Entity\Payslip[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */


class PayslipController extends AppController
{
    private $attendanceSummary = [];
    private $workingDaysCount = 0;
    private $indexedData = [];
    private $month;
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('EmpData');
        $this->loadModel('Bouded');
        $this->loadModel('Payslip');
        $this->loadModel('Attendence'); // Load the model once here
    }
    public function display($username = null)
    {
        if (!$username) {
            $username = $this->request->getSession()->read('Auth.admin.username');
        }

        $this->set('username', $username); // Make it available to the view
        $this->render('dashboard'); // Render 'dashboard.ctp'
    }
    public function add()
    {
        $emp = $this->EmpData->find('all')->toArray();

        $this->set(compact('emp'));

        $this->render('add');
    }
    public function generate1($id = null, $month = null, $year = null)
    {
        if (!$id || !$month || !$year) {
            $this->Flash->error('Employee ID, Month, and Year are required.');
            return $this->redirect($this->referer());
        }

        $startDate = new Time("$year-$month-01");
        $startDateString = $startDate->format('Y-m-d');
        $endDateString = $startDate->endOfMonth()->format('Y-m-d');

        $start = new DateTime($startDateString);
        $end = new DateTime($endDateString);
        $end->modify('+1 day');

        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end);

        $workingDaysCount = 0;
        foreach ($period as $date) {
            if ($date->format('N') != 7) { // Exclude Sundays
                $workingDaysCount++;
            }
        }

        if ($workingDaysCount === 0) {
            $this->Flash->error('No working days found for the selected month.');
            return;
        }
        $attendanceDates = $this->Attendence->find()
            ->select(['at_date'])
            ->where([
                'Attendence.at_date >=' => $startDateString,
                'Attendence.at_date <=' => $endDateString,
                'Attendence.emp_id' => $id
            ])
            ->extract('at_date')
            ->toArray();


        if (sizeof($attendanceDates)!=$workingDaysCount) {
            $this->Flash->error('Cannot generate payslip: Attendance not marked for all working days.');
            return $this->redirect($this->referer());
        }

        // Fetch employee details
        $query = $this->EmpData->find()
            ->select([
                'emp_id',
                'salary',
                'role',
                'Full_name',
                'department',
                'fest_bounse' => 'Bouded.fest_bounse',
                'perf_bounse' => 'Bouded.perf_bounse',
                'tax_ded' => 'Bouded.tax_ded',
                'unpaid_ded' => 'Bouded.unpaid_ded'
            ])
            ->join([
                'table' => 'bouded',
                'alias' => 'Bouded',
                'type' => 'LEFT',
                'conditions' => [
                    'Bouded.emp_id = EmpData.emp_id',
                    'Bouded.record_date' => $endDateString
                ]
            ])
            ->where([
                'EmpData.emp_id' => $id,
                'EmpData.joining_date <=' => $endDateString
            ])
            ->first();

        if (!$query) {
            $this->Flash->error("Employee data not found for ID: $id");
            return;
        }

        $emp = $query;

        // Get attendance summary
        $this->loadModel('Attendence');
        $attendanceData = $this->Attendence->find()
            ->select([
                'status',
                'total' => $this->Attendence->find()->func()->count('status')
            ])
            ->where([
                'Attendence.at_date >=' => $startDateString,
                'Attendence.at_date <=' => $endDateString,
                'Attendence.emp_id' => $id
            ])
            ->group(['Attendence.status'])
            ->toArray();

        $attendanceSummary = [];
        foreach ($attendanceData as $att) {
            $attendanceSummary[$att->status] = $att->total;
        }

        $daysWorked = $attendanceSummary['Present'] ?? 0;

        // Salary calculation
        $festBonus = $emp->fest_bounse ?? 0;
        $perfBonus = $emp->perf_bounse ?? 0;
        $taxDed = $emp->tax_ded ?? 0;
        $unpaidDed = $emp->unpaid_ded ?? 0;

        $dailyPay = $emp->salary / $workingDaysCount;
        $basePay = round($dailyPay * $daysWorked);
        $netSalary = $basePay + $festBonus + $perfBonus - $taxDed - $unpaidDed;

        // Save payslip
        $this->loadModel('Payslip');
        $payslipData = [
            'emp_id' => (int) $id,
            'month' => (string) $month,
            'year' => (string) $year,
            'full_name' => (string) $emp->Full_name,
            'base_pay' => (float) $basePay,
            'days_worked' => (int) $daysWorked,
            'total_bonus' => (float) ($festBonus + $perfBonus),
            'total_deduction' => (float) ($taxDed + $unpaidDed),
            'net_pay' => (float) $netSalary,
            'payment_date' => date('Y-m-d'),
            'department' => (string) $emp->department
        ];

        $payslipEntity = $this->Payslip->newEntity($payslipData);
        if ($this->Payslip->save($payslipEntity)) {
            $this->Flash->success("Payslip successfully generated for employee ID $id.");
            return $this->redirect(['action' => 'generate']);
        } else {
            $this->Flash->error("Payslip not saved for employee ID $id.");
        }
        $this->set(compact('emp', 'attendanceSummary', 'workingDaysCount', 'month', 'year'));
    }


    public function generate()
    {
        $month = $this->request->getQuery('month.month') ?: date('m');
        $year = $this->request->getQuery('year.year') ?: date('Y');
        $department = $this->request->getQuery('department');

        $departments = $this->EmpData->find()
            ->select(['department'])
            ->distinct(['department'])
            ->order(['department' => 'ASC'])
            ->extract('department')
            ->toArray();
        $generatedSlips = $this->Payslip->find('list', [
            'keyField' => 'emp_id',
            'valueField' => 'id'
        ])->where([
                    'month' => $month,
                    'year' => $year
                ])->toArray();
        $query = $this->EmpData->find();

        if (!empty($department)) {
            $query->where(['department' => $department]);
        }

        $data = $query->order(['emp_id' => 'ASC'])->toArray();
        $this->set(compact('data', 'month', 'year', 'department', 'generatedSlips', 'departments'));
    }
    public function view()
    {
        $month = $this->request->getQuery('month.month') ?: date('m');
        $year = $this->request->getQuery('year.year') ?: date('Y');
        $department = $this->request->getQuery('department');

        $departments = $this->EmpData->find()
            ->select(['department'])
            ->distinct(['department'])
            ->order(['department' => 'ASC'])
            ->extract('department')
            ->toArray();

        $query = $this->Payslip->find()
            ->where([
                'month' => $month,
                'year' => $year
            ]);

        if (!empty($department)) {
            $query->where(['department' => $department]);
        }

        $payslips = $query->order(['emp_id' => 'ASC'])->toArray();
        $this->set(compact('payslips', 'month', 'year', 'department', 'departments'));
    }
    public function slip($id = null, $month = null, $year = null)
    {
        $query = $this->Payslip->find()
            ->where([
                'emp_id' => $id,
                'month' => $month,
                'year' => $year
            ])
            ->first();
        $data = $query->toArray();
        $this->set(compact('data'));
        $this->render('slip');
    }


}





