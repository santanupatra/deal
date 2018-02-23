<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class Shop extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);

	public $belongsTo = array(
		'User' => array(
		  'className' => 'User',
		  'foreignKey' => 'user_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		),
		
	);
	/*public $hasMany = array(
		'Product' => array(
		    'className' => 'Product',
		    'foreignKey' => 'product_id',
		    'dependent' => false,
		    'conditions' => '',
		    'fields' => '',
		    'order' => '',
		    'limit' => '',
		    'offset' => '',
		    'exclusive' => '',
		    'finderQuery' => '',
		    'counterQuery' => ''
		)
	);   */    
}
