<?php
	class BusinessesController extends AppController {
		var $name = 'Businesses';
		var $uses = array('Business', 'BusinessBilling', 'BusinessCategory', 'Transaction', 'BusinessOffer', 'Contact');
		var $helpers = array('Form', 'Html', 'StatesList', 'Javascript', 'Ajax');
		var $components = array('Upload', 'RequestHandler', 'Email', 'Captcha');

		function signup($plan = null) {
			$this->layout = 'inside';
			$this->set('header_name', 'business_signup');

			$this->set('prices', $this->prices);

			if (!empty($this->data)) {
				if ($this->data['Business']['plan'] != 'free' && $this->data['Business']['plan'] != 'plus') {
					$last_day_of_month = date('t', mktime(0, 0, 0, $this->data['BusinessBilling']['expiration_date']['month'], 1, $this->data['BusinessBilling']['expiration_date']['year']));
					$this->data['BusinessBilling']['expiration_date']['day'] = $last_day_of_month;
				}

				$this->set('plan', $this->data['Business']['plan']);
				$this->Business->set($this->data);
				$res1 = $this->Business->validates();
				
				if ($this->data['Business']['plan'] != 'free' && $this->data['Business']['plan'] != 'plus') {

					//go ahead and enter the record, if they don't complete signup we can delete the record during daily billing
					App::import('Vendor', 'authorizenet/cim');
					
					$refId = mktime();
					$firstName = $this->data['Business']['first_name'];
					$lastName = $this->data['Business']['last_name'];
					$company = $this->data['Business']['business_name'];
					$email = $this->data['Business']['email'];
					$cardNumber = $this->data['BusinessBilling']['card_number'];
					$expirationDate = $this->data['BusinessBilling']['expiration_date']['year'].'-'.$this->data['BusinessBilling']['expiration_date']['month'];
					
					$content = an_format_xml_create(AN_LOGINNAME, AN_TRANSACTIONKEY, $refId, $email, $firstName, $lastName, $company, $cardNumber, $expirationDate, 'liveMode');
					$response = send_request_via_curl(AN_HOST, AN_PATH, $content);
					if ($response) {
						list ($refId, $resultCode, $code, $text, $subscriptionId, $paymentprofileId) =parse_return($response);
						
						if ($resultCode == 'Ok') {
							$this->data['Business']['an_sub_id'] = htmlspecialchars($subscriptionId);
							$this->data['BusinessBilling']['an_pp_id'] = htmlspecialchars($paymentprofileId);
							//$this->data['Business']['plan_last_bill_date'] = $start_date;
						} else {
							$this->Business->invalidate('payment_error');
							$this->Session->setFlash($text);
							$this->Business->set($this->data);
							$res1 = $this->Business->validates();
						}
					} else {
						$this->Business->invalidate('payment_error');
						$this->set('payment_error_text', 'There was an error processing your payment. Error code: 12345');
					}
					


					$this->BusinessBilling->set($this->data);
					$res2 = $this->BusinessBilling->validates();
				} else {
					$res2 = true;
				}

				if ($res1 && $res2) {
					//$this->data['Business']['password'] = sha1($this->data['Business']['password']);
					//$this->data['Business']['password2'] = sha1($this->data['Business']['password2']);
					//$this->Business->save($this->data, false);
					//$this->BusinessBilling->save($this->data, false);
					//$this->Session->setFlash('Thank you for signing up.');
					$this->Session->write('signup_data', $this->data);
					$this->redirect('/businesses/merchant_category/', null, true);
				}
			} else {
				if (empty($plan)) {
					$this->redirect('/price', null, true);
				}
				$this->set('plan', $plan);
				$this->data['Business']['plan'] = $plan;
			}
		}

		function manage_company_logo() {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');
			$b = $this->Session->read('Business');
			if (empty($b['logo'])) {
				$this->set('logo', 'no_image.png');
			} else {
				$this->set('logo', LOGO_URL.$b['logo']);
			}

			if(!empty($this->data)) {
				if($this->data['Image']['filedata']['name']) {
					
					// set the upload destination folder
					$destination = realpath(LOGO_UPLOAD_PATH).'/';

					// grab the file
					$file = $this->data['Image']['filedata'];

					// upload the image using the upload component
					$result = $this->Upload->upload($file, $destination, $this->data['Business']['id'].'.jpg', array('type' => 'resize', 'size' => 110, 'output' => 'jpg'));

					if (!$result && !$this->Upload->errors){
						$this->data['Business']['logo'] = $this->Upload->result;
						$this->data['Business']['date_logo_last_modified'] = date('Y-m-d H:i:s');
						$this->Business->save($this->data, false);
						$b = $this->Business->find('id = '.$this->data['Business']['id']);
						$this->Session->write('Business', $b['Business']);
						$this->Session->setFlash('Logo uploaded.');
						$this->redirect('/manage/businesses/company_logo/');
					} else {
						// display error
						$errors = $this->Upload->errors;
						//$this->print_obj($errors);
		   
						// piece together errors
						if(is_array($errors)){ $errors = implode("<br />",$errors); }
		   
			                        $this->Product->invalidate('image_error');
						$this->set('image_errors', $errors[0]);
						$this->Session->setFlash('There was an error uploading your image. '.$errors[0]);
						//$this->redirect('/images/upload');
						//exit();
					}
				}
			} else {
				$b['Business'] = $this->Session->read('Business');
				$this->data = $b;
			}
		}

		function manage_delete_company_logo() {
			$b = $this->Session->read('Business');
			$this->Business->query("update businesses set logo = '' where id = ".$b['id']);
			unlink(LOGO_UPLOAD_PATH.$b['logo']);
			$b['logo'] = '';
			$this->Session->write('Business', $b);
			$this->Session->setFlash('Logo deleted.');
			$this->redirect('/manage/businesses/company_logo/');
		}
		
		function manage_edit_profile() {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');
			
			$b = $this->Session->read('Business');
			if (empty($b['logo'])) {
				$this->set('logo', 'no_image.png');
			} else {
				$this->set('logo', LOGO_URL.$b['logo']);
			}

			if (!empty($this->data)) {
				$validate_fields = array(
							'first_name',
							'last_name',
							'email',
							'business_name',
							'address1',
							'city',
							'state',
							'zip'
							);

				if (!empty($this->data['Business']['password'])) {
					$validate_fields[] = 'password';
					$save_password = true;
				} else {
					$save_password = false;
				}

				$this->Business->set($this->data);
				$res1 = $this->Business->validates(array('fieldList' => $validate_fields));

				if ($res1) {
					$b = $this->Session->read('Business');
					if ($save_password) {
						$this->data['Business']['password'] = sha1($this->data['Business']['password']);
						$this->data['Business']['password2'] = sha1($this->data['Business']['password2']);
					} else {
						$this->data['Business']['password'] = $b['password'];
					}
					$this->data['Business']['website'] = (stripos($this->data['Business']['website'], 'http') === false) ? 'http://'.$this->data['Business']['website'] : $this->data['Business']['website'];
					$this->data['Business']['twitter'] = (stripos($this->data['Business']['twitter'], '@') === false) ? '@'.$this->data['Business']['twitter'] : $this->data['Business']['twitter'];
					$this->Business->save($this->data, false);
					$b = $this->Business->find('id = '.$this->data['Business']['id']);
					$this->Session->write('Business', $b['Business']);
					$this->Session->setFlash('Your changes have been saved.');
					$this->redirect('/manage/businesses/edit_profile/', null, true);
				} else {
					$this->set('description_length', strlen($this->data['Business']['description']));
				}
			} else {
				$b['Business'] = $this->Session->read('Business');
				$b['Business']['twitter'] = (empty($b['Business']['twitter'])) ? '@' : $b['Business']['twitter'];
				$b['Business']['website'] = (empty($b['Business']['website'])) ? 'http://' : $b['Business']['website'];
				$this->data = $b;
				$this->set('description_length', strlen($this->data['Business']['description']));
			}
		}

		function manage_edit_billing() {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');
			
			$b = $this->Session->read('Business');
			if (empty($b['logo'])) {
				$this->set('logo', 'no_image.png');
			} else {
				$this->set('logo', LOGO_URL.$b['logo']);
			}
			$this->set('b', $this->Business->find('Business.id = '.$b['id']));

			if (isset($this->params['url']['downgrade']) && $this->params['url']['downgrade'] == 'true') {
				$this->set('show_downgrade', true);
			} else {
				$this->set('show_downgrade', false);
			}
			
			if (!empty($this->data)) {
				$validate_fields = array();
				$bypass_card = false;
				if (strpos($this->data['BusinessBilling']['card_number'], 'x') !== false) {
					$b = $this->BusinessBilling->find('BusinessBilling.id = '.$this->data['BusinessBilling']['id']);
					$this->data['BusinessBilling']['card_number'] = $b['BusinessBilling']['card_number'];
					$res1 = 1;
					$bypass_card = true;
				} else {
					App::import('Vendor', 'authorizenet/cim');
					$business = $this->Business->findById($b['id']);
					$is_billing = $this->BusinessBilling->findCount('business_id = '.$b['id']);
					$temp_billing = $this->BusinessBilling->findByBusinessId($b['id']);
					if ($is_billing > 0 && $business['Business']['an_sub_id'] != null && $business['Business']['an_sub_id'] != 0 && $temp_billing['BusinessBilling']['an_pp_id'] != null && $temp_billing['BusinessBilling']['an_pp_id'] != 0) {
						$content = an_format_xml_update(AN_LOGINNAME, AN_TRANSACTIONKEY, $business['Business']['an_sub_id'], $temp_billing['BusinessBilling']['an_pp_id'], $this->data['BusinessBilling']['card_number'], $this->data['BusinessBilling']['expiration_date']['year'].'-'.$this->data['BusinessBilling']['expiration_date']['month'], $this->Business->deal_prices[$business['Business']['plan']]);
						$response = send_request_via_curl(AN_HOST, AN_PATH, $content);
						$update = true;
					} else {
						$refId = mktime();
						$firstName = $business['Business']['first_name'];
						$lastName = $business['Business']['last_name'];
						$company = $business['Business']['business_name'];
						$email = $business['Business']['email'];
						$cardNumber = $this->data['BusinessBilling']['card_number'];
						$expirationDate = $this->data['BusinessBilling']['expiration_date']['year'].'-'.$this->data['BusinessBilling']['expiration_date']['month'];
						
						$content = an_format_xml_create(AN_LOGINNAME, AN_TRANSACTIONKEY, $refId, $email, $firstName, $lastName, $company, $cardNumber, $expirationDate, 'liveMode');
						$response = send_request_via_curl(AN_HOST, AN_PATH, $content);
						$update = false;
					}
					if ($response) {
						list ($refId, $resultCode, $code, $text, $subscriptionId, $paymentprofileId) =parse_return($response);
						if ($resultCode == 'Ok') {
							$res1 = 1;
							if ($update === true) {
								$this->data['BusinessBilling']['an_pp_id'] = $temp_billing['BusinessBilling']['an_pp_id'];
							} else {
								$this->data['BusinessBilling']['an_pp_id'] = $paymentprofileId;
								$this->data['Business']['an_sub_id'] = $subscriptionId;
								$this->data['Business']['id'] = $b['id'];
								$this->Business->save($this->data, false);
							}
						} else {
							//$b['Business'] = $this->Session->read('Business');
							//$this->data = $this->BusinessBilling->find('business_id = '.$b['Business']['id']);
							$this->data['BusinessBilling']['card_number'] = $this->_mask_card($this->data['BusinessBilling']['card_number']);
							$this->data['BusinessBilling']['business_id'] = $b['id'];
							$this->set('card_present', $this->BusinessBilling->card_present($b['id']));
							$res1 = 0;
						}
					} else {
						$this->Session->setFlash('There was a problem processing your request.');
						$res1 = 0;
						//$b['Business'] = $this->Session->read('Business');
						//$this->data = $this->BusinessBilling->find('business_id = '.$b['Business']['id']);
						$this->data['BusinessBilling']['card_number'] = $this->_mask_card($this->data['BusinessBilling']['card_number']);
						$this->data['BusinessBilling']['business_id'] = $b['id'];
						$this->set('card_present', $this->BusinessBilling->card_present($b['id']));
					}
				}

				$last_day_of_month = date('t', mktime(0, 0, 0, $this->data['BusinessBilling']['expiration_date']['month'], 1, $this->data['BusinessBilling']['expiration_date']['year']));
				$this->data['BusinessBilling']['expiration_date']['day'] = $last_day_of_month; 

				$this->BusinessBilling->set($this->data);
				$res2 = $this->BusinessBilling->validates();
				if ($bypass_card === true) {
					$res2 = 1;
				}
				if ($res1 && $res2) {
					$business = $this->Session->read('Business');
					$this->set('card_present', $this->BusinessBilling->card_present($business['id']));
					$this->data['BusinessBilling']['card_number'] = $this->_mask_card($this->data['BusinessBilling']['card_number']);
					$this->BusinessBilling->save($this->data, false);
					$this->Session->setFlash('Your changes have been saved.');
					$this->redirect('/manage/businesses/edit_billing/', null, true);
				}
			} else {
				$b['Business'] = $this->Session->read('Business');
				$this->data = $this->BusinessBilling->find('business_id = '.$b['Business']['id']);
				$this->data['BusinessBilling']['card_number'] = $this->_mask_card($this->data['BusinessBilling']['card_number']);
				$this->data['BusinessBilling']['business_id'] = $b['Business']['id'];
				$this->set('card_present', $this->BusinessBilling->card_present($b['id']));
			}
		}
		
		function manage_upgrade($plan) {
			$b = $this->Session->read('Business');
			if ($this->Business->can_change_plan($b['id']) === true) {	
				$business = $this->Business->findById($b['id']);

				if (strtolower($business['Business']['plan']) == 'free') {
					$today_month = date('m');
					$today_day = date('d') + 1;
					$today_year = date('Y');
					if ($today_day > 28) {
						$today_day = 1;
						$today_month = $today_month + 1;
					}
					$plan_next_bill_date = date('Y-m-d', mktime(0, 0, 0, $today_month, $today_day, $today_year));
					$difference = $this->Business->deal_counts[$plan] - $this->Business->deal_counts[$business['Business']['plan']];
					$this->Business->query("update businesses set plan_active = 1, subscription_deals = subscription_deals + ".$difference.", plan = '".$plan."', plan_next_bill_date = '".$plan_next_bill_date."' where id = ".$b['id']);
				} else {
					$difference = $this->Business->deal_counts[$plan] - $this->Business->deal_counts[$business['Business']['plan']];
					$this->Business->query("update businesses set plan_active = 1, subscription_deals = subscription_deals + ".$difference.", plan = '".$plan."' where id = ".$b['id']);
				}
				$this->data['Transaction']['business_id'] = $b['id'];
				$this->data['Transaction']['transaction_type'] = 'Plan Change';
				$this->data['Transaction']['description'] = 'from '.$business['Business']['plan'].' to '.$plan;
				$this->data['Transaction']['quantity'] = 1;
				$this->data['Transaction']['unit_price'] = 0;
				$this->Transaction->save($this->data);
				$this->Session->write('Business', $business['Business']);
				$this->Session->setFlash('You have been upgraded to the '.$plan.' Plan.  Changes will be reflected in your next billing cycle.');
				$this->redirect('/manage/businesses/edit_billing/', null, true);

				$business = $this->Business->findById($b['id']);
				$this->Session->write('Business', $business['Business']);
							
			} else {
				$this->Session->setFlash('We could not change your plan.  Plans can only be changed once per billing cycle.<br />For assistance, please call (303) 506-4306.');
				$this->redirect('/manage/businesses/edit_billing/', null, true);
			}
		}
		
		function manage_downgrade($plan) {
			$b = $this->Session->read('Business');
			if ($this->Business->can_change_plan($b['id']) === true) {	
				$business = $this->Business->findById($b['id']);

				$this->Business->query("update businesses set plan_active = 1, plan = '".$plan."' where id = ".$b['id']);

				$this->data['Transaction']['business_id'] = $b['id'];
				$this->data['Transaction']['transaction_type'] = 'Plan Change';
				$this->data['Transaction']['description'] = 'from '.$business['Business']['plan'].' to '.$plan;
				$this->data['Transaction']['quantity'] = 1;
				$this->data['Transaction']['unit_price'] = 0;
				$this->Transaction->save($this->data);
				$this->Session->write('Business', $business['Business']);
				$this->Session->setFlash('You have been downgraded to the '.$plan.' Plan.  Changes will be reflected in your next billing cycle.');
				$this->redirect('/manage/businesses/edit_billing/', null, true);
			} else {
				$this->Session->setFlash('We could not change your plan.  Plans can only be changed once per billing cycle.<br />For assistance, please call (303) 506-4306.');
				$this->redirect('/manage/businesses/edit_billing/', null, true);
			}
		}

		function _mask_card($number) {
			$ret = '';
			for ($i = 1; $i <= strlen($number) - 4;$i++) {
				$ret .= 'x';
			}
			$ret .= substr($number, -4);
			return $ret;
		}
		
		function merchant_category() {
			if (!$this->Session->check('signup_data')) {
				$this->redirect('/price', null, true);
			}

			$this->layout = 'inside';
			$this->set('header_name', 'business_signup');

			$this->set('base_categories', $this->BusinessCategory->get_base_categories());

			$data = $this->Session->read('signup_data');
			$similar = $this->Business->find_similar_businesses($data);
			$this->set('similar', $similar);
			$this->set('selected', '0');
			
			$this->set('selected_base_category', '');

			if (!empty($this->data)) {
				if (array_key_exists('Business', $this->data) && array_key_exists('select_similar', $this->data['Business'])) {
					$similar = $this->data['Business']['select_similar'];
					if ($this->data['Business']['select_similar'] > 0) {
						$data['Business']['id'] = $this->data['Business']['select_similar'];
					}
				} else {
					$similar = 0;
				}
				$data['Business']['password'] = sha1($data['Business']['password']);
				$data['Business']['password2'] = sha1($data['Business']['password2']);
				$today_month = date('m');
				$today_day = date('d') + 1;
				$today_year = date('Y');
				if ($today_day > 28) {
					$today_day = 1;
					$today_month = $today_month + 1;
				}
				$data['Business']['plan_last_bill_date'] = $today_year.'-'.$today_month.'-'.$today_day;
				if ($data['Business']['plan'] == 'plus') {
					$data['Business']['plan'] = 'Trial';
					$data['Business']['plan_next_bill_date'] = date('Y-m-d', mktime(0, 0, 0, $today_month + 1, $today_day, $today_year));
					$data['Business']['trials_remaining'] = 1;
				} else {
					$data['Business']['plan_next_bill_date'] = date('Y-m-d', mktime(0, 0, 0, $today_month, $today_day, $today_year));
				}
				
				$data['Business']['subscription_deals'] = $this->Business->deal_counts[ucfirst($data['Business']['plan'])];
				$data['Business']['plan'] = ucfirst($data['Business']['plan']);
				$data['Business']['plan_active'] = 1;
				$this->Business->save($data, false);
				if ($similar > 0) {
					$id = $similar;
				} else {
					$id = $this->Business->getLastInsertID();
				}
				if (strtolower($data['Business']['plan']) != 'free' && strtolower($data['Business']['plan']) != 'plus' && strtolower($data['Business']['plan']) != 'trial') {
					$data['BusinessBilling']['business_id'] = $id;
					$data['BusinessBilling']['card_number'] = $this->_mask_card($data['BusinessBilling']['card_number']);
					
					$this->BusinessBilling->save($data, false);
				}
				$this->data['Business']['id'] = $id;
				$this->BusinessCategory->save_categories($this->data);
				$b = $this->Business->find('id = '.$id);
				$this->Session->write('Business', $b['Business']);
							
				$data['BusinessOffer']['business_id'] = $id;
				$data['BusinessOffer']['offer_class'] = 'General';
				$data['BusinessOffer']['dd_title'] = 'No current offers';
				$data['BusinessOffer']['dd_description'] = 'No current offers';
				$this->BusinessOffer->save($data, false);

				$this->data['Transaction']['business_id'] = $id;
				$this->data['Transaction']['transaction_type'] = 'Signup';
				$this->data['Transaction']['quantity'] = 1;
				$this->data['Transaction']['unit_price'] = 0;
				$this->data['Transaction']['description'] = $data['Business']['plan'].' Signup';
				$this->Transaction->save($this->data);
							
				$this->Session->setFlash('Thank you for signing up.');
				$this->redirect('/manage/businesses/edit_profile/', null, true);
			}
		}
		function update_subcats() {
			if(!empty($this->data['BusinessCategory']['base_category'])) {
				$this->set('selected_base_category', $this->data['BusinessCategory']['base_category']);
				$this->set('subs', $this->BusinessCategory->get_subcategories($this->data['BusinessCategory']['base_category']));
			} else {
				$this->set('selected_base_category', '');
			}
			$this->viewPath = 'elements'.DS;
			$this->render('subcats');			
		}

		function manage_update_cc() {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');
			
			$b = $this->Session->read('Business');
			if (empty($b['logo'])) {
				$this->set('logo', 'no_image.png');
			} else {
				$this->set('logo', LOGO_URL.$b['logo']);
			}
			$this->set('b', $this->Business->find('Business.id = '.$b['id']));

			if (!empty($this->data)) {
				$this->data['Business']['id']  = $b['id'];
				$validate_fields = array();

				$last_day_of_month = date('t', mktime(0, 0, 0, $this->data['BusinessBilling']['expiration_date']['month'], 1, $this->data['BusinessBilling']['expiration_date']['year']));
				$this->data['BusinessBilling']['expiration_date']['day'] = $last_day_of_month; 

				$this->BusinessBilling->set($this->data);
				$res2 = $this->BusinessBilling->validates();
				
				if ($b['plan'] == 'Trial') {
					//trial to plus should be working.
					$this->data['Business']['plan']  = 'Plus';

					$today_day = date("d") + 1;
					$today_month = date("m");
					if ($today_day > 28) {
						$today_day = 1;
						$today_month = $today_month + 1;
					}

					App::import('Vendor', 'authorizenet/cim');
					$business = $this->Business->findById($b['id']);
					$is_billing = $this->BusinessBilling->findCount('business_id = '.$b['id']);
					$temp_billing = $this->BusinessBilling->findByBusinessId($b['id']);
					if ($is_billing > 0 && $business['Business']['an_sub_id'] != null && $business['Business']['an_sub_id'] != 0 && $temp_billing['BusinessBilling']['an_pp_id'] != null && $temp_billing['BusinessBilling']['an_pp_id'] != 0) {
						$content = an_format_xml_update(AN_LOGINNAME, AN_TRANSACTIONKEY, $business['Business']['an_sub_id'], $temp_billing['BusinessBilling']['an_pp_id'], $this->data['BusinessBilling']['card_number'], $this->data['BusinessBilling']['expiration_date']['year'].'-'.$this->data['BusinessBilling']['expiration_date']['month'], $this->Business->deal_prices[$business['Business']['plan']]);
						$response = send_request_via_curl(AN_HOST, AN_PATH, $content);
						$update = true;
					} else {
						$refId = mktime();
						$firstName = $business['Business']['first_name'];
						$lastName = $business['Business']['last_name'];
						$company = $business['Business']['business_name'];
						$email = $business['Business']['email'];
						$cardNumber = $this->data['BusinessBilling']['card_number'];
						$expirationDate = $this->data['BusinessBilling']['expiration_date']['year'].'-'.$this->data['BusinessBilling']['expiration_date']['month'];
						
						$content = an_format_xml_create(AN_LOGINNAME, AN_TRANSACTIONKEY, $refId, $email, $firstName, $lastName, $company, $cardNumber, $expirationDate, 'liveMode');
						$response = send_request_via_curl(AN_HOST, AN_PATH, $content);
						$update = false;
					}

					if ($response) {
						list ($refId, $resultCode, $code, $text, $subscriptionId, $paymentprofileId) =parse_return($response);
						
						if ($resultCode == 'Ok') {
							$res1 = 1;
							//$this->data['Business']['plan_last_bill_date'] = $start_date;
							if ($update === true) {
								$this->data['BusinessBilling']['an_pp_id'] = $temp_billing['BusinessBilling']['an_pp_id'];
							} else {
								$this->data['BusinessBilling']['an_pp_id'] = $paymentprofileId;
								$this->data['Business']['an_sub_id'] = $subscriptionId;
								$this->data['Business']['id'] = $b['id'];
								$this->Business->save($this->data, false);
							}

							$this->data['BusinessBilling']['card_number'] = $this->_mask_card($this->data['BusinessBilling']['card_number']);
							$today_month = date('m');
							$today_day = date('d');
							$today_year = date('Y');
							if ($today_day > 28) {
								$today_day = 1;
								$today_month = $today_month + 1;
							} else {
								$today_day = $today_day + 1;
							}
							$this->data['Business']['plan_last_bill_date'] = $today_year.'-'.$today_month.'-'.$today_day;
							$this->data['Business']['plan_next_bill_date'] = date('Y-m-d', mktime(0, 0, 0, $today_month + 1, $today_day, $today_year));
							
							$this->data['Business']['subscription_deals'] = $this->Business->deal_counts[ucfirst($this->data['Business']['plan'])];
							$this->data['Business']['plan'] = ucfirst($this->data['Business']['plan']);
							$this->data['Business']['plan_active'] = 1;
						} else {
							$this->Business->invalidate('payment_error');
							$this->Session->setFlash($text);
							$this->Business->set($this->data);
							$res1 = $this->Business->validates();
							$res1 = 0;
						}
					} else {
						$res1 = 0;
						$this->Business->invalidate('payment_error');
						$this->set('payment_error_text', 'There was an error processing your payment. Error code: 12345');
					}
				} else {
					$business = $this->Business->findById($b['id']);

					App::import('Vendor', 'authorizenet/cim');
					$business = $this->Business->findById($b['id']);
					$is_billing = $this->BusinessBilling->findCount('business_id = '.$b['id']);
					$temp_billing = $this->BusinessBilling->findByBusinessId($b['id']);
					if ($is_billing > 0 && $business['Business']['an_sub_id'] != null && $business['Business']['an_sub_id'] != 0 && $temp_billing['BusinessBilling']['an_pp_id'] != null && $temp_billing['BusinessBilling']['an_pp_id'] != 0) {
						$content = an_format_xml_update(AN_LOGINNAME, AN_TRANSACTIONKEY, $business['Business']['an_sub_id'], $temp_billing['BusinessBilling']['an_pp_id'], $this->data['BusinessBilling']['card_number'], $this->data['BusinessBilling']['expiration_date']['year'].'-'.$this->data['BusinessBilling']['expiration_date']['month'], $this->Business->deal_prices[$business['Business']['plan']]);
						$response = send_request_via_curl(AN_HOST, AN_PATH, $content);
						$update = true;
					} else {
						$refId = mktime();
						$firstName = $business['Business']['first_name'];
						$lastName = $business['Business']['last_name'];
						$company = $business['Business']['business_name'];
						$email = $business['Business']['email'];
						$cardNumber = $this->data['BusinessBilling']['card_number'];
						$expirationDate = $this->data['BusinessBilling']['expiration_date']['year'].'-'.$this->data['BusinessBilling']['expiration_date']['month'];
						
						$content = an_format_xml_create(AN_LOGINNAME, AN_TRANSACTIONKEY, $refId, $email, $firstName, $lastName, $company, $cardNumber, $expirationDate, 'liveMode');
						$response = send_request_via_curl(AN_HOST, AN_PATH, $content);
						$update = false;
					}

					if ($response) {
						list ($refId, $resultCode, $code, $text, $subscriptionId, $paymentprofileId) =parse_return($response);
						if ($resultCode == 'Ok') {
							$res1 = 1;
							$this->data['Business']['plan_active'] = 1;
							if ($update === true) {
								$this->data['BusinessBilling']['an_pp_id'] = $temp_billing['BusinessBilling']['an_pp_id'];
							} else {
								$this->data['BusinessBilling']['an_pp_id'] = $paymentprofileId;
								$this->data['Business']['an_sub_id'] = $subscriptionId;
								$this->data['Business']['id'] = $b['id'];
								$this->Business->save($this->data, false);
							}
							$today_month = date('m');
							$today_day = date('d');
							$today_year = date('Y');
							if ($today_day > 28) {
								$today_day = 1;
								$today_month = $today_month + 1;
							} else {
								$today_day = $today_day + 1;
							}
							$this->data['Business']['plan_next_bill_date'] = date('Y-m-d', mktime(0, 0, 0, $today_month, $today_day, $today_year));
							$this->data['Business']['subscription_deals'] = $this->Business->deal_counts[ucfirst($business['Business']['plan'])];
						} else {
							$b['Business'] = $this->Session->read('Business');
							$this->data = $this->BusinessBilling->find('business_id = '.$b['Business']['id']);
							$this->data['BusinessBilling']['card_number'] = $this->_mask_card($this->data['BusinessBilling']['card_number']);
							$this->data['BusinessBilling']['business_id'] = $b['Business']['id'];
							$this->set('card_present', $this->BusinessBilling->card_present($b['id']));
							$res1 = 0;
						}
					} else {
						$this->Session->setFlash('There was a problem processing your request.');
						$res1 = 0;
						$b['Business'] = $this->Session->read('Business');
						$this->data = $this->BusinessBilling->find('business_id = '.$b['Business']['id']);
						$this->data['BusinessBilling']['card_number'] = $this->_mask_card($this->data['BusinessBilling']['card_number']);
						$this->data['BusinessBilling']['business_id'] = $b['Business']['id'];
						$this->set('card_present', $this->BusinessBilling->card_present($b['id']));
					}
				}

				$last_day_of_month = date('t', mktime(0, 0, 0, $this->data['BusinessBilling']['expiration_date']['month'], 1, $this->data['BusinessBilling']['expiration_date']['year']));
				$this->data['BusinessBilling']['expiration_date']['day'] = $last_day_of_month; 

				$this->BusinessBilling->set($this->data);
				$res2 = $this->BusinessBilling->validates();

				if ($res1 && $res2) {
					$business = $this->Session->read('Business');
					$this->set('card_present', $this->BusinessBilling->card_present($business['id']));
					$this->data['Business']['an_attempted'] = '0000-00-00';
					$this->Business->save($this->data, false);
					$business = $this->Business->findById($b['id']);
					$this->Session->write('Business', $business['Business']);
					$this->data['BusinessBilling']['card_number'] = $this->_mask_card($this->data['BusinessBilling']['card_number']);
					$this->BusinessBilling->save($this->data, false);
					$this->Session->setFlash('Your changes have been saved.');
					$this->redirect('/manage/deals/index/', null, true);
				}
			} else {
				$b['Business'] = $this->Session->read('Business');
				$this->data = $this->BusinessBilling->find('business_id = '.$b['Business']['id']);
				$this->data['BusinessBilling']['card_number'] = $this->_mask_card($this->data['BusinessBilling']['card_number']);
				$this->data['BusinessBilling']['business_id'] = $b['Business']['id'];
				$this->set('card_present', $this->BusinessBilling->card_present($b['id']));
			}
		}
		
		function login() {
		
			$this->set('error', false);

			if (!empty($this->data)) {
					if (empty($this->data['Business']['username']) || empty($this->data['Business']['password'])) {
						$this->Session->setFlash("We're sorry, but the username and password you have entered do not match. Please try again.");
						$this->Business->invalidate('login_error');
						$this->redirect('/businesses/login', null, true);
					}
				
					$someone = $this->Business->find("Business.username = '".$this->data['Business']['username']."' and Business.password = '".sha1($this->data['Business']['password'])."'");
					if (count($someone) > 1) {
						
						$this->Session->write('Business', $someone['Business']);

						if ($someone['Business']['plan'] != 'Free' && $someone['Business']['plan_next_bill_date'] < date('Y-m-d')) {
							//$this->Business->query("update businesses set plan_active = 0 where id = ".$someone['Business']['id']);
							$this->redirect('/manage/businesses/update_cc', null, true);
						}

						if ($someone['Business']['plan_active'] != 1) {
							$this->Session->delete('Business');
							$this->Session->destroy();
							$this->Session->setFlash('Your plan is inactive.<br />Please call (303) 506-4306 for assistance.');
							$this->redirect('/businesses/login', null, true);
						}

						if ($this->Session->check('after_login')) {
								$this->redirect($this->Session->read('after_login'), null, true);
						} else {
								$this->redirect('/manage/deals/', null, true);
						}

					} else {
						
							$this->Session->setFlash("We're sorry, but the username and password you have entered do not match. Please try again, or click the 'Forgot Password?' link below.");
						
							$this->Business->invalidate('login_error');
							$this->redirect('/businesses/login', null, true);
					}
			}
 		}
		
                function logout() {

                        $this->Session->delete('Business');

                        $this->Session->destroy();

                        $this->redirect('/');

                }
                
                function forgot_password() {
                	if (!empty($this->data)) {
                		$hash = sha1($this->data['Business']['username'].rand(0,100));
                		$count = $this->Business->findCount("Business.username = '".$this->data['Business']['username']."'");
                		if ($count > 0) {
					$b = $this->Business->findByUsername($this->data['Business']['username']);
					$this->Business->query("update businesses set token = '$hash' where id = ".$b['Business']['id']);

					$to      = $b['Business']['email'];
					$subject = 'DuckDuckDeal.com - Password Reset';
					$message = "
We received a request to change the password for the account with the username ".$b['Business']['username'].".\n\n
Please visit this address:\n".URL_BASE."businesses/reset_password/".$hash."\n\n

Thank you.
					";
					$headers = 'From: help@duckduckdeal.com' . "\r\n" .
					    'Reply-To: help@duckduckdeal.com' . "\r\n" .
					    'X-Mailer: PHP/' . phpversion();
					
					mail($to, $subject, $message, $headers);

					$this->Session->setFlash('Please check your email and follow the instructions to reset your password.');
					$this->redirect('/businesses/forgot_password/', null, true);
				} else {
					$this->Session->setFlash('We could not find that username.');
					$this->redirect('/businesses/forgot_password/', null, true);
				}
                	}
                }
                
                function reset_password($token = null) {
                	if (!empty($this->data)) {
				$b = $this->Business->findByToken($this->data['Business']['token']);
				$this->data['Business']['id'] = $b['Business']['id'];
				$this->data['Business']['password'] = sha1($this->data['Business']['password']);
				$this->data['Business']['password2'] = sha1($this->data['Business']['password2']);
				$this->Business->set($this->data);
				$validate_fields[] = 'password';
				$res1 = $this->Business->validates(array('fieldList' => $validate_fields));
				if ($res1) {
					$this->Business->save($this->data, false);
					$this->Session->setFlash('Your password has been reset.');
					$this->redirect('/businesses/login/', null, true);
				}
                	} else {
				if ($this->Business->findCount("Business.token = '$token'") == 0) {
					$this->Session->setFlash('The password reset request you entered could not be found.');
					$this->redirect('/businesses/forgot_password/', null, true);
				}
				$b = $this->Business->findByToken($token);
				$this->data = $b;
			}
                }
                
                function geocodethis() {
                	$this->autoRender = false;
                	$business = $this->Business->findAll('longitude < 1');
                	//pr($business);die;
                	foreach ($business as $b) {
				$location = $b['Business']['address1'].' '.$location = $b['Business']['city'].', '.$location = $b['Business']['state'].' '.$location = $b['Business']['zip'];
				$this->Business->Behaviors->attach('Geocoded', array('key' => 'ABQIAAAAMU9EohqpxNREG770ZWoNWBQmGE6IU3RohcbQM2f-SteLLt6KlBTXDnrL704G3P4Od8Jlkt_uoIWE_Q'));
				$geocode = $this->Business->geocode($location);
				$this->Business->Behaviors->detach('Geocoded');
				
				$this->Business->query("update businesses set latitude = '".$geocode['lat']."', longitude = '".$geocode['lon']."' where id = ".$b['Business']['id']);
				pr($geocode);
			}
                	
                	pr($b);die;
                }
                
                function privacy() {
                	$this->layout = 'blank';
                }

                function terms() {
                	$this->layout = 'blank';
                }

                function show_terms() {
					$this->layout = 'inside';
					$this->set('header_name', 'view');
                }

                function show_privacy() {
					$this->layout = 'inside';
					$this->set('header_name', 'view');
                }

				function contact() {
					$this->layout = 'inside';
					$this->set('header_name', 'view');

					if ($this->RequestHandler->isPost()) {
						$this->Contact->set($this->data);
						if ($this->Contact->validates()) {
							//send email using the Email component
							$this->Email->to = 'apawliczek@gmail.com';  
							$this->Email->subject = 'Contact message from ' . $this->data['Contact']['first_name'].' '.$this->data['Contact']['last_name'];  
							$this->Email->from = $this->data['Contact']['email_address'];  
				   			
				   			$message = "Name: ".$this->data['Contact']['first_name'].' '.$this->data['Contact']['last_name'];
				   			$message .= "\nCompany: ".$this->data['Contact']['company_name'];
				   			$message .= "\nEmail: ".$this->data['Contact']['email_address'];
				   			$message .= "\nPhone: ".$this->data['Contact']['phone_number'];
				   			$message .= "\n\n".$this->data['Contact']['comments'];
							$this->Email->send($message);

							$this->Session->setFlash('Thank you for your message.');
							$this->redirect('/businesses/contact', null, true);
						}
					}
				}

				function captcha_image()
				{
					Configure::write('debug',0);
					$this->layout = null;  
					$this->Captcha->image();
					$this->render();
				}
				
				function captcha_audio()
				{
					$this->Captcha->audio();
				}
        }
?>
