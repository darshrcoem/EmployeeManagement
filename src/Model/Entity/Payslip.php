<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payslip Entity
 *
 * @property int $id
 * @property int $emp_id
 * @property string $full_name
 * @property string $month
 * @property string $year
 * @property float $base_pay
 * @property int $days_worked
 * @property float $total_bonus
 * @property float $total_deduction
 * @property float $net_pay
 * @property \Cake\I18n\FrozenDate $payment_date
 * @property \Cake\I18n\FrozenTime $created_at
 * @property string|null $department
 *
 * @property \App\Model\Entity\EmpData $emp_data
 */
class Payslip extends Entity
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
        'full_name' => true,
        'month' => true,
        'year' => true,
        'base_pay' => true,
        'days_worked' => true,
        'total_bonus' => true,
        'total_deduction' => true,
        'net_pay' => true,
        'payment_date' => true,
        'created_at' => true,
        'department' => true,
        'emp_data' => true,
        
    ];
}
