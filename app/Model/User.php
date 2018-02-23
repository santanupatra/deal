<?php
App::uses('AppModel', 'Model');
App::uses('SimplePasswordHasher', 'Controller/Component/Auth');
/**
 * User Model
 *
 * @property Availability $Availability
 * @property InboxMessage $InboxMessage
 * @property PreviousMaking $PreviousMaking
 * @property Request $Request
 * @property Review $Review
 * @property SentMessage $SentMessage
 * @property Skill $Skill
 * @property Wishlist $Wishlist
 */
class User extends AppModel {

/**
 * Validation rules
 *
 * @var array
 */
       public $virtualFields = array(
	    'name' => 'CONCAT(User.first_name, " ", User.last_name)'
	);

       public function beforeSave($options = array()) {
	  if (isset($this->data[$this->alias]['password'])) {
		$passwordHasher = new SimplePasswordHasher();
		$this->data[$this->alias]['password'] = $passwordHasher->hash(
		    $this->data[$this->alias]['password']
		);
	  }
	  return true;
	}
	
	public $validate = array();

        function matchCaptcha($inputValue) {
	  return $inputValue['captcha']==$this->getCaptcha();
	}

	function setCaptcha($value) {
	  $this->captcha = $value;
	}

	function getCaptcha() {
	  return $this->captcha;
	}
	function get_fpassword()
	{
		$length = 8;
		$chars =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.'0123456789';
		$str = '';
		$max = strlen($chars) - 1;
		for ($i=0; $i < $length; $i++)
		$str .= $chars[rand(0, $max)];
		return $str;
	}

/**
 * hasMany associations
 *
 * @var array
 */
        
        
        public $belongsTo = array(
		
		
	);
        
	public $hasMany = array(
	);

}
