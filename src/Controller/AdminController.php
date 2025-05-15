<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Admin Controller
 *
 * @property \App\Model\Table\AdminTable $Admin
 *
 * @method \App\Model\Entity\Admin[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdminController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null
     */
    public function display()
    {
        $this->render('home'); // Explicitly render the 'home.ctp' view
    }
    public function logout()
    {
        $this->request->getSession()->destroy();
        return $this->redirect($this->Auth->logout());
    }

    /**
     * View method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function signup()
    {
        $admin = $this->Admin->newEntity();
        if ($this->request->is('post')) {
            $admin = $this->Admin->patchEntity($admin, $this->request->getData());
            if ($this->Admin->save($admin)) {
                $this->Flash->success(__('The admin has been saved.'));
                return $this->redirect(['action' => 'login']);
            }
            $this->Flash->error(__('The admin could not be saved. Please, try again.'));
        }
        $this->set(compact('admin'));
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $admin = $this->Auth->identify(); // AuthComponent checks login

            if ($admin) {
                $this->Auth->setUser($admin); // Stores user in session
                $username = $admin['username'];
                $this->Flash->success(__('Welcome back, ' . $username));
                return $this->redirect(['controller' => 'EmpData', 'action' => 'display', $username]);
            } else {
                $this->Flash->error(__('Invalid username or password, try again'));
            }
        }
    }

    /**
     * Edit method
     *
     * @param string|null $id Admin id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
}
