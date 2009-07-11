<?php
$li = array();
$li[] = $html->link('menu1', array('#'=>''));
$li[] = $html->link('menu2', array('#'=>''));
echo $html->nestedList($li);
?>