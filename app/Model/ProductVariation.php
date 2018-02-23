<?php
App::uses('AppModel', 'Model');
/**
 * EmailTemplate Model
 *
 */
class ProductVariation extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		
	);
        
        public $belongsTo = array(
		'Color' => array(
		  'className' => 'Color',
		  'foreignKey' => 'color_id',
		  
		)
		
	);
	
}
