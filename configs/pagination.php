<?php



function fh_pagination($query, $per_page = 10, $url = '?',$page = 1){
	global $db, $page;
	$sql = $db->query("SELECT COUNT(*) as `num` FROM ".prefix."{$query}");
	$row = $sql->fetch_array();
	$total = $row['num'];
	$adjacents = "1";

	$page = ($page == 0 ? 1 : $page);
	$start = ($page - 1) * $per_page;

	$prev = $page - 1;
	$next = $page + 1;
	$lastpage = ceil($total/$per_page);
	$lpm1 = $lastpage - 1;

	$pagination = "";
	if($lastpage > 1)
	{
		$pagination .= "<ul class='pt-pagination'>";
		if($prev){
			$pagination .= "<li><a href='{$url}page=$prev'>&laquo;</a></li>";
		}
		else{
			$pagination .= "<li class='pt-disabled'><a>&laquo;</a></li>";
		}
		if ($lastpage < 7 + ($adjacents * 2))
		{
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<li class='pt-active'>$counter</li>";
				else
					$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))
		{
			if($page < 1 + ($adjacents * 2))
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='pt-active'>$counter</li>";
					else
						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
				}
				$pagination.= "<li class='dot'>...</li>";
				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
			}
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
				$pagination.= "<li class='dot'>...</li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='pt-active'>$counter</li>";
					else
						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
				}
				$pagination.= "<li class='dot'>...</li>";
				$pagination.= "<li><a href='{$url}page=$lpm1'>$lpm1</a></li>";
				$pagination.= "<li><a href='{$url}page=$lastpage'>$lastpage</a></li>";
			}
			else
			{
				$pagination.= "<li><a href='{$url}page=1'>1</a></li>";
				$pagination.= "<li><a href='{$url}page=2'>2</a></li>";
				$pagination.= "<li class='dot'>..</li>";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<li class='pt-active'>$counter</li>";
					else
						$pagination.= "<li><a href='{$url}page=$counter'>$counter</a></li>";
				}
			}
		}

		if ($page < $counter - 1){
			$pagination.= "<li><a href='{$url}page=$next'>&raquo;</a></li>";
		}else{
			$pagination.= "<li><a class='current'>&raquo;</a></li>";
		}
		$pagination.= "</ul>\n";
	}


	return $pagination;
}
