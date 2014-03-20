<?
switch ($selected_base_category) {
	case "1":
	case "5":
		echo '<br /><br />Select Subcategory<br />'.$form->select('BusinessCategory.subcategories', $subs);
		echo '<br clear="both" />';
		echo '<br clear="both" />';
		echo '<div align="center">'.$form->submit("buttons/continue_to_profile.png").'</div>';
		break;
	case "2":
	case "3":
	case "4":
	case "6":
		echo '<br /><br />Select Subcategories<br />'.$form->select('BusinessCategory.subcategories', $subs, null, array('multiple' => 'checkbox'));
		echo '<br clear="both" />';
		echo '<br clear="both" />';
		echo '<div align="center">'.$form->submit("buttons/continue_to_profile.png").'</div>';
		break;
	default:
}
?>

