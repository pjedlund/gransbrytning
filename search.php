<?php get_header();?>

<section id="Content" class="clearfix">

<h1><?php echo 'Sökresultat för &ldquo;' . $s . '&rdquo;'; ?></h1>

<section id="Main" role="main">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix'); ?>>

<header>

<h2 class="nomargin"><a href="<?php the_permalink(); ?>" <?php post_class(); ?> rel="bookmark"><?php the_title(); ?></a></h2>
<ul class="meta">
<li class="ss-user"><a title="Alla inlägg av <?php the_author_meta('display_name'); ?>" href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a></li>
<?php $baseUrl = get_bloginfo('url');$month = get_the_time('m');$year  = get_the_time('Y');?>
<li class="ss-calendar"><time datetime="<?php the_time('c'); ?>"><a title="Arkiv för <?php the_time('F Y'); ?>" href="<?php  echo $baseUrl .'/'. $year .'/'. $month . '/'; ?>"><?php the_time('j F Y'); ?></a></time></li>
<?php if (has_tag()){ the_tags('<li class="ss-tag">',', ','</li>');} ?>
</ul>

</header> <!-- end article header -->

<section class="post_content clearfix">

<?php the_excerpt(); ?>
<!-- <p class="textright"><a class="more button" href="<?php the_permalink(); ?> ">Läs mer<span class="hidden"> av <?php the_title(); ?> </span></a></p> -->

</section><!-- end article section -->

</article> <!-- end article -->

<?php comments_template(); ?>

<?php endwhile; ?>

<?php else : ?>

<div>
<h2>Tyvärr, inga träffar för &ldquo;<em><?php echo esc_html($s, 1); ?></em>&rdquo;. <?php if (function_exists('relevanssi_didyoumean')) {
    relevanssi_didyoumean(get_search_query(), "Du kanske menade ", "?", 5);
}?></h2>
</div>

<?php endif; ?>

<?php if(function_exists('wp_paginate')) {
    wp_paginate();
} ?>

</section><!-- end section main -->

<?php get_sidebar(); ?>

</section><!-- end section Content -->

<?php get_footer(); ?>