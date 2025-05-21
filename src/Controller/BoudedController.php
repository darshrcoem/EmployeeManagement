<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\I18n\FrozenTime;
use Cake\I18n\Time;

/**
 * Bouded Controller
 *
 * @property \App\Model\Table\BoudedTable $Bouded
 * @property \App\Model\Table\EmpDataTable $EmpData
 *
 * @method \App\Model\Entity\Bouded[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BoudedController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadModel('EmpData');
        $this->loadModel('Bouded'); // Load the model once here
    }

    public function bouded($id = null)
  {
    $this->request->allowMethod(['get', 'post']);
    $emp = $this->EmpData->find()->where(['emp_id' => $id])->first();
    $this->set(compact('emp'));

    $month = $this->request->getQuery('month') ?? date('m');
    $year = $this->request->getQuery('year') ?? date('Y');

    $startDate = new Time("$year-$month-01");
    $endDateString = $startDate->endOfMonth()->format('Y-m-d');
    $this->set('endDateString', $endDateString);

    $bou = $this->Bouded->find()->all();
    $markedBounse = [];
    $this->set('markedBounse', $markedBounse);

    if ($this->request->is('post')) {
        $exists = $this->Bouded->find()
            ->where(['emp_id' => $id,'record_date' => $endDateString])
            ->first();

        if ($exists) {
            $this->Flash->error(__('Bonus already exists for this period.'));
        } else {
            $data = $this->Bouded->newEntity([
                'emp_id' => $emp->emp_id,
                'fest_bounse' => $this->request->getData('fest_bounse'),
                'perf_bounse' => $this->request->getData('perf_bounse'),
                'tax_ded' => $this->request->getData('tax_ded'),
                'unpaid_ded' => $this->request->getData('unpaid_ded'),
                'record_date' => $endDateString
            ]);

            if ($this->Bouded->save($data)) {
                $this->Flash->success(__('Bonus saved successfully.'));
            } else {
                $this->Flash->error(__('Failed to save bonus.'));
            }
        }
        return $this->redirect(['action' => 'bouded', $id, '?' => ['month' => $month, 'year' => $year]]);
    }
    
}


}
