<?php
class AppController extends Controller {
	var $prices = array(
			'personal' => '49',
			'basic' => '149',
			'plus' => '249',
			'premium' => '349',
			'free' => '0',
			);
	var $components = array('RequestHandler');

	function beforeFilter() {
		if ($this->RequestHandler->isMobile() && $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] != 'www.duckduckdeal.com/mobile') {
			$this->redirect('http://www.duckduckdeal.com/mobile', null, true);
		}
		
		if ($_SERVER['HTTP_HOST'] == 'm.duckduckdeal.com') {
			$this->redirect('http://www.duckduckdeal.com/mobile', null, true);
		} elseif ($_SERVER['HTTP_HOST'] != 'www.duckduckdeal.com') {
			$this->redirect('http://www.duckduckdeal.com'.$_SERVER['REQUEST_URI'], null, true);
		}

		if ($this->params['controller'] == 'businesses' || $this->params['controller'] == 'happy_hours' || ($this->params['controller'] == 'deals' && $this->params['action'] != 'home' && $this->params['action'] != 'mobile')) {
			if ($_SERVER['REQUEST_METHOD'] != 'POST') {
				if (!array_key_exists('HTTPS', $_SERVER) || $_SERVER['HTTPS'] != 'on') {
					$this->redirect('https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], null, true);
				}
			}
		} elseif (array_key_exists('HTTPS', $_SERVER) && $_SERVER['HTTPS'] == 'on'){
			$this->redirect('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], null, true);
		}

/*

		if ($this->params['action'] != 'add_to_cart') {
			$this->Session->write('prev_url', $this->params['url']['url']);
		}
		$footer = $this->Footer->find("Footer.footer_name = 'hanna_footer'");
		$this->set('footer', $footer);
		
		if (!array_key_exists('HTTPS', $_SERVER) || $_SERVER['HTTPS'] != 'on') {
			define('MAIN_IMAGE_URL', 'http://www.hannasherbshop.com/app/webroot/img/');
		} else {
			define('MAIN_IMAGE_URL', 'https://www.hannasherbshop.com/app/webroot/img/');
		}
		*/

		$logged_in = false;
		if ($this->Session->check('Business')) {
			$this->set('current_user', $this->Session->read('Business'));
			$logged_in = true;
		}

		$this->set('logged_in', $logged_in);

		if (array_key_exists('manage', $this->params) && $this->params['manage'] == '1') {

			if (!$logged_in) {
				$this->Session->write('after_login', '/'.$this->params['url']['url']);
				$this->redirect('/businesses/login');
				exit();
			} else {
				$b = $this->Session->read('Business');
				if ($b['plan_next_bill_date'] < date('Y-m-d') && $b['plan'] != 'Free') {
					if ($this->params['action'] != 'manage_update_cc' && $this->params['action'] != 'manage_downgrade') {
						$this->redirect('/manage/businesses/update_cc', null, true);
					}
				}
			}

			//if ($this->Session->read('change_password') == true && $this->action != 'admin_user_account_password') {
			//	$this->redirect('/admin/users/user_account_password/');
			//}

		}
	}
}
?>
