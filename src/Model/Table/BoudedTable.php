<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Bouded Model
 *
 * @property \App\Model\Table\EmpDataTable&\Cake\ORM\Association\BelongsTo $EmpData
 *
 * @method \App\Model\Entity\Bouded get($primaryKey, $options = [])
 * @method \App\Model\Entity\Bouded newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Bouded[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Bouded|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bouded saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Bouded patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Bouded[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Bouded findOrCreate($search, callable $callback = null, $options = [])
 */
class BoudedTable extends Table
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

        $this->setTable('bouded');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('EmpData', [
            'foreignKey' => 'emp_id',
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->date('record_date')
            ->allowEmptyDate('record_date');

        $validator
            ->decimal('fest_bounse')
            ->allowEmptyString('fest_bounse');

        $validator
            ->decimal('perf_bounse')
            ->allowEmptyString('perf_bounse');

        $validator
            ->decimal('tax_ded')
            ->allowEmptyString('tax_ded');

        $validator
            ->decimal('unpaid_ded')
            ->allowEmptyString('unpaid_ded');

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
