<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * EmpData Entity
 *
 * @property int $emp_id
 * @property string $Full_name
 * @property string $department
 * @property string $role
 * @property int|null $salary
 * @property \Cake\I18n\FrozenDate $joining_date
 * @property string|null $email
 * @property int|null $mobile
 * @property string|null $status
 */
class EmpData extends Entity
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
        '*' => true,
    ];
}
