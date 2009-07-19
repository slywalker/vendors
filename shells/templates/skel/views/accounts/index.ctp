<div id="main">
	<?php echo $form->create(null, array('action' => 'delete'));?>
	<div class="accounts index">
		<h2><?php __('Accounts');?></h2>
		<p>
			<?php
			echo $paginator->counter(array(
				'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
			));
?>		</p>
		<p><?php echo $appPaginator->limit();?></p>
		<table>
			<?php
			$th = array();
			$th[] = __('Del', true);
			$th[] = $appPaginator->sort('id');
			$th[] = $appPaginator->sort('name');
			$th[] = $appPaginator->sort('email');
			$th[] = $appPaginator->sort('disabled');
			$th[] = __('Actions', true);
			echo $html->tableHeaders($th);
			foreach ($accounts as $key => $account) {
				$td = array();
				$td[] = $form->checkbox('delete.'.$key, array('value' => $account['Account']['id']));
				$td[] = h($account['Account']['id']);
				$td[] = h($account['Account']['name']);
				$td[] = h($account['Account']['email']);
				$td[] = h($account['Account']['disabled']);
				$actions = array();
				$actions[] = $html->link(__('View', true), array('action' => 'view', $account['Account']['id']));
				$actions[] = $html->link(__('Edit', true), array('action' => 'edit', $account['Account']['id']));
				$actions[] = $html->link(__('Delete', true), array('action' => 'delete', $account['Account']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $account['Account']['id']));
				$td[] = array(implode('&nbsp;|&nbsp;', $actions), array('class' => 'actions'));
				echo $html->tableCells($td, array('class' => 'altrow'));
			}
			?>
		</table>
	</div>
	<div class="actions-bar">
		<div class="actions">
			<?php echo $form->submit(__('Delete Selected', true), array('div' => false));?>
		</div>
		<div class="pagination">
			<?php echo $paginator->prev('<< '.__('previous', true), array(), null, array('class'=>'disabled'));?>
			<?php echo $paginator->numbers(array('separator' => null));?>
			<?php echo $paginator->next(__('next', true).' >>', array(), null, array('class' => 'disabled'));?>
		</div>
		<div class="clear"></div>
	</div>
	</form>
</div>
<div id="sidebar">
	<div class="block">
		<h3><?php __('Actions');?></h3>
		<?php
		$li = array();
		$li[] = $html->link(__('New Account', true), array('action' => 'add'));
		echo $html->nestedList($li, array('class'=>'navigation'));
		?>
	</div>
	<div class="block notice">
		<h4>Notice Title</h4>
		<p>Morbi posuere urna vitae nunc. Curabitur ultrices, lorem ac aliquam blandit, lectus eros hendrerit eros, at eleifend libero ipsum hendrerit urna. Suspendisse viverra. Morbi ut magna. Praesent id ipsum. Sed feugiat ipsum ut felis. Fusce vitae nibh sed risus commodo pulvinar. Duis ut dolor. Cras ac erat pulvinar tortor porta sodales. Aenean tempor venenatis dolor.</p>
	</div>
</div>
