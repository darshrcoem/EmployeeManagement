<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payslip Model
 *
 * @property \App\Model\Table\EmpDataTable&\Cake\ORM\Association\BelongsTo $EmpData
 *
 * @method \App\Model\Entity\Payslip get($primaryKey, $options = [])
 * @method \App\Model\Entity\Payslip newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Payslip[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Payslip|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payslip saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Payslip patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Payslip[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Payslip findOrCreate($search, callable $callback = null, $options = [])
 */
class PayslipTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('payslip');
        $this->setDisplayField('payslip_id');
        $this->setPrimaryKey('payslip_id');

        $this->belongsTo('EmpData', [
            'foreignKey' => 'emp_id',
            'joinType' => 'INNER',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->integer('payslip_id')
            ->allowEmptyString('payslip_id', null, 'create');

        $validator
            ->date('month')
            ->requirePresence('month', 'create')
            ->notEmptyDate('month');

        $validator
            ->integer('base_pay')
            ->requirePresence('base_pay', 'create')
            ->notEmptyString('base_pay');

        $validator
            ->integer('days_worked')
            ->requirePresence('days_worked', 'create')
            ->notEmptyString('days_worked');

        $validator
            ->integer('total_bonus')
            ->allowEmptyString('total_bonus');

        $validator
            ->integer('total_deduction')
            ->allowEmptyString('total_deduction');

        $validator
            ->integer('net_pay')
            ->requirePresence('net_pay', 'create')
            ->notEmptyString('net_pay');

        $validator
            ->date('payment_date')
            ->requirePresence('payment_date', 'create')
            ->notEmptyDate('payment_date');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['emp_id'], 'EmpData'));

        return $rules;
    }
}
