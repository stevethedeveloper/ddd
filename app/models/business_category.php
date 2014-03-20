<?php
class BusinessCategory extends AppModel {  
    var $name = 'BusinessCategory';
	var $order = "BusinessCategory.sort_order ASC";

	function get_base_categories() {
		$data = $this->findAllByParentId(0);
		$arr = array();
		foreach ($data as $cat) {
			$arr[$cat['BusinessCategory']['id']] = $cat['BusinessCategory']['name'];
		}
		return $arr;
	}

	function get_subcategories($category_id) {
		$data = $this->findAll('parent_id = '.$category_id, null, 'sort_order ASC');
		$arr = array();
		foreach ($data as $cat) {
			$arr[$cat['BusinessCategory']['id']] = $cat['BusinessCategory']['name'];
		}
		return $arr;
	}
	
	function get_all_categories() {
		$data = $this->find('threaded', array('fields' => array('id', 'parent_id', 'name')));
		$arr = array('all' => 'All Merchant Categories');
		foreach ($data as $cat) {
			$arr[$cat['BusinessCategory']['id']] = $cat['BusinessCategory']['name'];
			foreach($cat['children'] as $child) {
				$arr[$child['BusinessCategory']['id']] = '---- '.$child['BusinessCategory']['name'];
			}
		}
		//pr($arr);die;
		return $arr;
	}

	function save_categories($data) {
		$this->query("delete from businesses_business_categories where business_id = ".$data['Business']['id']);
		
		$this->query("insert into businesses_business_categories (business_id, business_category_id) values (".$data['Business']['id'].", ".$data['BusinessCategory']['base_category'].")");
		
		if (array_key_exists('subcategories', $data['BusinessCategory'])) {
			if (is_array($data['BusinessCategory']['subcategories']) && count($data['BusinessCategory']['subcategories']) > 0) {
				foreach ($data['BusinessCategory']['subcategories'] as $subcat) {
					$this->query("insert into businesses_business_categories (business_id, business_category_id) values (".$data['Business']['id'].", ".$subcat.")");
				}
			} elseif (!empty($data['BusinessCategory']['subcategories'])) {
				$this->query("insert into businesses_business_categories (business_id, business_category_id) values (".$data['Business']['id'].", ".$data['BusinessCategory']['subcategories'].")");
			}
		}
	}

	function has_subcategories($id) {
		if ($this->findCount('BusinessCategory.parent_id = '.$id) > 0) {
			return true;
		}
		return false;
	}
}
?>
