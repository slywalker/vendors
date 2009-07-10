<?php
/* SVN FILE: $Id: index.ctp 8167 2009-05-07 00:53:44Z mark_story $ */
/**
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) :  Rapid Development Framework (http://www.cakephp.org)
 * Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @filesource
 * @copyright     Copyright 2005-2008, Cake Software Foundation, Inc. (http://www.cakefoundation.org)
 * @link          http://www.cakefoundation.org/projects/info/cakephp CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.console.libs.templates.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @version       $Revision: 8167 $
 * @modifiedby    $LastChangedBy: mark_story $
 * @lastmodified  $Date: 2009-05-07 09:53:44 +0900 (Thu, 07 May 2009) $
 * @license       http://www.opensource.org/licenses/mit-license.php The MIT License
 */
?>
<div class="<?php echo $pluralVar;?> index">
<h2><?php echo "<?php __('{$pluralHumanName}');?>";?></h2>
<p>
<?php echo "<?php
echo \$paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?>";?>
</p>
<table>
	<?php
	echo "<?php\n";
	echo "\t\$th = array();\n";
	foreach ($fields as $field) {
		echo "\t\$th[] = \$paginator->sort('{$field}');\n";
	}
	echo "\t\$th[] = __('Actions', true);\n";
	echo "\techo \$html->tableHeaders(\$th);\n";

	echo "\tforeach (\${$pluralVar} as \${$singularVar}) {\n";
	echo "\t\t\$td = array();\n";
	foreach ($fields as $field) {
		$isKey = false;
		if (!empty($associations['belongsTo'])) {
			foreach ($associations['belongsTo'] as $alias => $details) {
				if ($field === $details['foreignKey']) {
					$isKey = true;
					echo "\t\t\$td[] = \$html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}']));\n";
					break;
				}
			}
		}
		if ($isKey !== true) {
			echo "\t\t\$td[] = h(\${$singularVar}['{$modelClass}']['{$field}']);\n";
		}
	}
	echo "\t\t\$actions = array();\n";
	echo "\t\t\$actions[] = \$html->link(__('View', true), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
	echo "\t\t\$actions[] = \$html->link(__('Edit', true), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
	echo "\t\t\$actions[] = \$html->link(__('Delete', true), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']), null, sprintf(__('Are you sure you want to delete # %s?', true), \${$singularVar}['{$modelClass}']['{$primaryKey}']));\n";
	echo "\t\t\$td[] = array(implode('&nbsp;|&nbsp;', \$actions), array('class' => 'actions'));\n";
	echo "\t\techo \$html->tableCells(\$td, array('class' => 'altrow'));\n";
	echo "\t}\n";
	echo "\t?>\n";
	?>
</table>
</div>
<div class="actions-bar">
	<div class="pagination">
		<?php echo "<?php echo \$paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>\n";?>
		 | <?php echo "<?php echo \$paginator->numbers();?>\n"?>
		<?php echo "<?php echo \$paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>\n";?>
	</div>
</div>
<div class="actions">
	<?php
	echo "<?php\n";
	echo "\t\$li = array();\n";
	echo "\t\$li[] = \$html->link(__('New {$singularHumanName}', true), array('action' => 'add'));\n";
	$done = array();
	foreach ($associations as $type => $data) {
		foreach ($data as $alias => $details) {
			if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
				echo "\t\$li[] = \$html->link(__('List ".Inflector::humanize($details['controller'])."', true), array('controller' => '{$details['controller']}', 'action' => 'index'));\n";
				echo "\t\$li[] = \$html->link(__('New ".Inflector::humanize(Inflector::underscore($alias))."', true), array('controller' => '{$details['controller']}', 'action' => 'add'));\n";
				$done[] = $details['controller'];
			}
		}
	}
	echo "\techo \$html->nestedList(\$li);\n";
	echo "\t?>\n";
	?>
</div>
