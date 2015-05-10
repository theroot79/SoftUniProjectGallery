<div class="admin-table">
	<?php

	if($this->users && is_array($this->users) && count($this->users) > 0){

		print '
		<table border="1" width="100%" cellpadding="0" cellspacing="0">
			<tr>
				<th>User ID:</th>
				<th>First name:</th>
				<th>Last name:</th>
				<th>Role</th>
				<th>Action</th>
			</tr>';

		foreach($this->users as $user){
			if($user['uid'] != $this->user['uid']){
				$roleAdmin = '';
				if($user['role'] == 'admin')$roleAdmin = ' selected="selected"';
				print '
				<tr>
					<td>'.$user['uid'].'</td>
					<td>'.$user['fname'].'</td>
					<td>'.$user['lname'].'</td>
					<td>
						<form method="post">
							<select name="role" onchange="this.form.submit()">
								<option value="user" selected="selected">User</option>
								<option value="admin"'.$roleAdmin.'>Admin</option>
							</select>
							<input type="hidden" name="userid" value="'.$user['uid'].'" />
						</form>
					</td>
					<td>
						<a href="/admin/users/del/'.$user['uid'].'">Delete</a>
					</td>
				</tr>';
			}
		}

		print '
		</table>';
	}
	?>
</div>