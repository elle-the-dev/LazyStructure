<!DOCTYPE html
PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <title><?php echo $this->title; ?></title>
<?php $this->head->render(); ?>
</head>
<body>
<?php $this->bodyTop->render(); ?>
<?php $this->body->render(); ?>
<?php $this->bodyBottom->render(); ?>
</body>
</html>

