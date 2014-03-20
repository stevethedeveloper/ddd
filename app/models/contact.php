<?php
class Contact extends AppModel {
    var $useTable = false;
    var $_schema = array(
        'first_name'		=>array('type'=>'string', 'length'=>100), 
        'last_name'		=>array('type'=>'string', 'length'=>100), 
        'company_name'		=>array('type'=>'string', 'length'=>100), 
        'email_address'		=>array('type'=>'string', 'length'=>255), 
        'phone_number'		=>array('type'=>'string', 'length'=>100), 
        'comments'	=>array('type'=>'text'),
        'enter_captcha'		=>array('type'=>'string', 'length'=>100) 
    );
	var $validate = array(
		'first_name' => array(
			'rule'=>array('minLength', 1), 
			'message'=>'First name is required.' ),
		'last_name' => array(
			'rule'=>array('minLength', 1), 
			'message'=>'Last name is required.' ),
		'email_address' => array(
			'rule'=>'email', 
			'message'=>'Please enter a valid email address.' ),
		'comments' => array(
			'rule'=>array('minLength', 1), 
			'message'=>'Please enter your comments.' ),
		'enter_captcha' => array(
			'identicalFieldValues' => array(
				'rule' => array('identicalFieldValues', 'enter_captcha' ),
				'message' => 'The code you entered did not match.',
			)
		)
	);

	function identicalFieldValues( $field=array(), $compare_field=null ) {
			foreach( $field as $key => $value ){
				$v1 = $value;
				$v2 = $_SESSION['php_captcha'];                 
				if($v1 !== $v2) {
					return FALSE;
				} else {
					continue;
				}
			}
			return TRUE;
		}
}
?>
