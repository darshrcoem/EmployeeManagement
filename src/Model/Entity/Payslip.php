<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Payslip Entity
 *
 * @property int $payslip_id
 * @property int $emp_id
 * @property \Cake\I18n\FrozenDate $month
 * @property int $base_pay
 * @property int $days_worked
 * @property int|null $total_bonus
 * @property int|null $total_deduction
 * @property int $net_pay
 * @property \Cake\I18n\FrozenDate $payment_date
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
        'month' => true,
        'base_pay' => true,
        'days_worked' => true,
        'total_bonus' => true,
        'total_deduction' => true,
        'net_pay' => true,
        'payment_date' => true,
        'emp_data' => true,
    ];
}
