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
            'Seller' => array(
                    'className' => 'User',
                    'foreignKey' => 'coupon_owner_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
            ),
            
            'Coupon' => array(
                    'className' => 'Coupon',
                    'foreignKey' => 'coupon_id',
                    'conditions' => '',
                    'fields' => '',
                    'order' => ''
            )
            
	);

}
