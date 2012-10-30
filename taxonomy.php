<?php get_header(); ?>

<section id="Content" class="clearfix">

<?php
$taxonomy = "nummer";
$term_list = wp_get_post_terms($post->ID, 'nummer', array("fields" => "all"));
$taxonomyID = $term_list[0] -> term_taxonomy_id;
$issuename = $term_list[0] -> name;
$description = $term_list[0] -> description;
?>

<h1><?php echo $issuename ?></h1>
  
<section id="Main" role="main">

<p class="excerpt"><?php echo $description; ?></p>

<div class="rocketdiv"></div>

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clear	fix'); ?>>

<header>

<h2 class="nomargin"><a <?php post_class(''); ?> href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
<ul class="meta">
<li class="ss-user"><a title="Alla inlägg av <?php the_author_meta('display_name'); ?>" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a></li>
<?php $baseUrl = get_bloginfo('url');$month = get_the_time('m');$year  = get_the_time('Y');?>
<li class="ss-calendar"><time datetime="<?php the_time('c'); ?>"><a title="Arkiv för <?php the_time('F Y'); ?>" href="<?php  echo $baseUrl .'/'. $year .'/'. $month . '/'; ?>"><?php the_time('j F Y'); ?></a></time></li>
<?php if (has_tag()){ the_tags('<li class="ss-tag">',', ','</li>');} ?>
</ul>

</header> <!-- end article header -->

<section class="post_content clearfix">

<?php 
if (has_post_thumbnail()) {
$cap = the_post_thumbnail_caption();
echo '<figure class="addmargin"><a title="' . trim(strip_tags( $cap )) .'" href="' . get_permalink() . '">' . get_the_post_thumbnail($post->ID, 'medium') . '</a></figure>';
} ?>

<?php the_excerpt(); ?>

</section><!-- end article section -->

</article> <!-- end article -->

<?php comments_template(); ?>

<?php endwhile; endif ?>

<?php if(function_exists('wp_paginate')) {
    wp_paginate();
} ?>

</section><!-- end section main -->

<?php get_sidebar(); ?>

</section><!-- end section Content -->

<?php get_footer(); ?>