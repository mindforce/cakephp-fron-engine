<?php
namespace FrontEngine\Model\Entity;

use Cake\ORM\Entity;

/**
 * Menu Entity.
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property int $link_count
 */
class Menu extends Entity
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
        'id' => false,
    ];
}
