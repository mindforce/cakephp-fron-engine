<?php
namespace FrontEngine\Model\Table;

use ArrayObject;
use FrontEngine\Model\Entity\FrontEngineLink;
use Cake\Event\Event;
use Cake\Datasource\EntityInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Links Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Menus
 * @property \Cake\ORM\Association\BelongsTo $ParentLinks
 * @property \Cake\ORM\Association\HasMany $ChildLinks
 */
class LinksTable extends Table
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

        $this->table('front_engine_links');
        $this->displayField('title');
        $this->primaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Tree');
        $this->addBehavior('Tools.Jsonable', [
            'fields' => ['options'],
        ]);

        $this->belongsTo('Menus', [
            'foreignKey' => 'menu_id',
            'joinType' => 'INNER',
            'className' => 'FrontEngine.Menus'
        ]);
        $this->addBehavior('CounterCache', [
            'Menus' => ['link_count']
        ]);

        $this->belongsTo('ParentLinks', [
            'className' => 'FrontEngine.Links',
            'foreignKey' => 'parent_id'
        ]);
        $this->hasMany('ChildFrontEngineLinks', [
            'className' => 'FrontEngine.Links',
            'foreignKey' => 'parent_id'
        ]);

        // Add the behaviour to your table
        $this->addBehavior('Search.Search');

        $this->searchManager()
            ->add('menu_id', 'Search.Value', [
                'options' => [
                    'type' => 'select2',
                    'empty' => true,
                    'options' => $this->Menus->find('list')
                ]
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
            ->allowEmpty('id', 'create');

        $validator
            ->requirePresence('title', 'create')
            ->notEmpty('title');

        $validator
            ->requirePresence('link', 'create')
            ->notEmpty('link');

        $validator
            ->boolean('homepage')
            ->requirePresence('homepage', 'create')
            ->notEmpty('homepage');

        $validator
            ->boolean('state')
            ->requirePresence('state', 'create')
            ->notEmpty('state');

        $validator
            ->integer('lft')
            ->allowEmpty('lft');

        $validator
            ->integer('rght')
            ->allowEmpty('rght');

        $validator
            ->allowEmpty('options');

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
        $rules->add($rules->existsIn(['menu_id'], 'Menus'));
        $rules->add($rules->existsIn(['parent_id'], 'ParentLinks'));
        return $rules;
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options){
        if (!empty($entity->homepage)) {
            $this->updateAll(['homepage' => 0], []);
        }
        return true;
    }

}
