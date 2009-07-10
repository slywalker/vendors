<?php
/* SVN FILE: $Id: form.ctp 8167 2009-05-07 00:53:44Z mark_story $ */
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
<div class="<?php echo $pluralVar;?> form">
	<?php
	echo "<?php\n";
	echo "\techo \$form->create('{$modelClass}');\n";
	echo "\techo \$form->inputs(array(\n";
	echo "\t\t'legend' => __('".Inflector::humanize($action)." {$singularHumanName}', true),\n";
	foreach ($fields as $field) {
		if ($action == 'add' && $field == $primaryKey) {
			continue;
		} elseif (!in_array($field, array('created', 'modified', 'updated'))) {
			echo "\t\t'{$field}',\n";
		}
	}
	if (!empty($associations['hasAndBelongsToMany'])) {
		foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
			echo "\t\t'{$assocName}',\n";
		}
	}
	echo "\t));\n";
	echo "\techo \$form->end('Submit');\n";
	echo "\t?>\n";
	?>
</div>
<div class="actions">
	<?php
	echo "<?php\n";
	echo "\t\$li = array();\n";
	if ($action != 'add') {
		echo "\t\$li[] =\$html->link(__('Delete', true), array('action' => 'delete', \$form->value('{$modelClass}.{$primaryKey}')), null, sprintf(__('Are you sure you want to delete # %s?', true), \$form->value('{$modelClass}.{$primaryKey}')));\n";
	}
	echo "\t\$li[] = \$html->link(__('List {$pluralHumanName}', true), array('action' => 'index'));\n";
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
