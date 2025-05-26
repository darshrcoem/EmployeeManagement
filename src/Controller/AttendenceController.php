<?php
namespace App\Controller;
use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;
use PhpParser\Node\Expr\FuncCall;
use Cake\Http\Exception\MethodNotAllowedException;

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
        if ($this->request->is('POST')) {
            $empId = $this->request->getData('emp_id');
            $date = $this->request->getData('date');
            $status = $this->request->getData('status');
            $remark = $this->request->getData('remark');

            if (!$empId || !$date || !$status) {
                return $this->response->withType('application/json')
                    ->withStringBody(json_encode(['success' => false, 'message' => 'Missing required fields.']));
            }
            $existing = $this->Attendence->find()
                ->where(['emp_id' => $empId, 'at_date' => $date])
                ->first();

            if ($existing) {
                if ($existing->access == "0") {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode(['success' => false, 'message' => 'Payslip generated, attendance cannot be edited.']));
                }

                $existing->status = $status;
                $existing->remark = $remark;
                $existing->modified = date('Y-m-d H:i:s');

                if ($this->Attendence->save($existing)) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode(['success' => true, 'message' => 'Attendance updated successfully.']));
                } else {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode(['success' => false, 'message' => 'Failed to update attendance.']));
                }
            } else {
                $newAttendance = $this->Attendence->newEntity([
                    'emp_id' => $empId,
                    'at_date' => $date,
                    'status' => $status,
                    'remark' => $remark,
                    'created' => date('Y-m-d H:i:s'),
                    'modified' => date('Y-m-d H:i:s'),
                    'access' => "1"
                ]);

                if ($this->Attendence->save($newAttendance)) {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode(['success' => true, 'message' => 'Attendance marked successfully.']));
                } else {
                    return $this->response->withType('application/json')
                        ->withStringBody(json_encode(['success' => false, 'message' => 'Failed to mark attendance.']));
                }
            }
        }
    }

    public function view()
    {
        $emp = $this->EmpData->find('all')->toArray();

        $date = $this->request->getQuery('date');

        if (is_array($date)) {
            $date = $date['year'] . '-' . str_pad($date['month'], 2, '0', STR_PAD_LEFT) . '-' . str_pad($date['day'], 2, '0', STR_PAD_LEFT);
        }
        if($date> date('Y-m-d')) {
            $this->Flash->error(__('You cannot mark attendance for a future date.'));
            return $this->redirect(['action' => 'view']);
        }
        

        $query = $this->EmpData->find()
            ->select([
                'EmpData.emp_id',
                'EmpData.full_name',
                'Attendence.at_date',
                'Attendence.status',
                'Attendence.access'
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
            ->order(['EmpData.emp_id' => 'ASC']);

        $data = $query->toArray();
        $this->set(compact('emp', 'data', 'ate'));

    }
    public function report()
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

        $startDate = new Time($year . '-' . $month . "-01");
        $startDateString = $startDate->format('Y-m-d');
        $endDateString = $startDate->endOfMonth()->format('Y-m-d');
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
        krsort($attendanceSummary);
        $this->set(compact('attendanceSummary', 'month', 'year', 'startDateString', 'endDateString', 'data', 'departments', 'department'));
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