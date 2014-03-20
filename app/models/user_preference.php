<?php
class UserPreference extends AppModel {  
    var $name = 'UserPreference';
	
    var $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'    => 'user_id'
        )
    );  
}
?>
