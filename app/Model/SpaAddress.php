<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class SpaAddress extends AppModel {

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
		'Country' => array(
		  'className' => 'Country',
		  'foreignKey' => 'country_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		),
            'State' => array(
		  'className' => 'State',
		  'foreignKey' => 'state_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		),
            'City' => array(
		  'className' => 'City',
		  'foreignKey' => 'city_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		),
            'Area' => array(
		  'className' => 'Area',
		  'foreignKey' => 'area_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		),
	);
	
	public $hasMany = array(
		
	);       
}
