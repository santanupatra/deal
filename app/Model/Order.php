<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
 * @property User $User
 */
class Order extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
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
            'Shop' => array(
                    'className' => 'Shop',
                    'foreignKey' => 'store_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
            )
	);

}
