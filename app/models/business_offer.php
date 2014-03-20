<?php
class BusinessOffer extends AppModel {  
	var $name = 'BusinessOffer';
	
	var $belongsTo = array(
		'Business' => array(
		'className'    => 'Business',
		'foreignKey'    => 'business_id'
		)
	);  

	    var $validate = array(
		'dd_title' => array(
		    'rule' => array('minLength', '1'),
		    'message' => 'Please enter a title.'
		),
		'dd_description' => array(
		    'rule' => array('minLength', '1'),
		    'message' => 'Please enter a description.'
		),
		'start_time' => array(
		    'rule' => array('required_time', 'start_time'),
		    'message' => 'Please enter a start time.'
		),
		'end_time' => array(
		    'rule' => array('required_time', 'end_time'),
		    'message' => 'Please enter an end time.'
		),
	    );
	    
	    function required_time($val, $field) {
	    	    if (empty($val[$field]['hour']) || strlen($val[$field]['min']) < 1 || empty($val[$field]['meridian'])) {
	    	    	    //pr($val);die;
	    	    	    return false;
	    	    }
	    	    return true;
	    }

	function get_live($id) {
		$now = date("Y-m-d H:i:s");
        	return $this->findAll("BusinessOffer.business_id = $id and (dd_start <= '$now' and dd_end >= '$now') and offer_class = 'Flash' and BusinessOffer.date_canceled is null and BusinessOffer.date_deleted is null", null, "BusinessOffer.dd_start desc");
        }

        function get_scheduled($id) {
		$now = date("Y-m-d H:i:s");
        	return $this->findAll("BusinessOffer.business_id = $id and dd_start > '$now' and offer_class = 'Flash' and BusinessOffer.date_canceled is null and BusinessOffer.date_deleted is null", null, "BusinessOffer.dd_start desc");
        }

        function get_expired($id) {
		$now = date("Y-m-d H:i:s");
        	return $this->findAll("BusinessOffer.business_id = $id and ((dd_end < '$now' and offer_class = 'Flash' and BusinessOffer.date_canceled is null and BusinessOffer.date_deleted is null) or (BusinessOffer.date_canceled is not null))", null, "BusinessOffer.dd_start desc", 5);
        }

        function get_general($id) {
		$now = date("Y-m-d H:i:s");
        	return $this->findAll("BusinessOffer.business_id = $id and offer_class = 'General' and BusinessOffer.date_canceled is null and BusinessOffer.date_deleted is null", null, "BusinessOffer.dd_start desc", 1);
        }

        function get_all($id, $limit = 100, $make_list = false) {
        	$ret = $this->findAll("BusinessOffer.business_id = $id and BusinessOffer.offer_class = 'Flash' and BusinessOffer.date_deleted is null", null, "BusinessOffer.dd_start desc", $limit);
        	
        	if ($make_list === false) {
        		return $ret;
        	} else {
        		$arr = array();
        		$arr[0] = 'Start from a previous offer';
        		foreach ($ret as $d) {
        			$arr[$d['BusinessOffer']['id']] = date('n/j/Y', strtotime($d['BusinessOffer']['dd_start'])).' - '.$d['BusinessOffer']['dd_title'];
        		}
        		return $arr;
        	}
        }

        function get_all_flash($lon, $lat, $miles = 10, $category = null) {
        	$now = date("Y-m-d H:i:s");
        	if ($category !== null && $category != 'all') {
        		$cat = "and BusinessesBusinessCategory.business_category_id = '$category'";
        	} else {
        		$cat = null;
        	}
        	$ret = $this->query("select *, ((ACOS(SIN($lat * PI() / 180) * SIN(latitude * PI() / 180) + COS($lat * PI() / 180) * COS(latitude * PI() / 180) * COS(($lon - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance from businesses Business, business_offers BusinessOffer, businesses_business_categories BusinessesBusinessCategory where Business.id = BusinessOffer.business_id and Business.id = BusinessesBusinessCategory.business_id $cat and Business.plan_active = 1 and Business.plan not like 'free' and (dd_start <= '$now' and dd_end >= '$now') and offer_class = 'Flash' and BusinessOffer.date_canceled is null and BusinessOffer.date_deleted is null GROUP BY Business.id HAVING distance<='$miles' ORDER BY distance ASC");
		return $ret;
        }

        function get_all_general($lon, $lat, $miles = 10, $category = null) {
        	if ($category !== null && $category != 'all') {
        		$cat = "and BusinessesBusinessCategory.business_category_id = '$category'";
        	} else {
        		$cat = null;
        	}
        	$ret = $this->query("select *, ((ACOS(SIN($lat * PI() / 180) * SIN(latitude * PI() / 180) + COS($lat * PI() / 180) * COS(latitude * PI() / 180) * COS(($lon - longitude) * PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance from businesses Business, business_offers BusinessOffer, businesses_business_categories BusinessesBusinessCategory where Business.id = BusinessOffer.business_id and Business.id = BusinessesBusinessCategory.business_id $cat and Business.plan_active = 1 and offer_class = 'General' and BusinessOffer.date_canceled is null and BusinessOffer.date_deleted is null GROUP BY Business.id HAVING distance<='$miles' ORDER BY distance ASC");
		return $ret;
        }
}
?>
