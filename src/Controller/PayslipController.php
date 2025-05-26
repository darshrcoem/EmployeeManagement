<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\I18n\Time;
use DateTime;
use DateInterval;
use DatePeriod;
use Dompdf\Dompdf;
use Dompdf\Options;


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

    public function payslipformat($id = null, $month = null, $year = null)
    {
        if (!$id || !$month || !$year) {
            $this->Flash->error('Employee ID, Month, and Year are required.');
            return $this->redirect($this->referer());
        }
        $startDate = new Time("$year-$month-01");
        $startString = $startDate->format('Y-m-d');
        $endString = $startDate->endOfMonth()->format('Y-m-d');
        $start = new DateTime($startString);
        $end = (new DateTime($endString))->modify('+1 day');
        $period = new DatePeriod($start, new DateInterval('P1D'), $end);

        $workingDaysCount = 0;
        foreach ($period as $date) {
            if ($date->format('N') != 7) {
                $workingDaysCount++;
            }
        }
        if ($workingDaysCount === 0) {
            $this->Flash->error('No working days found for the selected month.');
            return;
        }
        $emp = $this->EmpData->find()
            ->select([
                'emp_id',
                'salary',
                'Full_name',
                'department',
            ])
            ->where(['EmpData.emp_id' => $id])
            ->first();
        $attendanceData = $this->Attendence->find()
            ->select([
                'Present' => $this->Attendence->find()->func()->count(
                    new \Cake\Database\Expression\QueryExpression("CASE WHEN status = 'Present' THEN 1 ELSE NULL END")
                ),
                'Absent' => $this->Attendence->find()->func()->count(
                    new \Cake\Database\Expression\QueryExpression("CASE WHEN status = 'Absent' THEN 1 ELSE NULL END")
                ),
                'Leave' => $this->Attendence->find()->func()->count(
                    new \Cake\Database\Expression\QueryExpression("CASE WHEN status = 'Leave' THEN 1 ELSE NULL END")
                )
            ])
            ->where([
                'Attendence.at_date >=' => $startString,
                'Attendence.at_date <=' => $endString,
                'Attendence.emp_id' => $id
            ])
            ->toArray();

        $total = $attendanceData[0]['Present'] + $attendanceData[0]['Absent'] + $attendanceData[0]['Leave'];
        if ($total != $workingDaysCount) {
            $this->Flash->error('Cannot generate payslip: Attendance not marked for all working days.');
            return $this->redirect($this->referer());
        }

        $daysWorked = $attendanceData[0]['Present'] ?? 0;
        $leaves = $attendanceData[0]['Leave'] ?? 0;
        $absenties = $attendanceData[0]['Absent'] ?? 0;


        $this->set(compact(
            'attendanceSummary',
            'workingDaysCount',
            'daysWorked',
            'leaves',
            'absenties',
            'month',
            'emp',
            'year'
        ));
    }
    public function Bouded()
    {

        if ($this->request->is('post')) {
            $data = $this->request->getData();
            $year = $data['year'];
            $id = $data['emp_id'];
            $month = $data['month'];
            $startDate = new Time("$year-$month-01");
            $startDateString = $startDate->format('Y-m-d');
            $endDateString = $startDate->endOfMonth()->format('Y-m-d');
            $dailypay = round($data['salary'] / $data['working_days'], 2);
            $basePay = round($dailypay * $data['days_worked'], 2);
            $netsalary = $basePay + $data['performance_bonus'] + $data['festival_bonus'] - $data['tax_deduction'] - $data['unpaid_leave_deduction'];
            $payslipData = [
                'emp_id' => (int) $id,
                'month' => (string) $data['month'],
                'year' => (string) $data['year'],
                'full_name' => (string) $data['full_name'],
                'base_pay' => (float) $basePay,
                'days_worked' => (int) $data['days_worked'],
                'total_bonus' => (float) ($data['performance_bonus'] + $data['festival_bonus']),
                'total_deduction' => (float) ($data['tax_deduction'] + $data['unpaid_leave_deduction']),
                'net_pay' => (float) $netsalary,
                'payment_date' => date('Y-m-d'),
                'department' => (string) $data['department']
            ];
            $payslipEntity = $this->Payslip->newEntity($payslipData);
            if ($this->Payslip->save($payslipEntity)) {
                $this->Flash->success("Payslip successfully generated for employee ID $id .");
                $query = $this->Attendence->query();
                $result = $query->update()
                    ->set(['access' => false])
                    ->where([
                        'emp_id' => $data['emp_id'],
                        'at_date >=' => $startDateString,
                        'at_date <=' => $endDateString
                    ])
                    ->execute();
                return $this->redirect(['action' => 'generate']);
            } else {
                $this->Flash->error("Payslip not saved for employee ID $id.");
            }
        }
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

    public function pdf($id)
    {
        $data = $this->Payslip->get($id);

        $this->set(compact('data'));
        $html = $this->render('pdf');

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $file = $data['full_name'] . '_payslip_' . $data['month'] . '_' . $data['year'] . '.pdf';

        return $this->response
            ->withType('application/pdf')
            ->withHeader('Content-Disposition', 'attachment; filename="' . $file . '"')
            ->withHeader('Content-Transfer-Encoding', 'binary')
            ->withHeader('Expires', '0')
            ->withHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0')
            ->withHeader('Pragma', 'public')
            ->withStringBody($dompdf->output());
    }


}





