<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class Spa extends AppModel {

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
//		'SpaType' => array(
//		  'className' => 'SpaType',
//		  'foreignKey' => 'spa_type_id',
//		  'conditions' => '',
//		  'fields' => '',
//		  'order' => ''
//		),
//		'PamperType' => array(
//		  'className' => 'PamperType',
//		  'foreignKey' => 'pamper_type_id',
//		  'conditions' => '',
//		  'fields' => '',
//		  'order' => ''
//		),
//		'FitType' => array(
//		  'className' => 'FitType',
//		  'foreignKey' => 'fit_type_id',
//		  'conditions' => '',
//		  'fields' => '',
//		  'order' => ''
//		)
	);
	
	public $hasMany = array(
		'SpaImage' => array(
		    'className' => 'SpaImage',
		    'foreignKey' => 'spa_id',
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
		'Treatment' => array(
		    'className' => 'Treatment',
		    'foreignKey' => 'spa_id',
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
		'Package' => array(
		    'className' => 'Package',
		    'foreignKey' => 'spa_id',
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
		    'foreignKey' => 'spa_id',
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
            'Schedule' => array(
		    'className' => 'Schedule',
		    'foreignKey' => 'spa_id',
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
	);       
}
