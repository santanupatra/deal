<?php
/**
 * AvailabilityFixture
 *
 */
class AvailabilityFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'any_time_email' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'has_fixed_routine' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'monday_from' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'monday_to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'monday_any_time' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'tuesday_from' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'tuesday_to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'tuesday_any_time' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'wednesday_from' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'wednesday_to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'wednesday_any_time' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'thursday_from' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'thursday_to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'thursday_any_time' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'friday_from' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'friday_to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'friday_any_time' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'saturday_from' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'saturday_to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'saturday_any_time' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'sunday_from' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sunday_to' => array('type' => 'string', 'null' => false, 'default' => null, 'length' => 50, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sunday_any_time' => array('type' => 'boolean', 'null' => false, 'default' => '0'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'user_id' => 1,
			'any_time_email' => 1,
			'has_fixed_routine' => 1,
			'monday_from' => 'Lorem ipsum dolor sit amet',
			'monday_to' => 'Lorem ipsum dolor sit amet',
			'monday_any_time' => 1,
			'tuesday_from' => 'Lorem ipsum dolor sit amet',
			'tuesday_to' => 'Lorem ipsum dolor sit amet',
			'tuesday_any_time' => 1,
			'wednesday_from' => 'Lorem ipsum dolor sit amet',
			'wednesday_to' => 'Lorem ipsum dolor sit amet',
			'wednesday_any_time' => 1,
			'thursday_from' => 'Lorem ipsum dolor sit amet',
			'thursday_to' => 'Lorem ipsum dolor sit amet',
			'thursday_any_time' => 1,
			'friday_from' => 'Lorem ipsum dolor sit amet',
			'friday_to' => 'Lorem ipsum dolor sit amet',
			'friday_any_time' => 1,
			'saturday_from' => 'Lorem ipsum dolor sit amet',
			'saturday_to' => 'Lorem ipsum dolor sit amet',
			'saturday_any_time' => 1,
			'sunday_from' => 'Lorem ipsum dolor sit amet',
			'sunday_to' => 'Lorem ipsum dolor sit amet',
			'sunday_any_time' => 1
		),
	);

}
