<div id="add-photo">

	<div id="add-photo-form">
		<h2>Upload new photo</h2>
		<form method="post" class="frm" enctype="multipart/form-data">
			<p><input type="file" name="file" value="" required="required" accept="image/*"/>
				<input type="text" name="name" value="" placeholder="Photo name"
				       required="required" maxlength="150" /></p>
			<p><button type="submit" name="submit">Upload now</button></p>
			<input type="hidden" name="action" value="addfile"/>
		</form>
	</div>
</div>
<div id="photos-manage-blk">
	<h2>Your photos in the album</h2>
	<div id="photos-manage-items">
		<div class="photos-manage-block">
			<a href="/photos/5/yuid8vyli9kwjk9.jpg" class="aimgi" target="_blank">
				<img src="/photos/5/t_yuid8vyli9kwjk9.jpg" alt="csdacsadcsc sd csdcs csdcs"/>
			</a>
			<div class="photos-manage-btns">
				<strong>csdacsadcsc sd csdcs csdcs</strong>
				<a href="?action=editphoto&amp;id=90">edit</a>
				<a href="?action=delphoto&amp;id=90">del</a>
			</div>
		</div>
		<div class="photos-manage-block">
			<a href="/photos/5/pt8u3ixbc7iu5os.jpg" class="aimgi" target="_blank">
				<img src="/photos/5/t_pt8u3ixbc7iu5os.jpg" alt="jnk n jknknkj"/>
			</a>
			<div class="photos-manage-btns">
				<strong>jnk n jknknkj</strong>
				<a href="?action=editphoto&amp;id=68">edit</a>
				<a href="?action=delphoto&amp;id=68">del</a>
			</div>
		</div>
		<div class="photos-manage-block">
			<a href="/photos/5/52lv2lat3gltkqw.jpg" class="aimgi" target="_blank">
				<img src="/photos/5/t_52lv2lat3gltkqw.jpg" alt="jiujuiijiu j"/>
			</a>
			<div class="photos-manage-btns">
				<strong>jiujuiijiu j</strong>
				<a href="?action=editphoto&amp;id=67">edit</a>
				<a href="?action=delphoto&amp;id=67">del</a>
			</div>
		</div>
	</div>
</div>