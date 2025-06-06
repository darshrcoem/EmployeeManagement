<?php
namespace App\Model\Entity;
use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\Entity;

/**
 * Admin Entity
 *
 * @property int $id
 * @property string|null $username
 * @property string|null $password
 * @property \Cake\I18n\FrozenTime|null $CR_time
 * @property \Cake\I18n\FrozenTime|null $Md_time
 */
class Admin extends Entity
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
    // Add this method inside the Admin class
    protected $_accessible = [
        'username' => true,
        'password' => true,
        'CR_time' => true,
        'Md_time' => true,
    ];
    
    /**
     * Fields that are excluded from JSON versions of the entity.
     *
     * @var array
     */
    protected $_hidden = [
        'password',
    ];
    protected function _setPassword($password)
    {
    if (strlen($password) > 0) {
        return (new DefaultPasswordHasher)->hash($password);
    }
   }
}
