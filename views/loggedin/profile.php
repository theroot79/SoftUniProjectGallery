<div id="profile">
	<div id="profile-form">
		<h1>Update your profile</h1>
		<form method="post" action="/profile/" class="frm">
			<p>
				<input type="text" name="fname" value="<?php print $this->user['fname'] ?>"
				       placeholder="First name" required="required"/>
				<input type="text" name="lname" value="<?php print $this->user['lname'] ?>"
				       placeholder="Last name" required="required"/>
			</p>
			<p>
				<input type="password" name="password" value=""
				       placeholder="Password" title="Leave empty if you don't need to change"/>
				<button type="submit" name="submit">Update</button>
			</p>
			<input type="hidden" name="action" value="update"/>
		</form>
	</div>
	<div id="profile-form-logout">
		<a href="/logout/">Logout</a>
	</div>
</div>