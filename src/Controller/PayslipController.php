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
    public function generate()
    {
        $month = $this->request->getQuery('month.month') ?: date('m');
        $year = $this->request->getQuery('year.year') ?: date('Y');
        // $emp = $this->EmpData->find('all')->toArray();
        $department = $this->request->getQuery('department');
        $departments = $this->EmpData->find()
            ->select(['department'])
            ->distinct(['department'])
            ->order(['department' => 'ASC'])
            ->extract('department')
            ->toArray();

        $startDate = new Time($year . '-' . $month . "-01");
        $startDateString = $startDate->format('Y-m-d');
        $endDateString = $startDate->endOfMonth()->format('Y-m-d');
        $start = new DateTime($startDateString);
        $end = new DateTime($endDateString);
        $end->modify('+1 day'); // Include the end date

        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end);
        $workingDaysCount = 0;
        foreach ($period as $date) {
            if ($date->format('N') != 7) { // Sunday excluded
                $workingDaysCount++;
            }
        }

        // $workingDaysCount now holds total working days (Monday to Saturday)


        $query = $this->EmpData->find()
            ->select([
                'EmpData.emp_id',
                'EmpData.salary',
                'EmpData.role',
                'EmpData.Full_name',
                'EmpData.department',
                'Bouded.record_date',
                'Bouded.fest_bounse',
                'Bouded.perf_bounse',
                'Bouded.tax_ded',
                'Bouded.unpaid_ded'
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
            ->where(['EmpData.joining_date <=' => $endDateString]);


        if (!empty($department)) {
            $query->where(['EmpData.department' => $department]);
        }
        $data = [];
        $data = $query
            ->order(['EmpData.emp_id' => 'ASC'])
            ->toArray();
        foreach ($query as $row) {
            $indexedData[$row->emp_id] = $row;
        }

        $attendanceQuery = $this->Attendence->find()
            ->select([
                'emp_id',
                'status',
                'total' => $this->Attendence->find()->func()->count('status')
            ])
            ->where([
                'Attendence.at_date >=' => $startDateString,
                'Attendence.at_date <=' => $endDateString,
                'Attendence.emp_id IN' => collection($data)->extract('emp_id')->toList()
            ])
            ->group(['Attendence.emp_id', 'Attendence.status']);

        $attendanceResults = $attendanceQuery->toArray();
        $this->loadModel('Payslip');
        foreach ($attendanceResults as $att) {
            $attendanceSummary[$att->emp_id][$att->status] = $att->total;
        }
        // foreach ($data as $emp) {
        //     $empId = $emp->emp_id;
        //     $salary = $emp->salary;
        //     $daysWorked = isset($attendanceSummary[$empId]['Present']) ? $attendanceSummary[$empId]['Present'] : 0;

        //     // Bonuses and Deductions
        //     $festBonus = $emp->Bouded['fest_bounse'] ?? 0;
        //     $perfBonus = $emp->Bouded['perf_bounse'] ?? 0;
        //     $taxDed = $emp->Bouded['tax_ded'] ?? 0;
        //     $unpaidDed = $emp->Bouded['unpaid_ded'] ?? 0;

        //     // Calculate net salary
        //     $dailyPay = $salary / $workingDaysCount;
        //     $basePay = round($dailyPay * $daysWorked);
        //     $netSalary = $basePay + $festBonus + $perfBonus - $taxDed - $unpaidDed;

        //     $entity = [
        //         'emp_id' => (int) $empId,
        //         'month' => (string) $month,
        //         'year' => (string) $year,
        //         'full_name' => (string) $emp->Full_name,
        //         'base_pay' => (float) $basePay,
        //         'days_worked' => (int) $daysWorked,
        //         'total_bonus' => (float) ($festBonus + $perfBonus),
        //         'total_deduction' => (float) ($taxDed + $unpaidDed),
        //         'net_pay' => (float) $netSalary,
        //         'payment_date' => $endDateString // Make sure it's a valid date string or Date object
        //     ];
        //     $payslipEntity = $this->Payslip->newEntity($entity);
        //     if (!$this->Payslip->save($payslipEntity)) {
        //         // Optional: collect errors for debugging
        //         $errors = $payslipEntity->getErrors();
        //         // You can log or flash the error if needed
        //         $this->Flash->error("Payslip not saved for employee ID $empId.");
        //     }

        // }
        $this->set(compact('data', 'emp', 'bou', 'departments', 'month', 'year', 'department', 'attendanceSummary', 'workingDaysCount'));
    }
    public function slip($id = null)
    {
        $query = $this->Payslip->find()
            ->where(['emp_id' => $id])
            ->first();
        $data=$query->toArray();
        $this->set(compact('data'));
        $this->render('slip');
    }




}





