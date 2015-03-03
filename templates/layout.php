<?php //echo 'Layout php file text';
	$captObj=CallWPCaptureObj::getInstance();
	$captObj->renderMenu();
?>

<div class="wp-common-crmwrapper">
<?php
	echo $skinny_content;
?>
</div>
