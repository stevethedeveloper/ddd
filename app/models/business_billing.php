<?php
class BusinessBilling extends AppModel {  
    var $name = 'BusinessBilling';
	var $useTable = 'business_billing';
	
    var $belongsTo = array(
        'Business' => array(
            'className'    => 'Business',
            'foreignKey'    => 'business_id'
        )
    );  

    var $validate = array(
					'card_number' => array(
						'rule' => array('cc', 'all', false, null),
						'message' => 'The credit card number you supplied was invalid.'
					),
					'zip' => array(
						'rule' => array('minLength', 1),  
						'message' => 'Please enter a zip.'
					),

				);
        
    function card_present($business_id) {
    	    $count = $this->findCount('BusinessBilling.business_id = '.$business_id);
    	    $b = $this->find('BusinessBilling.business_id = '.$business_id);
    	    if ($count > 0 && !empty($b['BusinessBilling']['card_number'])) {
    	    	    return true;
    	    }
    	    return false;
    }
}
?>
