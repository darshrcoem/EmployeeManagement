<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Attendence Entity
 *
 * @property int $at_id
 * @property int $emp_id
 * @property \Cake\I18n\FrozenDate $at_date
 * @property string $status
 * @property string|null $remark
 * @property bool|null $access
 *
 * @property \App\Model\Entity\EmpData $emp_data
 */
class Attendence extends Entity
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
        'at_date' => true,
        'status' => true,
        'remark' => true,
        'access' => true,
        'emp_data' => true,
    ];
}
