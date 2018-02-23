<?php
App::uses('SkillImage', 'Model');

/**
 * SkillImage Test Case
 *
 */
class SkillImageTest extends CakeTestCase {

/**
 * Fixtures
 *
 * @var array
 */
	public $fixtures = array(
		'app.skill_image',
		'app.skill'
	);

/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		parent::setUp();
		$this->SkillImage = ClassRegistry::init('SkillImage');
	}

/**
 * tearDown method
 *
 * @return void
 */
	public function tearDown() {
		unset($this->SkillImage);

		parent::tearDown();
	}

}
