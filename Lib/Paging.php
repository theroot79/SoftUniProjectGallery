<?php

namespace Lib;

use \VTF\Db;


class Paging
{

	public function display($total, $page, $offset, $baseURL = '')
	{
		$result = '';

		if ($total > $offset) {

			$result .= '
			<div id="paging">';

			if ($page > 0) {
				$backpage = ($page - $offset);
				$result .= '<a href="' . $baseURL . '/page/' . $backpage . '" class="prev">&laquo;</a>';
			}

			$a = 0;
			$b = 0;

			while ($a < $total) {
				$a = $a + $offset;
				if (($b < (($page / $offset) + 10)) && ($b > (($page / $offset) - 10))) {
					$result .= '<a href="' . $baseURL . '/page/'. ($b * $offset) . '/"';
					if ($page == ($b * $offset))
						$result .= ' class="sel"';
					$result .= '>' . ($b + 1) . '</a>';
				}
				$b++;
			}
			if ($page < ($total - $offset)) {
				$nextpage = ($page + $offset);
				$result .= '<a href="' . $baseURL . '/page/' . $nextpage . '/" class="next">&raquo;</a>';
			}
			$result .= '
			</div>';
		}

		return $result;

	}
}