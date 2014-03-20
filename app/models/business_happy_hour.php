<?php
class BusinessHappyHour extends AppModel {  
    var $name = 'BusinessHappyHour';
	
    var $belongsTo = array(
        'Business' => array(
            'className'    => 'Business',
            'foreignKey'    => 'business_id'
        )
    );  
}
?>
