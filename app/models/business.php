<?php
class Business extends AppModel {  
    var $name = 'Business';
	
	var $hasMany = array(
        'BusinessOffer' => array(
            'className'  => 'BusinessOffer',
            'foreignKey' => 'business_id',
            'order'      => 'BusinessOffer.created DESC'
        ),
        'BusinessHappyHour' => array(
            'className'  => 'BusinessHappyHour',
            'foreignKey' => 'business_id',
            'order'      => 'BusinessHappyHour.created DESC'
        ),
        'Transaction' => array(
            'className'  => 'Transaction',
            'foreignKey' => 'business_id',
            'order'      => 'Transaction.created DESC'
        ),
        'BusinessAnalytic' => array(
            'className'  => 'BusinessAnalytic',
            'foreignKey' => 'business_id',
            'order'      => 'BusinessAnalytic.created DESC'
        )

    );

    var $validate = array(
					'password' => array(
						'identicalFieldValues' => array(
							'rule' => array('identicalFieldValues', 'password2' ),
							'message' => 'The passwords you entered did not match.',
						),
						'alphaNumeric' => array(
							'rule' => 'alphaNumeric',
							'required' => true,
							'message' => 'Alphabets and numbers only'
							),
						'between' => array(
							'rule' => array('between', 5, 150),
							'message' => 'Please enter a password between 5 and 15 characters'
						)
					),
					'username' => array(
						'alphaNumeric' => array(
							'rule' => 'alphaNumeric',
							'required' => true,
							'message' => 'Alphabets and numbers only'
							),
						'between' => array(
							'rule' => array('between', 5, 15),
							'message' => 'Please enter a username between 5 and 15 characters'
						),
						'unique' => array(
							'rule' => 'isUnique',
							'message' => 'This username has already been taken.'
						)
					),
					'email' => array(
							'validemail' => array(
								'rule' => array('email', true),
								'message' => 'Please supply a valid email address.'
							),
					),
					'first_name' => array(
						'rule' => array('minLength', 1),  
						'message' => 'Please enter a first name.'
					),
					'last_name' => array(
						'rule' => array('minLength', 1),  
						'message' => 'Please enter a last name.'
					),
					'business_name' => array(
						'rule' => array('minLength', 1),  
						'message' => 'Please enter a business name.'
					),
					'address1' => array(
						'rule' => array('minLength', 1),  
						'message' => 'Please enter an address.'
					),
					'city' => array(
						'rule' => array('minLength', 1),  
						'message' => 'Please enter a city.'
					),
					'state' => array(
						'rule' => array('minLength', 1),  
						'message' => 'Please select a state.'
					),
					'zip' => array(
						'rule' => array('minLength', 1),  
						'message' => 'Please enter a zip.'
					),

				);
        
	var $actsAs = array('Geocoded' => array(
		'key' => 'ABQIAAAAMU9EohqpxNREG770ZWoNWBRmMLQO03eEdhPxREpCOo5mhkfejhQff0_9QX0hyZK_RLyojb1v8LNECg'
	));

	var $deal_counts = array(
			'Free' => 0,
			'Personal' => 4,
			'Basic' => 7,
			'Plus' => 14,
			'Premium' => 21,
			'Trial' => 14
		);
	
	var $deal_prices = array(
			'Free' => 0,
			'Personal' => 49,
			'Basic' => 149,
			'Plus' => 249,
			'Premium' => 349,
			'Trial' => 0,
		);

	function beforeSave() {
		if ($coords = $this->geocode($this->data)) {
			$this->set($coords);
			$this->data['Business']['longitude'] = $coords['lon'];
			$this->data['Business']['latitude'] = $coords['lat'];
		}
		return true;
	}

	function identicalFieldValues( $field=array(), $compare_field=null ) {
			foreach( $field as $key => $value ){
				$v1 = $value;
				$v2 = $this->data[$this->name][ $compare_field ];                 
				if($v1 !== $v2) {
					return FALSE;
				} else {
					continue;
				}
			}
			return TRUE;
		}
        
	function get_categories($id) {
		$data = $this->query("select * from businesses_business_categories BusinessBusinessCategory, business_categories BusinessCategory where BusinessBusinessCategory.business_category_id = BusinessCategory.id and BusinessBusinessCategory.business_id = $id");
		$arr = array();
		foreach ($data as $cat) {
			$arr[$cat['BusinessCategory']['id']] = $cat['BusinessCategory']['name'];
		}
		return $arr;
	}
	
	function find_similar_businesses($data) {
		return $this->query("SELECT * FROM businesses Business WHERE MATCH (business_name, address1) AGAINST ('".$data['Business']['business_name']." ".$data['Business']['address1']."') AND zip = '".$data['Business']['zip']."' AND username = ''");
	}

	function get_remaining_count($id) {
		$business = $this->findById($id);
		
		$plan = $business['Business']['plan'];
		$last_billed = $business['Business']['plan_last_bill_date'];
		
		$used = $this->BusinessOffer->findCount("BusinessOffer.business_id = $id and dd_start >= '".$last_billed." 00:00:00' and offer_class = 'Flash'");
		return $this->deal_counts[$plan] - $used;
	}

	function is_restaurant($id) {
		$data = $this->query("select * from businesses_business_categories where business_id = $id and business_category_id = 1");
		if (count($data) > 0) {
			return true;
		}
		return false;
	}
	
	function subtract_deal($id) {
		$b = $this->findById($id);
		if ($b['Business']['subscription_deals'] < 1) {
			$this->query("update businesses set purchased_deals = purchased_deals - 1 where id = $id");
		} else {
			$this->query("update businesses set subscription_deals = subscription_deals - 1 where id = $id");
		}
	}

	function add_deal($id) {
		$b = $this->findById($id);
		if ($b['Business']['subscription_deals'] < 1) {
			$this->query("update businesses set purchased_deals = purchased_deals + 1 where id = $id");
		} else {
			$this->query("update businesses set subscription_deals = subscription_deals + 1 where id = $id");
		}
	}

	function get_deal_count($id) {
		$b = $this->findById($id);
		return $b['Business']['subscription_deals'] + $b['Business']['purchased_deals'];
	}
	
	function can_change_plan($id) {
		$b = $this->findById($id);
		$last_bill_date = $b['Business']['plan_last_bill_date'].' 00:00:00';

		$count = $this->Transaction->findCount("Transaction.business_id = $id and Transaction.created >= '$last_bill_date' and (transaction_type = 'Plan Change' or transaction_type = 'Signup')");
		if ($count > 0) {
			return false;
		}
		return true;
	}
}
?>
