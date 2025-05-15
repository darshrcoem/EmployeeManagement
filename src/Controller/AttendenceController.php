<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use PhpParser\Node\Expr\FuncCall;

class AttendenceController extends AppController
{
   


    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('EmpData');
        $this->loadModel('Attendence'); // Load the model once here
    }
    public function display($username = null)
    {
        if (!$username) {
            // Optionally, fall back to session if not passed
            $username = $this->request->getSession()->read('Auth.admin.username');
        }

        $this->set('username', $username); // Make it available to the view
        $this->render('dashboard'); // Render 'dashboard.ctp'
    }

    public function mark()
    {
        $emp = $this->EmpData->find('all')->toArray();
        $this->set(compact('emp'));
        $ate = $this->Attendence->find('all')->toArray();
        $this->set(compact('ate'));
        $today = FrozenTime::now()->format('Y-m-d');
        // Controller: Convert attendances into key => value (emp_id => true)
        $markedAttendance = [];

        foreach ($ate as $a) {
            if ($a->at_date->format('Y-m-d') === $today) {
                $markedAttendance[$a->emp_id] = true;
            }
        }
        if ($this->request->is('post')) {
            $emp_id = $this->request->getData('emp_id');
            $status = $this->request->getData('status');
            $remark = $this->request->getData('remark');
            $result = $this->Attendence->newEntity([
                'emp_id' => $emp_id,
                'status' => $status,
                'at_date' => $today,
                'remark' => $remark,
            ]);
            if ($result) {
                $this->Attendence->save($result);
                $this->Flash->success(__('Attendance marked successfully.' . $status));
            } else {
                $this->Flash->error(__('Failed to mark attendance.'));
            }
            return $this->redirect(['action' => 'mark']);
        }
        $this->set('attendence', $markedAttendance);
    }
    public function view()
    {
        $emp = $this->EmpData->find('all')->toArray();
        $ate = $this->Attendence->find('all')->toArray();

        $date = $this->request->getQuery('date');

        if (is_array($date)) {
            $date = $date['year'] . '-' . str_pad($date['month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($date['day'], 2, '0', STR_PAD_LEFT);
        }

        $query = $this->EmpData->find()
            ->select([
                'EmpData.emp_id',
                'EmpData.full_name',
                'Attendence.at_date',
                'Attendence.status'
            ])
            ->join([
                [
                    'table' => 'Attendence',
                    'alias' => 'Attendence',
                    'type' => 'INNER',
                    'conditions' => 'Attendence.emp_id = EmpData.emp_id'
                ]
            ])
            ->where([
                'EmpData.joining_date <=' => $date,
                'Attendence.at_date' => $date
            ])
            ->order(['EmpData.full_name' => 'ASC']);

        $data = $query->toArray();

        $this->set(compact('emp', 'data', 'ate'));

    }
    public function report()
    {
        $month = $this->request->getQuery('month.month')?:date('m');
        $year = $this->request->getQuery('year.year')?:date('Y');
        $department = $this->request->getQuery('department');
        $departments = $this->EmpData->find()
            ->select(['department'])
            ->distinct(['department'])
            ->order(['department' => 'ASC'])
            ->extract('department')
            ->toArray();

        $startDate= new Time(   $year . '-' . $month . "-01");
        $startDateString= $startDate->format('Y-m-d');
        $endDateString = $startDate->endOfMonth()->format('Y-m-d');


        
        // Query without duplicate rows
        $query = $this->EmpData->find()
            ->select(['EmpData.emp_id', 'EmpData.full_name', 'EmpData.department'])
            ->contain([
                'Attendence' => function ($q) use ($startDateString, $endDateString) {
                    return $q->where([
                        'Attendence.at_date >=' => $startDateString,
                        'Attendence.at_date <=' => $endDateString
                    ]);
                }
            ])
            ->where(['EmpData.joining_date <=' => $endDateString]);
        if ($department) {
            $query->where(['EmpData.department' => $department]);
        }
        $data = $query
            ->order(['EmpData.full_name' => 'ASC'])
            ->toArray();

        // Attendance summary
        $attendanceSummary = [];
        foreach ($data as $d) {
            $empId = $d->emp_id;
            $empName = $d->full_name;

            $attendanceSummary[$empId] = [
                'name' => $empName ?? 'Unknown',
                'department' => $d->department ?? 'Unknown',
                'present' => 0,
                'absent' => 0,
                'leave' => 0,
                'days' => []
            ];

            foreach ($d->attendence as $att) {
                $status = strtolower($att->status);
                $date = $att->at_date->format('Y-m-d');

                if (in_array($status, ['present', 'absent', 'leave'])) {
                    $attendanceSummary[$empId][$status]++;
                    $attendanceSummary[$empId]['days'][$date] = $status;
                }
            }
        }

        // Sort descending by emp_id
        krsort($attendanceSummary);

        // Set to view
        $this->set(compact('attendanceSummary', 'month', 'year', 'startDateString', 'endDateString', 'data','departments', 'department'));
    }



    public function edit()
    {
        if ($this->request->is('post')) {
            $emp_id = $this->request->getData('emp_id');
            $status = $this->request->getData('status');
            $date = $this->request->getData('date');
            $record = $this->Attendence->find()
                ->where([
                    'emp_id' => $emp_id,
                    'at_date' => $date
                ])
                ->first();

            if ($record) {
                $record = $this->Attendence->patchEntity($record, [
                    'status' => $status,
                ]);

                if ($this->Attendence->save($record)) {
                    $this->Flash->success(__('Attendance updated successfully.'));
                } else {
                    $this->Flash->error(__('Failed to update attendance.'));
                }
            } else {
                $this->Flash->error(__('Attendance record not found.'));
            }

            return $this->redirect(['action' => 'view']);
        }
    }

}