<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class PackageRequest extends AppModel {

/**
 * Validation rules
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
		'Package' => array(
		  'className' => 'Package',
		  'foreignKey' => 'package_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		)
	);
	  
}
