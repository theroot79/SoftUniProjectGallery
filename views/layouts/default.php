<!DOCTYPE html>
<html>
<head>
	<title><?php print $this->title; ?> | default layout</title>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
</head>
<body>
	<?php $this->getLayoutData('header'); ?>
	<?php $this->getLayoutData('body'); ?>
	<?php $this->getLayoutData('footer'); ?>
</body>
</html>