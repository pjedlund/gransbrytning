<footer class="clearfix" role="contentinfo">

<p class="footerleft"><span class="logotext ss-rocket">Gränsbrytning</span> publiceras med <a href="http://wordpress.org/">WordPress</a>.</p>
<p class="footerright"><a class="ed" href="http://edlunddesign.com/" title="Sajt av Edlund Design">Sajt av Edlund Design</a></p>

</footer>

<?php wp_footer(); ?>

<!-- Scripts - jquery enqueued in functions.php  --> 
<script src="<?php echo get_template_directory_uri(); ?>/js/script.js<?php $m = wp_get_theme(); echo "?" . $m->Version; ?>"></script>

<!--[if (lt IE 9) & (!IEMobile)]>
<script src="<?php echo get_template_directory_uri(); ?>/js/libs/imgsizer.js<?php $m = wp_get_theme(); echo "?" . $m->Version; ?>"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/libs/respond.min.js<?php $m = wp_get_theme(); echo "?" . $m->Version; ?>"></script>
<![endif]-->

</body>
</html>