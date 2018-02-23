<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class SpaImage extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);

	public $belongsTo = array(
		'Spa' => array(
		  'className' => 'Spa',
		  'foreignKey' => 'spa_id',
		  'conditions' => '',
		  'fields' => '',
		  'order' => ''
		)
	);
}
