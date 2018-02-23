<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 * @property Category $ParentCategory
 * @property Category $ChildCategory
 */
class Comment extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
                    'className' => 'User',
                    'foreignKey' => 'user_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
		),
                'ToUser' => array(
                    'className' => 'User',
                    'foreignKey' => 'to_user_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	
}
