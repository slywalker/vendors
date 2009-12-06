<?php echo "<?php $this->pageTitle = __('List {$singularHumanName}', true);?>\n"?>
<div id="main">
	<div class="<?php echo $pluralVar;?> view">
		<h2><?php echo "<?php  __('{$singularHumanName}');?>";?></h2>
		<dl>
<?php
echo "\t\t\t<?php\n";
echo "\t\t\t\$lists = array();\n";
foreach ($fields as $field) {
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "\t\t\t\$lists[] = array('dt' => __('".Inflector::humanize(Inflector::underscore($alias))."', true), 'dd' => \$html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])));\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t\t\$lists[] = array('dt' => __('".Inflector::humanize($field)."', true), 'dd' => h(\${$singularVar}['{$modelClass}']['{$field}']));\n";
	}
}
echo "\t\t\tforeach (\$lists as \$key => \$list) {\n";
echo "\t\t\t\t\$class = array();\n";
echo "\t\t\t\tif (\$key % 2 == 0) {\n";
echo "\t\t\t\t\t\$class = array('class' => 'altrow');\n";
echo "\t\t\t\t}\n";
echo "\t\t\t\techo \$html->tag('dt', \$list['dt'], \$class);\n";
echo "\t\t\t\techo \$html->tag('dd', \$list['dd'].'&nbsp;', \$class);\n";
echo "\t\t\t}\n";
echo "\t\t\t?>\n";
?>
		</dl>
	</div>
<?php
if (!empty($associations['hasOne'])) :
	foreach ($associations['hasOne'] as $alias => $details):
?>
	<div class="related">
		<h3><?php echo "<?php  __('Related ".Inflector::humanize($details['controller'])."');?>";?></h3>
		<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])):?>\n";?>
		<dl><?php echo "\t<?php \$i = 0; \$class = ' class=\"altrow\"';?>\n";?>
<?php
echo "\t\t\t<?php\n";
echo "\t\t\t\$lists = array();\n";
foreach ($details['fields'] as $field) {
	echo "\t\t\t\$lists[] = array('dt' => __('".Inflector::humanize($field)."', true), 'dd' => h(\${$singularVar}['{$alias}']['{$field}']));\n";
}
echo "\t\t\tforeach (\$lists as \$key => \$list) {\n";
echo "\t\t\t\t\$class = array();\n";
echo "\t\t\t\tif (\$key % 2 == 0) {\n";
echo "\t\t\t\t\t\$class = array('class' => 'altrow');\n";
echo "\t\t\t\t}\n";
echo "\t\t\t\techo \$html->tag('dt', \$list['dt'], \$class);\n";
echo "\t\t\t\techo \$html->tag('dd', \$list['dd'].'&nbsp;', \$class);\n";
echo "\t\t\t}\n";
echo "\t\t\t?>\n";
?>
		</dl>
	<?php echo "<?php endif; ?>\n";?>
		<div class="actions">
<?php
echo "\t\t\t<?php\n";
echo "\t\t\t\$li = array();\n";
echo "\t\t\t\$li[] = \$html->link(__('Edit ".Inflector::humanize(Inflector::underscore($alias))."', true), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$singularVar}['{$alias}']['{$details['primaryKey']}']));\n";
echo "\t\t\techo \$html->nestedList(\$li);\n";
echo "\t\t\t?>\n";
?>
		</div>
	</div>
<?php
	endforeach;
endif;
if (empty($associations['hasMany'])) {
	$associations['hasMany'] = array();
}
if (empty($associations['hasAndBelongsToMany'])) {
	$associations['hasAndBelongsToMany'] = array();
}
$relations = array_merge($associations['hasMany'], $associations['hasAndBelongsToMany']);
$i = 0;
foreach ($relations as $alias => $details):
	$otherSingularVar = Inflector::variable($alias);
	$otherPluralHumanName = Inflector::humanize($details['controller']);
?>
	<div class="related">
		<h3><?php echo "<?php __('Related {$otherPluralHumanName}');?>";?></h3>
		<?php echo "<?php if (!empty(\${$singularVar}['{$alias}'])):?>\n";?>
		<table>
<?php
echo "\t\t\t<?php\n";
echo "\t\t\t\$th = array();\n";
foreach ($details['fields'] as $field) {
	echo "\t\t\t\$th[] = __('".Inflector::humanize($field)."', true);\n";
}
echo "\t\t\t\$th[] = __('Actions', true);\n";
echo "\t\t\techo \$html->tableHeaders(\$th);\n";
echo "\t\t\tforeach (\${$singularVar}['{$alias}'] as \${$otherSingularVar}) {\n";
echo "\t\t\t\t\$td = array();\n";

foreach ($details['fields'] as $field) {
	echo "\t\t\t\t\$td[] = h(\${$otherSingularVar}['{$field}']);\n";
}
echo "\t\t\t\t\$actions = array();\n";
echo "\t\t\t\t\$actions[] = \$html->link(__('View', true), array('controller' => '{$details['controller']}', 'action' => 'view', \${$otherSingularVar}['{$details['primaryKey']}']));\n";
echo "\t\t\t\t\$actions[] = \$html->link(__('Edit', true), array('controller' => '{$details['controller']}', 'action' => 'edit', \${$otherSingularVar}['{$details['primaryKey']}']));\n";
echo "\t\t\t\t\$actions[] = \$html->link(__('Delete', true), array('controller' => '{$details['controller']}', 'action' => 'delete', \${$otherSingularVar}['{$details['primaryKey']}']), null, sprintf(__('Are you sure you want to delete # %s?', true), \${$otherSingularVar}['{$details['primaryKey']}']));\n";
echo "\t\t\t\t\$td[] = array(implode('&nbsp;|&nbsp;', \$actions), array('class' => 'actions'));\n";
echo "\t\t\t\techo \$html->tableCells(\$td, array('class' => 'altrow'));\n";
echo "\t\t\t}\n";
echo "\t\t\t?>\n";
?>
		</table>
		<?php echo "<?php endif; ?>\n\n";?>
		<div class="actions">
<?php
echo "\t\t\t<?php\n";
echo "\t\t\t\$li = array();\n";
echo "\t\t\t\$li[] = \$html->link(__('New ".Inflector::humanize(Inflector::underscore($alias))."', true), array('controller' => '{$details['controller']}', 'action' => 'add'));\n";
echo "\t\t\techo \$html->nestedList(\$li);\n";
echo "\t\t\t?>\n";
?>
		</div>
	</div>
<?php endforeach;?>
</div>
<div id="sidebar">
	<div class="block">
		<h3><?php echo "<?php __('Actions');?>";?></h3>
<?php
echo "\t\t<?php\n";
echo "\t\t\$li = array();\n";
echo "\t\t\$li[] = \$html->link(__('Edit {$singularHumanName}', true), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
echo "\t\t\$li[] = \$html->link(__('Delete {$singularHumanName}', true), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), null, sprintf(__('Are you sure you want to delete # %s?', true), \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
echo "\t\t\$li[] = \$html->link(__('List {$pluralHumanName}', true), array('action' => 'index'));\n";
echo "\t\t\$li[] = \$html->link(__('New {$singularHumanName}', true), array('action' => 'add'));\n";
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
	<div class="block notice">
		<h4>Notice Title</h4>
		<p>Morbi posuere urna vitae nunc. Curabitur ultrices, lorem ac aliquam blandit, lectus eros hendrerit eros, at eleifend libero ipsum hendrerit urna. Suspendisse viverra. Morbi ut magna. Praesent id ipsum. Sed feugiat ipsum ut felis. Fusce vitae nibh sed risus commodo pulvinar. Duis ut dolor. Cras ac erat pulvinar tortor porta sodales. Aenean tempor venenatis dolor.</p>
	</div>
</div>
