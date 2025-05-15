<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Bouded Entity
 *
 * @property int $id
 * @property int|null $emp_id
 * @property \Cake\I18n\FrozenDate|null $record_date
 * @property float|null $fest_bounse
 * @property float|null $perf_bounse
 * @property float|null $tax_ded
 * @property float|null $unpaid_ded
 *
 * @property \App\Model\Entity\EmpData $emp_data
 */
class Bouded extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'emp_id' => true,
        'record_date' => true,
        'fest_bounse' => true,
        'perf_bounse' => true,
        'tax_ded' => true,
        'unpaid_ded' => true,
        'emp_data' => true,
    ];
}
