<div id="albums-blk">
	<h2>Albums:</h2>
	<div id="albums-blk-items">
<?php

foreach ($this->latestAlbums as $album){
	print_r($this->albumObj->smallAlbumBlock($album['aid']));
}
?>
	</div>
</div>