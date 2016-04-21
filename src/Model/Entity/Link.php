<?php
namespace FrontEngine\Model\Entity;

use Cake\ORM\Entity;

/**
 * Link Entity.
 *
 * @property int $id
 * @property int $menu_id
 * @property \FrontEngine\Model\Entity\Menu $menu
 * @property int $parent_id
 * @property \FrontEngine\Model\Entity\ParentFrontEngineLink $parent_front_engine_link
 * @property string $title
 * @property string $link
 * @property \Cake\I18n\Time $created
 * @property \Cake\I18n\Time $modified
 * @property bool $homepage
 * @property bool $state
 * @property int $lft
 * @property int $rght
 * @property string $options
 * @property \FrontEngine\Model\Entity\ChildFrontEngineLink[] $child_front_engine_links
 */
class Link extends Entity
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
