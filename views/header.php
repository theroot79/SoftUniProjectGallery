<header>
	<div id="logoarea">
		<a href="/"><img src="/assets/img/logo.jpg" alt="Logo" /></a>
	</div>
	<div id="header-area-right">
		<nav id="menu">
			<ul id="nav-menu">
				<li id="nav-photos" <?php if($this->menuName == 'photos') print 'class="active"';?>><a href="/gallery/">Photos</a></li>
				<li id="nav-albums" <?php if($this->menuName == 'albums') print 'class="active"';?>><a href="/albums/">Albums</a></li>
				<li id="nav-categories" <?php if($this->menuName == 'categories') print 'class="active"';?>><a href="/categories/">By Category</a></li>

				<?php

				if( $this->user && is_array($this->user) && strlen($this->user['email']) > 2){
					print '
					<li id="profile-links">
						<ul>
							<li id="nav-profile" ><a href="/profile/">
								<img src="/assets/img/user_ico.png" />'.$this->user['fname'].'</a></li>
								<li id="nav-myalbums" ';
							if($this->menuName == 'myalbums') print 'class="active"';
								print '><a href="/myalbums/">My Albums</a></li>
						</ul>
					</li>';
				} else {
					print '
					<li id="nav-signup"><a href="/signup/">Sign Up</a></li>';
				}
				?>
			</ul>
		</nav>
		<div id="search-form">
			<form method="post" action="/search/">
				<input type="text" name="search" placeholder="Photos / Albums" id="search-area"
				       value="<?php print $this->searchString; ?>" required="required" maxlength="150"/>
				<button type="submit" name="submit"></button>
			</form>
		</div>
	</div>
</header>