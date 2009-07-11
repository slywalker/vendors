<div class="block">
	<h3><?php echo __('Side Bar');?></h3>
	<?php
	$li = array();
	$li[] = $html->link('menu1', array('#'=>''));
	$li[] = $html->link('menu2', array('#'=>''));
	echo $html->nestedList($li, array('class'=>'navigation'));
	?>
</div>