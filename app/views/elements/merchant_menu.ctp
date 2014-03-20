<div id="merchant_menu_title">Menu</div>
<br clear="both" />
<div id="merchant_menu">
	<a href="<?=$html->url('/manage/deals/index')?>" class="<?=($this->params['controller'] == 'deals') ? 'mm_on' : 'mm_off'?>">Manage Your Deals</a>
	<a href="<?=$html->url('/manage/businesses/edit_profile')?>" class="<?=($this->params['controller'] == 'businesses' && $this->params['action'] == 'manage_edit_profile') ? 'mm_on' : 'mm_off'?>">Edit Your Merchant Profile</a>
	<a href="<?=$html->url('/manage/happy_hours/edit')?>" class="<?=($this->params['controller'] == 'happy_hours' && $this->params['action'] == 'manage_edit') ? 'mm_on' : 'mm_off'?>">Manage Your Happy Hours</a>
	<a href="<?=$html->url('/manage/businesses/edit_billing')?>" class="<?=($this->params['controller'] == 'businesses' && $this->params['action'] == 'manage_edit_billing') ? 'mm_on' : 'mm_off'?>">Billing Info</a>
	<a href="<?=$html->url('/manage/businesses/company_logo')?>" class="<?=($this->params['controller'] == 'businesses' && $this->params['action'] == 'manage_company_logo') ? 'mm_on' : 'mm_off'?>">Company Logo</a>
</div>
