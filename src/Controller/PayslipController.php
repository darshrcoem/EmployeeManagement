<?php
namespace App\Controller;

use App\Controller\AppController;
use PhpParser\Builder\Function_;

/**
 * Payslip Controller
 *
 * @property \App\Model\Table\PayslipTable $Payslip
 * @property \App\Model\Table\EmpDataTable $EmpData
 * @property \App\Model\Table\PayslipTable $Bouded
 *
 * @method \App\Model\Entity\Payslip[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PayslipController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('EmpData');
        $this->loadModel('Bouded');
        $this->loadModel('Payslip'); // Load the model once here
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
    public function generate($id = null)
    {
        $bou = $this->Bouded->find()->all();
        
    }

   
}
