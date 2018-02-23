<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class Area extends AppModel {

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
		),
		'City' => array(
		  'className' => 'City',
		  'foreignKey' => 'city_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		)
	);
        public $hasMany = array(
		
            'SpaAddress' => array(
		    'className' => 'SpaAddress',
		    'foreignKey' => 'area_id',
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
