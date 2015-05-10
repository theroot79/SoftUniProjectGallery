
<div id="publicphotos">
	<h1>Latest Uploads</h1>
	<div id="p-albums-items">
<?php

if(is_array($this->latestPhotos)) {
	foreach ($this->latestPhotos as $photo) {
		print '
		<div class="p-photos-block">
			<a href="/photo/' . $photo['phid'] . '/" class="aimgi">
				<img src="/photos/' . $photo['uid'] . '/t_' . $photo['filename'] . '" alt="' . $photo['name'] . '"/>
			</a>
			<div class="p-photos-inf">
				<strong class="p-photos-name">' . $photo['name'] . '</strong>
				<strong class="p-photos-author">from Album (<a href="/album/view/' . $photo['aid'] . '/" >link</a>)</strong>
				<em class="p-photos-date">' . substr($photo['created'], 0, 10) . '</em>
			</div>
		</div>';
	}
}
?>
	</div>
</div>