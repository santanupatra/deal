<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class Advertise extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);

	/*public $belongsTo = array(
		'Advertise' => array(
		  'className' => 'User',
		  'foreignKey' => 'user_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		),
		
	);*/
	public $hasMany = array(
	);   
}
