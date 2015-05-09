<?php

$total = $this->total;

if($total>$resultperpage){

	print '
	<div id="paging">';

	if($page>0){
		$backpage=($page-$resultperpage);
		print '<a href="/albums/'.$backpage.'/" class="prev">&laquo;</a>';
	}

	$a=0;
	$b=0;

	while($a<$total){
		$a=$a+$resultperpage;
		if(($b<(($page/$resultperpage)+10))&&($b>(($page/$resultperpage)-10))){
			print '<a href="/albums/'.($b*$resultperpage).'/"';
			if($page==($b*$resultperpage))
				print ' class="sel"';
			print '>'.($b+1).'</a>';
		}
		$b++;
	}
	if($page<($total-$resultperpage)){
		$nextpage=($page+$resultperpage);
		print '<a href="/albums/'.$nextpage.'/" class="next">&raquo;</a>';
	}
	print '
			</div>';
}
