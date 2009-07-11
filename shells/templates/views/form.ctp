<div id="main">
	<div class="<?php echo $pluralVar;?> form">
<?php
echo "\t\t<?php\n";
echo "\t\techo \$form->create('{$modelClass}');\n";
echo "\t\techo \$form->inputs(array(\n";
echo "\t\t\t'legend' => __('".Inflector::humanize($action)." {$singularHumanName}', true),\n";
foreach ($fields as $field) {
	if ($action == 'add' && $field == $primaryKey) {
		continue;
	} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
		echo "\t\t\t'{$field}',\n";
	}
}
if (!empty($associations['hasAndBelongsToMany'])) {
	foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
		echo "\t\t\t'{$assocName}',\n";
	}
}
echo "\t\t));\n";
echo "\t\techo \$form->end('Submit');\n";
echo "\t\t?>\n";
?>
	</div>
</div>
<div id="sidebar">
	<div class="block">
		<h3><?php echo __('Actions');?></h3>
<?php
echo "\t\t<?php\n";
echo "\t\t\$li = array();\n";
if ($action != 'add') {
	echo "\t\t\$li[] =\$html->link(__('Delete', true), array('action' => 'delete', \$form->value('{$modelClass}.{$primaryKey}')), null, sprintf(__('Are you sure you want to delete # %s?', true), \$form->value('{$modelClass}.{$primaryKey}')));\n";
}
echo "\t\t\$li[] = \$html->link(__('List {$pluralHumanName}', true), array('action' => 'index'));\n";
$done = array();
foreach ($associations as $type => $data) {
	foreach ($data as $alias => $details) {
		if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
			echo "\t\t\$li[] = \$html->link(__('List ".Inflector::humanize($details['controller'])."', true), array('controller' => '{$details['controller']}', 'action' => 'index'));\n";
			echo "\t\t\$li[] = \$html->link(__('New ".Inflector::humanize(Inflector::underscore($alias))."', true), array('controller' => '{$details['controller']}', 'action' => 'add'));\n";
			$done[] = $details['controller'];
		}
	}
}
echo "\t\techo \$html->nestedList(\$li, array('class'=>'navigation'));\n";
echo "\t\t?>\n";
?>
	</div>
</div>
