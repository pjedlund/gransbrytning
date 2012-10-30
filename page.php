<?php get_header(); ?>

<section id="Content" class="clearfix">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<h1><?php the_title(); ?></h1> 

<div id="Main">

<section class="post_content clearfix">

<?php the_content(); ?>

<div class="hr"></div><hr />

</section><!-- end post_content section -->

<?php comments_template(); ?>

<?php endwhile; endif ?>

</div><!-- end section main -->

<?php get_sidebar(); ?>

</section><!-- end section Content -->

<?php get_footer(); ?>