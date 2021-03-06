<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class FeaturedShop extends AppModel {

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
		'Shop' => array(
		  'className' => 'Shop',
		  'foreignKey' => 'shop_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		)
	);
	
}
