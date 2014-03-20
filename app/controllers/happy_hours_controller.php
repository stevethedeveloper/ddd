<?php
	class HappyHoursController extends AppController {
		var $name = 'HappyHours';
		var $uses = array('Business', 'BusinessHappyHour');
		var $helpers = array('Form', 'Html');

		function manage_edit() {
			$this->layout = 'inside';
			$this->set('header_name', 'logged_in');
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
			
			$b = $this->Session->read('Business');
			if (empty($b['logo'])) {
				$this->set('logo', 'no_image.png');
			} else {
				$this->set('logo', LOGO_URL.$b['logo']);
			}
			$h = $this->BusinessHappyHour->findAll('BusinessHappyHour.business_id = '.$b['id']);
			$this->set('happy_hours', $h);

			if (!empty($this->data)) {
				if ($this->data['BusinessHappyHour']['start_time']['meridian'] == 'pm') {
					if ($this->data['BusinessHappyHour']['start_time']['hour'] != 12) {
						$this->data['BusinessHappyHour']['start_time']['hour'] = $this->data['BusinessHappyHour']['start_time']['hour'] + 12;
					}
				} elseif ($this->data['BusinessHappyHour']['start_time']['hour'] == 12) {
					$this->data['BusinessHappyHour']['start_time']['hour'] = '00';
				}
				$this->data['BusinessHappyHour']['start_time'] = date('H:i:s', strtotime($this->data['BusinessHappyHour']['start_time']['hour'].':'.$this->data['BusinessHappyHour']['start_time']['min']));

				if ($this->data['BusinessHappyHour']['end_time']['meridian'] == 'pm') {
					if ($this->data['BusinessHappyHour']['end_time']['hour'] != 12) {
						$this->data['BusinessHappyHour']['end_time']['hour'] = $this->data['BusinessHappyHour']['end_time']['hour'] + 12;
					}
				} elseif ($this->data['BusinessHappyHour']['end_time']['hour'] == 12) {
					$this->data['BusinessHappyHour']['end_time']['hour'] = '00';
				}
				$this->data['BusinessHappyHour']['end_time'] = date('H:i:s', strtotime($this->data['BusinessHappyHour']['end_time']['hour'].':'.$this->data['BusinessHappyHour']['end_time']['min']));

				if ($this->BusinessHappyHour->save($this->data)) {
					$this->Session->setFlash('Happy Hour added');
					$this->redirect('/manage/happy_hours/edit/');
				}
			} else {
				$this->data['BusinessHappyHour']['business_id'] = $b['id'];
			}
		}
		
		function manage_delete_happy_hour($id = null) {
			if ($this->_check_permission($id) === false) {
					$this->Session->setFlash('You do not have permission to edit this Happy Hour.');
					$this->redirect('/manage/happy_hours/edit/');
			}
			
			$this->BusinessHappyHour->del($id);
			$this->Session->setFlash('Happy Hour deleted.');
			$this->redirect('/manage/happy_hours/edit/');
		}
		
		function _check_permission($id) {
			$b = $this->Session->read('Business');
			if ($this->BusinessHappyHour->findCount('BusinessHappyHour.id = '.$id.' and BusinessHappyHour.business_id = '.$b['id']) > 0) {
				return true;
			}
			return false;
		}
	}
?>
