<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Attendence Model
 *
 * @property \App\Model\Table\EmpDataTable&\Cake\ORM\Association\BelongsTo $EmpData
 *
 * @method \App\Model\Entity\Attendence get($primaryKey, $options = [])
 * @method \App\Model\Entity\Attendence newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Attendence[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Attendence|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Attendence saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Attendence patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Attendence[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Attendence findOrCreate($search, callable $callback = null, $options = [])
 */
class AttendenceTable extends Table
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

        $this->setTable('attendence');
        $this->setDisplayField('at_id');
        $this->setPrimaryKey('at_id');

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
            ->integer('at_id')
            ->allowEmptyString('at_id', null, 'create');

        $validator
            ->date('at_date')
            ->requirePresence('at_date', 'create')
            ->notEmptyDate('at_date');

        $validator
            ->scalar('status')
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

        $validator
            ->scalar('remark')
            ->maxLength('remark', 255)
            ->allowEmptyString('remark');

        $validator
            ->boolean('access')
            ->allowEmptyString('access');

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
