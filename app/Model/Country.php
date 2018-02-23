<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class Country extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);
	
	public $hasMany = array(
		'State' => array(
		    'className' => 'State',
		    'foreignKey' => 'country_id',
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
		'City' => array(
		    'className' => 'City',
		    'foreignKey' => 'country_id',
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
		/*'Area' => array(
		    'className' => 'Area',
		    'foreignKey' => 'country_id',
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
		    'foreignKey' => 'country_id',
		    'dependent' => false,
		    'conditions' => '',
		    'fields' => '',
		    'order' => '',
		    'limit' => '',
		    'offset' => '',
		    'exclusive' => '',
		    'finderQuery' => '',
		    'counterQuery' => ''
		)*/
	);       
}
