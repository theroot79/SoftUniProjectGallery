<!DOCTYPE html>
<html>
<head>
	<title>Vasil Tsintsev&lsquo;s Gallery | <?php print $this->pageTitle; ?></title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
	<link rel="icon" href="/assets/img/favicon.png" type="image/x-icon" />
	<link rel="shortcut icon" href="/assets/img/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" href="/assets/css/main.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/assets/css/signup.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/assets/css/myalbums.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/assets/css/profile.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/assets/css/public.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/assets/css/responsive.css" type="text/css" media="all" />
	<link rel="stylesheet" href="/assets/css/print.css" type="text/css" media="print" />
</head>
<body data-layout="default">
	<div id="wrapper">

		<?php $this->getLayoutData('header'); ?>
		<?php print $this->errors; ?>

		<section class="contentblock">
			<?php $this->getLayoutData('body'); ?>
		</section>

		<?php $this->getLayoutData('footer'); ?>

	</div>
</body>
</html>