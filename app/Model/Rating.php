<?php
App::uses('AppModel', 'Model');
/**
 * Review Model
 *
 * @property User $User
 */
class Rating extends AppModel {

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
		
            'Product' => array(
			'className' => 'Product',
			'foreignKey' => 'product_id',
			
		),
            
                'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
	);
}
