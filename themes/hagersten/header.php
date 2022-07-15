<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>

	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta charset="<?php bloginfo( 'charset' ); ?>" />

	<meta content="width=device-width; initial-scale=0.9; minimum-scale=0.9; maximum-scale=0.9;" name="viewport">

	<meta name="author" content="<?php wp_title(''); ?><" />

	<meta property="fb:app_id" content="1645564392422950"/>

	<title><?php wp_title(''); ?></title>

	<link rel="shortcut icon" href="<?php bloginfo('template_url'); ?>/bilder/favicon.ico">
	<link rel="apple-touch-icon" href="<?php bloginfo('template_url'); ?>/bilder/apple-touch-icon.png">

	<link rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' ); ?>" media="screen" />
	<?php //jQuery Calendar CSS * ?>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/print.css" media="print" />

	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

	<?php //jQuery Calendar CSS * ?>
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/htmlscript/css/default.css" />
	<link rel="stylesheet" media="screen" type="text/css" href="<?php bloginfo('template_url'); ?>/datepicker.css" />

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>

    <!--[if lt IE 9]>
	<link rel="stylesheet" type="text/css" href="<?php bloginfo('template_url'); ?>/ie8-and-down.css" />
    <![endif]-->

	<?php /*<!--<script src="<?php bloginfo('template_url'); ?>/htmlscript/datepicker.js" type="text/javascript"></script>-->*/ ?>
	<script src="<?php bloginfo('template_url'); ?>/htmlscript/jquery-ui-1.8.23.custom.min.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_url'); ?>/htmlscript/hagersten.js" type="text/javascript"></script>
	<script src="<?php bloginfo('template_url'); ?>/htmlscript/jquery.infinitescroll.min.js" type="text/javascript"></script>

	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/responsive.css" />
	<link rel="stylesheet" href="<?php bloginfo('template_url'); ?>/ninja-form.css" />

	<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'iPhone')
	){ ?>
		<link media="only screen and (max-device-width: 480px)" href="<?php bloginfo('template_url'); ?>/iphone.css" type="text/css" rel="stylesheet" />
	<?php } ?>

	<?php if(strstr($_SERVER['HTTP_USER_AGENT'],'Android')
	){ ?>
		<link media="screen" href="<?php bloginfo('template_url'); ?>/android.css" type="text/css" rel="stylesheet" />
	<?php } ?>

	<!--[if IE]>
		<script src="<?php bloginfo('template_url'); ?>/htmlscript/modernizr.custom.44333.js" type="text/javascript"></script>
	<![endif]-->

<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>
