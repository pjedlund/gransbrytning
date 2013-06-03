<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 9]>    <html class="no-js ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 9]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->

<head>

<meta charset="utf-8" />
<title><?php wp_title('&laquo;', true, 'right'); ?><?php bloginfo('name'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<script src="<?php echo get_template_directory_uri(); ?>/js/libs/modernizr-2.5.3.min.js"></script>

<?php wp_head(); ?>

<link id="base-css" rel="stylesheet" href="<?php bloginfo( 'stylesheet_url' );$m = wp_get_theme(); echo "?" . $m->Version; ?>" />
<link href='http://fonts.googleapis.com/css?family=Abril+Fatface|Open+Sans:400,300' rel='stylesheet' />

</head>

<body <?php body_class(); ?>>

<header role="banner" class="clearfix">

<ul id="Accessibility">
<li><a href="#Content">Hoppa till innehåll</a></li>
<li><a href="#MainNav">Hoppa till navigering</a></li>
<li><a href="#searchform">Hoppa till sökruta</a></li>
</ul>

<p class="tagline"><a href="<?php $baseurl = get_home_url(); echo $baseurl; ?>" class="logotext ss-rocket">Gränsbrytning</a> &mdash; omvärldsbevakning och analys av ett samhälle i förändring. <a class="ss-right right lasmer" href="<?php $baseurl = get_home_url(); echo $baseurl . '/om'; ?>">Läs mer</a></p>

<div id="NavContainer" class="clearfix">

<nav id="MainNav" role="navigation" class="clearfix">
<?php $baseurl = get_home_url(); ?>
<?php
if (is_user_logged_in()) { ?>
<ul class="clearfix">
<li class="hem"><a class="ss-home" href="<?php echo $baseurl; ?>">Hem</a></li>
<li class="arkiv"><a class="ss-storagebox" href="<?php echo $baseurl; ?>/arkiv/">Arkiv</a></li>
<li class="om"><a class="ss-binoculars" href="<?php echo $baseurl; ?>/om/">Om</a></li>
<li class="kontakt"><a class="ss-touchtonephone" href="<?php echo $baseurl; ?>/kontakt/">Kontakt</a></li>
</ul>
<div></div>
<?php } else { ?>
<ul class="clearfix">
<li class="hem"><a class="ss-home" href="<?php echo $baseurl; ?>">Hem</a></li>
<li class="arkiv"><a class="ss-storagebox" href="<?php echo $baseurl; ?>/arkiv/">Arkiv</a></li>
<li class="om"><a class="ss-binoculars" href="<?php echo $baseurl; ?>/om/">Om</a></li>
<li class="prenumerera"><a class="ss-user" href="<?php echo $baseurl; ?>/prenumerera/">Prenumerera</a></li>
</ul>
<div></div>
<?php } ?>
</nav>
<div id="leftSnurf"></div><div id="rightSnurf"></div>
<?php getBadge(); ?>
</div><!-- end navcontainer -->

<!-- oh, IE, you fool.. http://www.sitepoint.com/fix-disappearing-absolute-position-element-ie/ -->
<div></div>

</header>

