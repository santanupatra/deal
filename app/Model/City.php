<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class City extends AppModel {

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
		),
		'State' => array(
		  'className' => 'State',
		  'foreignKey' => 'state_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		)
	);
	public $hasMany = array(
		'Area' => array(
		    'className' => 'Area',
		    'foreignKey' => 'city_id',
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
		    'foreignKey' => 'city_id',
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
