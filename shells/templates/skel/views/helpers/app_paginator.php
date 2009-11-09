<?php
class AppPaginatorHelper extends AppHelper {
	public $helpers = array('Paginator');

	// 表示件数の選択
	public function limit($currents = array(20, 50, 100), $format = null, $separator = '&nbsp;') {
		if (!$format) {
			$format = __('Limit [ %currents% ]', true);
		}
		
		$model = $this->Paginator->defaultModel();
		$limit =  $this->Paginator->params['paging'][$model]['options']['limit'];
		$count = intval($this->Paginator->params['paging'][$model]['count']);
		$a = array();
		foreach ($currents as $current) {
			if ($current == $limit) {
				$a[] = '<em>'.$current.'</em>';
			} else {
				$a[] = $this->Paginator->link($current, array('limit' => $current));
			}
			if ($current >= $count) {
				break;
			}
		}
		return r('%currents%', implode($separator, $a), $format);
	}

	// 昇順・降順のとき矢印をつける
	public function sort($title, $key = null, $options = array()) {
		if (empty($key)) {
			$key = $this->Paginator->defaultModel().'.'.$title;
			$title = preg_replace('/_id$/', '', $title);
			if (!class_exists('I18n')) {
				App::import('Core', 'i18n');
			}
			$title = I18n::translate(Inflector::humanize($title));
		}
		if (false === strpos($key, '.')) {
			$key = $this->Paginator->defaultModel().'.'.$key;
		}
		$sortKey = $this->Paginator->sortKey();
		$sortDir = $this->Paginator->sortDir();
		if ($key === $sortKey) {
			$title .= ($sortDir === 'asc') ? '<span class="asc">↑</span>': '<span class="desc">↓</span>';
			$options = am($options, array('escape' => false));
		}
		return $this->Paginator->sort($title, $key, $options);
	}
}
?>