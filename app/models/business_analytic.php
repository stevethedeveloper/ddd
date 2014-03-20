<?php
class BusinessAnalytic extends AppModel {  
    var $name = 'BusinessAnalytic';
	
    var $belongsTo = array(
        'Business' => array(
            'className'    => 'Business',
            'foreignKey'    => 'business_id'
        ),
        'BusinessOffer' => array(
            'className'    => 'Business',
            'foreignKey'    => 'business_offer_id'
        )

    );  
}
?>
