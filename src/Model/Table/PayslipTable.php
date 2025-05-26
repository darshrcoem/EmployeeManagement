<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Payslip Model
 *
 * @property &\Cake\ORM\Association\BelongsTo $Emps
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
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
            ->scalar('full_name')
            ->maxLength('full_name', 255)
            ->requirePresence('full_name', 'create')
            ->notEmptyString('full_name');

        $validator
            ->scalar('month')
            ->maxLength('month', 20)
            ->requirePresence('month', 'create')
            ->notEmptyString('month');

        $validator
            ->scalar('year')
            ->maxLength('year', 20)
            ->requirePresence('year', 'create')
            ->notEmptyString('year');

        $validator
            ->decimal('base_pay')
            ->requirePresence('base_pay', 'create')
            ->notEmptyString('base_pay');

        $validator
            ->integer('days_worked')
            ->requirePresence('days_worked', 'create')
            ->notEmptyString('days_worked');

        $validator
            ->decimal('total_bonus')
            ->requirePresence('total_bonus', 'create')
            ->notEmptyString('total_bonus');

        $validator
            ->decimal('total_deduction')
            ->requirePresence('total_deduction', 'create')
            ->notEmptyString('total_deduction');

        $validator
            ->decimal('net_pay')
            ->requirePresence('net_pay', 'create')
            ->notEmptyString('net_pay');

        $validator
            ->date('payment_date')
            ->requirePresence('payment_date', 'create')
            ->notEmptyDate('payment_date');

        $validator
            ->dateTime('created_at')
            ->notEmptyDateTime('created_at');

        $validator
            ->scalar('department')
            ->maxLength('department', 200)
            ->allowEmptyString('department');

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
