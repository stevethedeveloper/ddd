<?php
	class DealsController extends AppController {
		var $name = 'Deals';
		var $uses = array('Business', 'BusinessOffer', 'BusinessBilling', 'Transaction', 'BusinessCategory', 'BusinessHappyHour');
		var $helpers = array('Form', 'Html', 'Javascript', 'Ajax');
		var $components = array('RequestHandler', 'AuthorizeNet');

		function home() {
			$categories = $this->BusinessCategory->get_all_categories();
			$this->set('categories', $categories);
			//pr($categories);die;
			//$location = '89145';
			$location = '80309';
			$this->Business->Behaviors->attach('Geocoded', array('key' => 'ABQIAAAAMU9EohqpxNREG770ZWoNWBQmGE6IU3RohcbQM2f-SteLLt6KlBTXDnrL704G3P4Od8Jlkt_uoIWE_Q'));
			$geocode = $this->Business->geocode($location);
			$this->Business->Behaviors->detach('Geocoded');

			if(!$this->RequestHandler->isAjax()) {
				$this->layout = 'default';
			}
			$flash = $this->BusinessOffer->get_all_flash($geocode['lon'], $geocode['lat'], 10);
			$this->set('flash', $flash);
			$this->set('flash_count', count($flash));
			$general = $this->BusinessOffer->get_all_general($geocode['lon'], $geocode['lat'], 10);
			$this->set('general', $general);
			$this->set('general_count', count($general));
			
			if($this->RequestHandler->isAjax()) {
				$this->data['Business']['zip'] = ($this->data['Business']['zip'] == 'Please enter a zipcode') ? '' : $this->data['Business']['zip'];
				if(!empty($this->data['Business']['zip'])) {
					$location = $this->data['Business']['zip'];
				} else {
					$location = '80309';
				}

				$this->Business->Behaviors->attach('Geocoded', array('key' => 'ABQIAAAAMU9EohqpxNREG770ZWoNWBQmGE6IU3RohcbQM2f-SteLLt6KlBTXDnrL704G3P4Od8Jlkt_uoIWE_Q'));
				$geocode = $this->Business->geocode($location);
				$this->Business->Behaviors->detach('Geocoded');
				$flash = $this->BusinessOffer->get_all_flash($geocode['lon'], $geocode['lat'], 10, $this->data['BusinessCategory']['id']);
				$this->set('flash', $flash);
				$this->set('flash_count', count($flash));
				$general = $this->BusinessOffer->get_all_general($geocode['lon'], $geocode['lat'], 10, $this->data['BusinessCategory']['id']);
				$this->set('general', $general);
				$this->set('general_count', count($general));

				$this->viewPath = 'elements'.DS;
				$this->render('widget_listings');
			}
		}
		
		function mobile() {
			$categories = $this->BusinessCategory->get_all_categories();
			$this->set('categories', $categories);
			//pr($categories);die;
			//$location = '89145';
			$location = '80309';
			$this->Business->Behaviors->attach('Geocoded', array('key' => 'ABQIAAAAMU9EohqpxNREG770ZWoNWBQmGE6IU3RohcbQM2f-SteLLt6KlBTXDnrL704G3P4Od8Jlkt_uoIWE_Q'));
			$geocode = $this->Business->geocode($location);
			$this->Business->Behaviors->detach('Geocoded');

			if(!$this->RequestHandler->isAjax()) {
				$this->layout = 'mobile';
			}
			$flash = $this->BusinessOffer->get_all_flash($geocode['lon'], $geocode['lat'], 10);
			$this->set('flash', $flash);
			$this->set('flash_count', count($flash));
			$general = $this->BusinessOffer->get_all_general($geocode['lon'], $geocode['lat'], 10);
			$this->set('general', $general);
			$this->set('general_count', count($general));
			
			if($this->RequestHandler->isAjax()) {
				$this->data['Business']['zip'] = ($this->data['Business']['zip'] == 'Please enter a zipcode') ? '' : $this->data['Business']['zip'];
				if(!empty($this->data['Business']['zip'])) {
					$location = $this->data['Business']['zip'];
				} else {
					$location = '80309';
				}

				$this->Business->Behaviors->attach('Geocoded', array('key' => 'ABQIAAAAMU9EohqpxNREG770ZWoNWBQmGE6IU3RohcbQM2f-SteLLt6KlBTXDnrL704G3P4Od8Jlkt_uoIWE_Q'));
				$geocode = $this->Business->geocode($location);
				$this->Business->Behaviors->detach('Geocoded');
				$flash = $this->BusinessOffer->get_all_flash($geocode['lon'], $geocode['lat'], 10, $this->data['BusinessCategory']['id']);
				$this->set('flash', $flash);
				$this->set('flash_count', count($flash));
				$general = $this->BusinessOffer->get_all_general($geocode['lon'], $geocode['lat'], 10, $this->data['BusinessCategory']['id']);
				$this->set('general', $general);
				$this->set('general_count', count($general));

				$this->viewPath = 'elements'.DS;
				$this->render('widget_listings');
			}
		}

		function view($id) {
			$this->layout = 'inside';

			$this->set('id', $id);

			$business = $this->Business->find('Business.id = '.$id.' and Business.plan_active = 1');

			if (empty($business['Business']['logo'])) {
				$this->set('logo', 'no_image.png');
			} else {
				$this->set('logo', LOGO_URL.$business['Business']['logo']);
			}

			$this->set('business', $business);
			
			$this->set('business_live', $this->BusinessOffer->get_live($id));
			$this->set('business_general', $this->BusinessOffer->get_general($id));

			$days = array(
						'Sunday' => 'Sunday',
						'Monday' => 'Monday',
						'Tuesday' => 'Tuesday',
						'Wednesday' => 'Wednesday',
						'Thursday' => 'Thursday',
						'Friday' => 'Friday',
						'Saturday' => 'Saturday',
						);
			$this->set('days_array', $days);

			$h = $this->BusinessHappyHour->findAll('BusinessHappyHour.business_id = '.$id);
			$this->set('happy_hours', $h);
		}
		
		function manage_add($id = null) {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');

			$b = $this->Session->read('Business');
			if ($this->Business->get_deal_count($b['id']) < 1) {
				$this->redirect('/manage/deals/purchase_pushes', null, true);
			}
			
			$this->set('deals', $this->BusinessOffer->get_all($b['id'], 100, true));
			$this->set('is_restaurant', $this->Business->is_restaurant($b['id']));
			
			
			if (!empty($this->data)) {
				$this->BusinessOffer->set($this->data);
				$res1 = $this->BusinessOffer->validates();
				if ($res1) {
					if ($this->data['BusinessOffer']['start_time']['meridian'] == 'pm') {
						if ($this->data['BusinessOffer']['start_time']['hour'] != 12) {
							$this->data['BusinessOffer']['start_time']['hour'] = $this->data['BusinessOffer']['start_time']['hour'] + 12;
						}
					} elseif ($this->data['BusinessOffer']['start_time']['hour'] == 12) {
						$this->data['BusinessOffer']['start_time']['hour'] = '00';
					}
					$this->data['BusinessOffer']['start_time'] = date('H:i:s', strtotime($this->data['BusinessOffer']['start_time']['hour'].':'.$this->data['BusinessOffer']['start_time']['min']));

					$date = $this->data['BusinessOffer']['dd_start']['year'].'-'.$this->data['BusinessOffer']['dd_start']['month'].'-'.$this->data['BusinessOffer']['dd_start']['day'];
					$this->data['BusinessOffer']['dd_start'] = $date.' '.$this->data['BusinessOffer']['start_time'];
					$end_ts = strtotime($this->data['BusinessOffer']['dd_start']);
					$duration = (($this->data['BusinessOffer']['duration_hours'] * 60) *60) + ($this->data['BusinessOffer']['duration_minutes'] * 60);
					$this->data['BusinessOffer']['dd_end'] = date('Y-m-d H:i:s', $end_ts + $duration);
					$this->data['BusinessOffer']['business_id'] = $b['id'];
					$this->data['BusinessOffer']['offer_class'] = 'Flash';
					$this->BusinessOffer->save($this->data, false);
					$id = $this->BusinessOffer->getLastInsertID();
					if ($this->_is_expired($id) === false) {
						$this->Business->subtract_deal($b['id']);
					}
					$this->Session->setFlash('Your deal has been entered.');
					$this->redirect('/manage/deals/index', null, true);
				} else {
					$this->set('title_length', strlen($this->data['BusinessOffer']['dd_title']));
					$this->set('description_length', strlen($this->data['BusinessOffer']['dd_description']));
				}
			} else {
				if ($id !== null) {
					if ($this->_is_mine($id) === true) {
						$this->data = $this->BusinessOffer->findById($id);
						$this->data['Business']['previous'] = $id;
						$this->set('title_length', strlen($this->data['BusinessOffer']['dd_title']));
						$this->set('description_length', strlen($this->data['BusinessOffer']['dd_description']));
					}
				} else {
					$this->set('title_length', 0);
					$this->set('description_length', 0);
					$this->data['BusinessOffer']['alcohol'] = 0;
				}
			}
		}

		function manage_edit($id = null) {
			if (!empty($this->data)) {
				$id = $this->data['BusinessOffer']['id'];
			}
			if ($this->_is_mine($id) === false) {
				$this->Session->setFlash('You do not have permission to modify that deal.');
				$this->redirect('/manage/deals/index', null, true);
			}
			
			$b = $this->Session->read('Business');
			$this->set('is_restaurant', $this->Business->is_restaurant($b['id']));

			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');


			if (!empty($this->data)) {
				$this->BusinessOffer->set($this->data);
				$res1 = $this->BusinessOffer->validates();
				if ($res1) {
					if ($this->data['BusinessOffer']['start_time']['meridian'] == 'pm') {
						if ($this->data['BusinessOffer']['start_time']['hour'] != 12) {
							$this->data['BusinessOffer']['start_time']['hour'] = $this->data['BusinessOffer']['start_time']['hour'] + 12;
						}
					} elseif ($this->data['BusinessOffer']['start_time']['hour'] == 12) {
						$this->data['BusinessOffer']['start_time']['hour'] = '00';
					}
					$this->data['BusinessOffer']['start_time'] = date('H:i:s', strtotime($this->data['BusinessOffer']['start_time']['hour'].':'.$this->data['BusinessOffer']['start_time']['min']));

					$date = $this->data['BusinessOffer']['dd_start']['year'].'-'.$this->data['BusinessOffer']['dd_start']['month'].'-'.$this->data['BusinessOffer']['dd_start']['day'];
					$this->data['BusinessOffer']['dd_start'] = $date.' '.$this->data['BusinessOffer']['start_time'];
					$end_ts = strtotime($this->data['BusinessOffer']['dd_start']);
					$duration = (($this->data['BusinessOffer']['duration_hours'] * 60) *60) + ($this->data['BusinessOffer']['duration_minutes'] * 60);
					$this->data['BusinessOffer']['dd_end'] = date('Y-m-d H:i:s', $end_ts + $duration);

					$this->data['BusinessOffer']['offer_class'] = 'Flash';
					$this->BusinessOffer->save($this->data, false);
					$this->Session->setFlash('Your changes have been saved.');
					$this->redirect('/manage/deals/index', null, true);
				} else {
					$this->set('title_length', strlen($this->data['BusinessOffer']['dd_title']));
					$this->set('description_length', strlen($this->data['BusinessOffer']['dd_description']));
				}
			} else {
				$this->data = $this->BusinessOffer->findById($id);
				$this->data['BusinessOffer']['start_time'] = $this->data['BusinessOffer']['dd_start']; 
				$this->data['BusinessOffer']['end_time'] = $this->data['BusinessOffer']['dd_end']; 
				$this->set('title_length', strlen($this->data['BusinessOffer']['dd_title']));
				$this->set('description_length', strlen($this->data['BusinessOffer']['dd_description']));
				$start = strtotime($this->data['BusinessOffer']['start_time']);
				$end = strtotime($this->data['BusinessOffer']['end_time']);
				$diff = $end - $start;
				$this->data['BusinessOffer']['duration_hours'] = floor($diff/60/60);
				$this->data['BusinessOffer']['duration_minutes'] = ($diff/60)%60;
			}
		}

		function manage_add_everyday() {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');

			$b = $this->Session->read('Business');
			if (!empty($this->data)) {
				$this->BusinessOffer->set($this->data);
				$res1 = $this->BusinessOffer->validates();
				if ($res1) {
					$this->BusinessOffer->query("delete from business_offers where business_id = ".$b['id']." and offer_class = 'General'");
					$this->data['BusinessOffer']['business_id'] = $b['id'];
					$this->data['BusinessOffer']['offer_class'] = 'General';
					$this->BusinessOffer->save($this->data, false);
					$this->Session->setFlash('Your changes have been saved.');
					$this->redirect('/manage/deals/index', null, true);
				} else {
					$this->set('title_length', strlen($this->data['BusinessOffer']['dd_title']));
					$this->set('description_length', strlen($this->data['BusinessOffer']['dd_description']));
				}
			
			} else {
				$this->set('title_length', 0);
				$this->set('description_length', 0);
			}
		}

		function manage_edit_everyday() {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');

			$b = $this->Session->read('Business');
			if (!empty($this->data)) {
				$this->BusinessOffer->set($this->data);
				$res1 = $this->BusinessOffer->validates();
				if ($res1) {
					$this->BusinessOffer->query("delete from business_offers where business_id = ".$b['id']." and offer_class = 'General'");
					$this->data['BusinessOffer']['business_id'] = $b['id'];
					$this->data['BusinessOffer']['offer_class'] = 'General';
					$this->BusinessOffer->save($this->data, false);
					$this->Session->setFlash('Your changes have been saved.');
					$this->redirect('/manage/deals/index', null, true);
				} else {
					$this->set('title_length', strlen($this->data['BusinessOffer']['dd_title']));
					$this->set('description_length', strlen($this->data['BusinessOffer']['dd_description']));
				}
			
			} else {
				$this->data = $this->BusinessOffer->find("BusinessOffer.business_id = ".$b['id']." and offer_class = 'General'");
				$this->set('title_length', strlen($this->data['BusinessOffer']['dd_title']));
				$this->set('description_length', strlen($this->data['BusinessOffer']['dd_description']));
			}
		}

		function manage_delete_everyday() {
			$b = $this->Session->read('Business');
			$this->BusinessOffer->query("delete from business_offers where business_id = ".$b['id']." and offer_class = 'General'");
			$this->Session->setFlash('Everyday Deal deleted.');
			$this->redirect('/manage/deals/index', null, true);
		}

		function manage_index() {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');

			$b = $this->Session->read('Business');
			if (empty($b['logo'])) {
				$this->set('logo', 'no_image.png');
			} else {
				$this->set('logo', LOGO_URL.$b['logo']);
			}
			$business = $this->Business->findById($b['id']);
			$remaining = $business['Business']['subscription_deals'] + $business['Business']['purchased_deals'];
			$this->set('remaining', $remaining);
			$this->set('expiration', $business['Business']['plan_next_bill_date']);
			$this->set('business', $business);
			
			$this->set('live', $this->BusinessOffer->get_live($b['id']));
			$this->set('scheduled', $this->BusinessOffer->get_scheduled($b['id']));
			$this->set('expired', $this->BusinessOffer->get_expired($b['id']));
			$this->set('general', $this->BusinessOffer->get_general($b['id']));
		}

		function manage_delete($id = null) {
			if ($this->_is_mine($id) === false) {
				$this->Session->setFlash('You do not have permission to modify that deal.');
				$this->redirect('/manage/deals/index', null, true);
			}
			
			$this->BusinessOffer->query("update business_offers set date_deleted = '".date("Y-m-d H:i:s")."' where id = $id");
			$this->Session->setFlash('Offer deleted.');
			$this->redirect('/manage/deals/index', null, true);
		}
		
		function manage_cancel($id = null) {
			if ($this->_is_mine($id) === false) {
				$this->Session->setFlash('You do not have permission to modify that deal.');
				$this->redirect('/manage/deals/index', null, true);
			}
			
			if ($this->_is_live($id) === false && $this->_is_expired($id) === false) {
				$b = $this->Session->read('Business');
				$this->Business->add_deal($b['id']);
			}
			$this->BusinessOffer->query("update business_offers set date_canceled = '".date("Y-m-d H:i:s")."' where id = $id");
			$this->Session->setFlash('Offer canceled.');
			$this->redirect('/manage/deals/index', null, true);
		}

		function manage_purchase_pushes() {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');
		
			$b = $this->Session->read('Business');
			if (empty($b['logo'])) {
				$this->set('logo', 'no_image.png');
			} else {
				$this->set('logo', LOGO_URL.$b['logo']);
			}
			$business = $this->Business->findById($b['id']);
			$this->set('b', $business);
			
			if (!empty($this->data)) {
				$price = 25;
				$last_day_of_month = date('t', mktime(0, 0, 0, $this->data['BusinessBilling']['expiration_date']['month'], 1, $this->data['BusinessBilling']['expiration_date']['year']));
				$this->data['BusinessBilling']['expiration_date']['day'] = $last_day_of_month; 

				if (!(array_key_exists('upgrade_check', $this->data['Business']) && $this->data['Business']['upgrade_check'] == 1)) {
					$billinginfo = $shippinginfo = array("fname" => $business['Business']['first_name'],
						"lname" => $business['Business']['last_name'],
						"address" => $business['Business']['address1'],
						"city" => $business['Business']['city'],
						"state" => $business['Business']['state'],
						"zip" => $business['Business']['zip'],
						"country" => "USA");
					$response = $this->AuthorizeNet->chargeCard('[removed]', '[removed]', '[removed]', $this->data['BusinessBilling']['expiration_date']['month'], $this->data['BusinessBilling']['expiration_date']['year'], null, true, $this->data['Business']['number_pushes'] * $price, null, null, "Push Purchase (".$this->data['Business']['number_pushes'].")", $billinginfo, $business['Business']['email'], $business['Business']['phone'], $shippinginfo);
	
					if ($response[1] != 1) {
						$this->BusinessBilling->invalidate('card');
						$this->Session->setFlash($response[4]);
						$this->BusinessBilling->set($this->data);
						$res2 = $this->BusinessBilling->validates();
					}
					$this->BusinessBilling->set($this->data);
					$res2 = $this->BusinessBilling->validates();
				} else {
					$res2 = 1;
				}
				

				if ($res2) {

					if (array_key_exists('upgrade_check', $this->data['Business']) && $this->data['Business']['upgrade_check'] == 1) {
						$data['BusinessBilling']['business_id'] = $b['id'];
						if ($this->Business->can_change_plan($b['id']) === true) {
							//$this->BusinessBilling->save($data, false);

							$difference = $this->Business->deal_counts[$this->data['Business']['plan']] - $this->Business->deal_counts[$business['Business']['plan']];
							$this->Business->query("update businesses set subscription_deals = subscription_deals + ".$difference.", plan = '".$this->data['Business']['plan']."' where id = ".$b['id']);
	
                                                	$this->data['Transaction']['business_id'] = $b['id'];
							$this->data['Transaction']['transaction_type'] = 'Plan Change';
							$this->data['Transaction']['description'] = 'from '.$b['plan'].' to '.$this->data['Business']['plan'];
							$this->data['Transaction']['quantity'] = 1;
							$this->data['Transaction']['unit_price'] = 0;
							$this->data['Transaction']['billing_zip'] = $this->data['BusinessBilling']['billing_zip'];
							$this->data['Transaction']['description'] = $this->data['Business']['plan'];
							$this->Transaction->save($this->data);
							$message = 'Thank you for your upgrade.';
						} else {
							$this->Session->setFlash('We could not change your plan.  Plans can only be changed once per billing cycle.<br />For assistance, please call (303) 506-4306.');
							$this->redirect('/manage/deals/index', null, true);
						}
					} else {
						$this->Business->query("update businesses set purchased_deals = purchased_deals + ".$this->data['Business']['number_pushes']." where id = ".$b['id']);
						$this->data['Transaction']['business_id'] = $b['id'];
						$this->data['Transaction']['transaction_type'] = 'Push Purchase';
						$this->data['Transaction']['quantity'] = $this->data['Business']['number_pushes'];
						$this->data['Transaction']['unit_price'] = $price;
						$this->data['Transaction']['billing_zip'] = $this->data['BusinessBilling']['billing_zip'];
						$this->Transaction->save($this->data);
						$message = 'Thank you for your purchase.';
					}
					
					$b = $this->Business->find('id = '.$b['id']);
					$this->Session->write('Business', $b['Business']);

					$this->Session->setFlash($message);
					$this->redirect('/manage/deals/index', null, true);
				}
			}
		}
		
		function _is_mine($id) {
			$b = $this->Session->read('Business');

			if ($this->BusinessOffer->findCount("BusinessOffer.id = $id and BusinessOffer.business_id = ".$b['id']) > 0) {
				return true;
			}
			return false;
		}

		function _is_live($id) {
			$now = date("Y-m-d H:i:s");
			$count = $this->BusinessOffer->find("BusinessOffer.id = ".$id." and (dd_start <= '$now' and dd_end >= '$now') and offer_class = 'Flash' and BusinessOffer.date_canceled is null and BusinessOffer.date_deleted is null");
			if ($count > 0) {
				return true;
			}
			return false;
		}

		function _is_expired($id) {
			$now = date("Y-m-d H:i:s");
			$count = $this->BusinessOffer->findCount("BusinessOffer.id = $id and ((dd_end < '$now' and offer_class = 'Flash' and BusinessOffer.date_canceled is null and BusinessOffer.date_deleted is null) or (BusinessOffer.date_canceled is not null))", null, "BusinessOffer.dd_start desc");
			if ($count > 0) {
				return true;
			}
			return false;
		}
	}
?>
