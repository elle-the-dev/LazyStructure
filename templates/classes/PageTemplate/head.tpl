    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></meta>
    <meta name="Keywords" content="generic, structure, reusable"></meta>
    <meta name="Description" content="Your name in generic"></meta>

    <!-- Enable Chrome Frame in IE when installed -->
    <meta http-equiv="X-UA-Compatible" content="chrome=1"></meta>

    <link rel="stylesheet" href="<?php echo PATH; ?>css/main.css" />
    <link rel="stylesheet" href="<?php echo PATH; ?>css/pagination/simple.css" />
    <link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.7.2/themes/base/jquery-ui.css" type="text/css" />
    <?php $this->styles->render(); ?>

    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>
    <!-- <script type="text/javascript" src="<?php echo PATH; ?>js/jquery.address.min.js"></script> -->
    <script type="text/javascript" src="<?php echo PATH; ?>js/main.js"></script>
    <?php $this->admin->render(); ?>
