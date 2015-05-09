<div id="signup">

	<div id="register-form">
		<h1>Not a member? <strong>Register</strong></h1>
		<form method="post" action="/signup/" class="frm">
			<p>
				<input type="text" name="fname" value="" placeholder="First name" required="required"/>
				<input type="text" name="lname" value="" placeholder="Last name" required="required"/>
			</p>
			<p>
				<input type="email" name="email" value="" placeholder="Email" required="required"/>
				<input type="password" name="password" value="" placeholder="Password" required="required"/>
			</p>
			<p><button type="submit" name="submit">Register</button></p>
			<input type="hidden" name="action" value="register"/>
		</form>
	</div>

	<div id="login-form">
		<h2>Login</h2>
		<form method="post" action="/signup/" class="frm">
			<p><input type="email" name="email" value="" placeholder="Email" required="required"/></p>
			<p><input type="password" name="password" value="" placeholder="Password" required="required"/></p>
			<p><button type="submit" name="submit">Login</button></p>
			<input type="hidden" name="action" value="login"/>
		</form>
	</div>

</div>
