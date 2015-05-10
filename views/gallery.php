<div id="publicphotos">
	<div id="p-albums-items">
		<?php
		if($this->photos && is_array($this->photos) && count($this->photos) > 0) {
			foreach ($this->photos as $photo) {
				print '
				<div class="p-photos-block">
					<a href="/photo/view/' . $photo['phid'] . '" class="aimgi">
						<img src="/photos/' . $photo['uid'] . '/t_' . $photo['filename'] . '" alt="' . $photo['name'] . '"/>
					</a>
					<div class="p-photos-inf">
						<strong class="p-photos-name">' . $photo['name'] . '</strong>
						<strong class="p-photos-author">from Album: <a href="/album/view/' . $photo['aid'] . '/" >' . $photo['album'] . '</a></strong>
						<em class="p-photos-date">' . $photo['created'] . '</em>
					</div>
				</div>';
			}
		}
		?>
	</div>
	<?php
	if($this->photos && is_array($this->photos) && count($this->photos) > 0){
		print $this->paging;
	}
	?>
</div>

