<div id="main">
	<?php echo "<?php echo \$form->create(null, array('action' => 'delete'));?>\n"?>
	<div class="<?php echo $pluralVar;?> index">
		<h2><?php echo "<?php __('{$pluralHumanName}');?>";?></h2>
		<p>
<?php
echo "\t\t\t<?php
\t\t\techo \$paginator->counter(array(
\t\t\t\t'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
\t\t\t));
?>";
?>
		</p>
		<p><?php echo "<?php echo \$appPaginator->limit();?>";?></p>
		<table>
<?php
echo "\t\t\t<?php\n";
echo "\t\t\t\$th = array();\n";
echo "\t\t\t\$th[] = __('Del', true);\n";
foreach ($fields as $field) {
	echo "\t\t\t\$th[] = \$appPaginator->sort('{$field}');\n";
}
echo "\t\t\t\$th[] = __('Actions', true);\n";
echo "\t\t\techo \$html->tableHeaders(\$th);\n";

echo "\t\t\tforeach (\${$pluralVar} as \$key => \${$singularVar}) {\n";
echo "\t\t\t\t\$td = array();\n";
echo "\t\t\t\t\$td[] = \$form->checkbox('delete.'.\$key, array('value' => \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
foreach ($fields as $field) {
	$isKey = false;
	if (!empty($associations['belongsTo'])) {
		foreach ($associations['belongsTo'] as $alias => $details) {
			if ($field === $details['foreignKey']) {
				$isKey = true;
				echo "\t\t\t\t\$td[] = \$html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}']));\n";
				break;
			}
		}
	}
	if ($isKey !== true) {
		echo "\t\t\t\t\$td[] = h(\${$singularVar}['{$modelClass}']['{$field}']);\n";
	}
}
echo "\t\t\t\t\$actions = array();\n";
echo "\t\t\t\t\$actions[] = \$html->link(__('View', true), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
echo "\t\t\t\t\$actions[] = \$html->link(__('Edit', true), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
echo "\t\t\t\t\$actions[] = \$html->link(__('Delete', true), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), null, sprintf(__('Are you sure you want to delete # %s?', true), \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
echo "\t\t\t\t\$td[] = array(implode('&nbsp;|&nbsp;', \$actions), array('class' => 'actions'));\n";
echo "\t\t\t\techo \$html->tableCells(\$td, array('class' => 'altrow'));\n";
echo "\t\t\t}\n";
echo "\t\t\t?>\n";
?>
		</table>
	</div>
	<div class="actions-bar">
		<div class="actions">
			<?php echo "<?php echo \$form->submit('Delete Selected', array('div' => false));?>\n"?>
		</div>
		<div class="pagination">
			<?php echo "<?php echo \$paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>\n";?>
			<?php echo "<?php echo \$paginator->numbers(array('separator' => null));?>\n"?>
			<?php echo "<?php echo \$paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>\n";?>
		</div>
		<div class="clear"></div>
	</div>
	</form>
</div>
<div id="sidebar">
	<div class="block">
		<h3><?php echo __('Actions');?></h3>
<?php
echo "\t\t<?php\n";
echo "\t\t\$li = array();\n";
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
