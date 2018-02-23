<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class Advertisement extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);

	public $belongsTo = array(
            'Package' => array(
                'className' => 'Package',
                'foreignKey' => 'package_id',
                'conditions' => '',
                'fields' => '',
                'order' => ''
            )
	);
	  
}
