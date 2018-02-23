<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class Message extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);

	public $belongsTo = array(
		/*'User' => array(
		  'className' => 'User',
		  'foreignKey' => 'user_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		),
		'Spa' => array(
		  'className' => 'Spa',
		  'foreignKey' => 'spa_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		)*/
	);
	  
}
