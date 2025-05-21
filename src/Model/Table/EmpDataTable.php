<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * EmpData Model
 *
 * @method \App\Model\Entity\EmpData get($primaryKey, $options = [])
 * @method \App\Model\Entity\EmpData newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\EmpData[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\EmpData|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpData saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\EmpData patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\EmpData[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\EmpData findOrCreate($search, callable $callback = null, $options = [])
 */
class EmpDataTable extends Table
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

        $this->setTable('emp_data');
        $this->setDisplayField('emp_id');
        $this->setPrimaryKey('emp_id');
        $this->hasMany('Attendence', [
            'foreignKey' => 'emp_id', 
            'className' => 'Attendence',  
            'dependent' => true,
        ]);
         $this->hasMany('payslip', [
            'foreignKey' => 'emp_id', 
            'className' => 'Payslip',  
            'dependent' => true,
        ]);
         $this->hasMany('bouded', [
            'foreignKey' => 'emp_id', 
            'className' => 'Bouded',  
            'dependent' => true,
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
            ->integer('emp_id')
            ->allowEmptyString('emp_id', null, 'create');

        $validator
            ->scalar('Full_name')
            ->maxLength('Full_name', 255)
            ->requirePresence('Full_name', 'create')
            ->notEmptyString('Full_name');

        $validator
            ->scalar('department')
            ->maxLength('department', 255)
            ->requirePresence('department', 'create')
            ->notEmptyString('department');

        $validator
            ->scalar('role')
            ->maxLength('role', 255)
            ->requirePresence('role', 'create')
            ->notEmptyString('role');

        $validator
            ->integer('salary')
            ->allowEmptyString('salary');

        $validator
            ->date('joining_date')
            ->requirePresence('joining_date', 'create')
            ->notEmptyDate('joining_date');

        $validator
            ->email('email')
            ->allowEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->allowEmptyString('mobile')
            ->add('mobile', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->allowEmptyString('status');

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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['mobile']));

        return $rules;
    }
}
