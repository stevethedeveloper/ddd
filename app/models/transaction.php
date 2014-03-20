<?php
class Transaction extends AppModel {  
    var $name = 'Transaction';
	
    var $belongsTo = array(
        'Business' => array(
            'className'    => 'Business',
            'foreignKey'    => 'business_id'
        )
    );  
}
?>
