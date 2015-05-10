<?php
$url = urldecode('http://'.$_SERVER['HTTP_HOST'].'/');
?>
<footer>
	<div id="copyright">
		<p>
			All rights reserved &copy; <?php print date('Y'); ?> &middot;
			<a href="http://softuni.bg" target="_blank">theroot79@SoftUni</a> &middot;
			<a href="http://validator.w3.org/check?verbose=1&amp;uri=<?php print $url;?>" target="_blank">HTML5</a> &amp;
			<a href="http://jigsaw.w3.org/css-validator/validator?profile=css3&amp;warning=0&amp;uri=<?php print $url;?>" target="_blank">CSS3</a> validated
		</p>
	</div>
	<div id="media">
		<a href="https://www.facebook.com/sharer/sharer.php?u=<?php print $url;?>" target="_blank" class="facebook"></a>
		<a href="https://plus.google.com/share?url=<?php print $url;?>" target="_blank" class="googleplus"></a>
		<a href="https://twitter.com/home?status=<?php print $url;?>" target="_blank" class="twitter"></a>
	</div>
</footer>