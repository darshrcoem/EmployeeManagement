<?php
namespace App\Controller;

class EmpDataController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('EmpData'); // Load the model once here
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
    

    public function addEmp()
    {
        $emp = $this->EmpData->newEntity();

        if ($this->request->is('post')) {
            $emp = $this->EmpData->patchEntity($emp, $this->request->getData());
            if ($this->EmpData->save($emp)) {
                $this->Flash->success(__('The employee has been saved.'));
                return $this->redirect(['action' => 'display']);
            } else {
                $this->Flash->error(__('The employee could not be saved. Please, try again.'));
            }
        }

        $this->set(compact('emp'));
    }

    public function editemp($id = null)
    {
        $emp = $this->EmpData->find('all')->toArray();
        $this->set(compact('emp'));
    }
    public function viewemp()
    {
        $query = $this->EmpData->find();

        // Apply filters
        $department = $this->request->getQuery('department');
        if (!empty($department)) {
            $query->where(['department' => $department]);
        }

        $role = $this->request->getQuery('role');
        if (!empty($role)) {
            $query->where(['role' => $role]);
        }

        $status = $this->request->getQuery('status');
        if (!empty($status)) {
            $query->where(['status' => $status]);
        }

        // Paginate results
        $this->paginate = [
            'limit' => 10,
            'order' => ['emp_id' => 'asc']
        ];
        $emp = $this->paginate($query);

        // Pass data to the view
        $departments = $this->EmpData->find('list', ['keyField' => 'department', 'valueField' => 'department'])->distinct('department')->toArray();
        $roles = $this->EmpData->find('list', ['keyField' => 'role', 'valueField' => 'role'])->distinct('role')->toArray();

        $this->set(compact('emp', 'departments', 'roles'));
    }

    public function deleteemp()
    {
        $emp = $this->EmpData->find('all')->toArray();
        $this->set(compact('emp'));
    }
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);

        $emp = $this->EmpData->get($id);
        $name = $emp->full_name;

        if ($this->EmpData->delete($emp)) {
            $this->Flash->success("The employee {$name} has been deleted.");
        } else {
            $this->Flash->error("The employee could not be deleted. Please try again.");
        }

        return $this->redirect(['action' => 'deleteemp']);
    }


    public function update($id = null)
    {
        if ($id === null) {
            $this->Flash->error(__('Invalid ID.'));
            return $this->redirect(['action' => 'display']);
        }

        try {
            $emp = $this->EmpData->get($id);
        } catch (\Cake\Datasource\Exception\RecordNotFoundException $e) {
            $this->Flash->error(__('Employee not found.'));
            return $this->redirect(['action' => 'display']);
        }

        if ($this->request->is(['post', 'put', 'patch'])) {
            $emp = $this->EmpData->patchEntity($emp, $this->request->getData());
            if (!$emp->isDirty()) {
                $this->Flash->error(__('No changes were made to the employee.'));
                return $this->redirect(['action' => 'editemp']);
            }
            if ($this->EmpData->save($emp)) {
                $this->Flash->success(__('Data has been updated.'));
                return $this->redirect(['action' => 'viewemp']);
            } else {
                $this->Flash->error(__('Update failed.'));
            }
        }

        $this->set(compact('emp'));
    }
}
?>