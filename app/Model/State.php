<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class State extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);

	public $belongsTo = array(
		'Country' => array(
		  'className' => 'Country',
		  'foreignKey' => 'country_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		)
	);
	
	public $hasMany = array(
		'City' => array(
		    'className' => 'City',
		    'foreignKey' => 'state_id',
		    'dependent' => false,
		    'conditions' => '',
		    'fields' => '',
		    'order' => '',
		    'limit' => '',
		    'offset' => '',
		    'exclusive' => '',
		    'finderQuery' => '',
		    'counterQuery' => ''
		),
		'Area' => array(
		    'className' => 'Area',
		    'foreignKey' => 'state_id',
		    'dependent' => false,
		    'conditions' => '',
		    'fields' => '',
		    'order' => '',
		    'limit' => '',
		    'offset' => '',
		    'exclusive' => '',
		    'finderQuery' => '',
		    'counterQuery' => ''
		),
            'SpaAddress' => array(
		    'className' => 'SpaAddress',
		    'foreignKey' => 'state_id',
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
	);       
}
