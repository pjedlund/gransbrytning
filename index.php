<?php get_header(); ?>

<?php $term_list = get_terms('nummer');
$taxonomyID = $term_list[0] -> term_taxonomy_id;
$month = get_metadata("taxonomy", $taxonomyID, 'manad', true);
$year = get_metadata("taxonomy", $taxonomyID, 'ar', true);
$issue = get_metadata("taxonomy", $taxonomyID, 'nr', true);
$description = $term_list[0] -> description;
$slug = $term_list[0] -> slug;
$issueTitle = $term_list[0] -> name;
$baseurl = get_home_url(); ?>

<section id="Content" class="clearfix">
<h1><?php 
if (is_category()){ 
  echo 'Arkiv för kategorin <span>&ldquo;' . single_cat_title('', false) . '&rdquo;</span>';
}
elseif (is_tag())  {
  echo 'Arkiv för etiketten <span>&ldquo;' . single_tag_title('', false ) . '&rdquo;</span>';
} 
elseif (is_archive()){ 
  echo 'Arkiv för <span>&ldquo;'; echo theme_get_archive_date(); echo '&rdquo;</span>';
}
else {
  echo $issueTitle;
}
?>
</h1>

<section id="Main" role="main">

<?php if (is_category()){
  /* $categ = get_the_category(); */
  if (category_description()) {
    echo '<p class="excerpt">' . category_description() . '</p><div class="rocketdiv"></div>';
  }
}
else if (!is_archive()){ 
  echo '<p class="excerpt">' . $description . '</p><div class="rocketdiv"></div>';
}
?>

<?php
if (!is_archive()){
  query_posts( array( 'nummer' => $slug ) );
}
if (have_posts()) : while (have_posts()) : the_post(); 
?>

<article id="post-<?php the_ID(); ?>" class="clearfix">

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

<?php 
if (has_post_thumbnail()) {
$cap = the_post_thumbnail_caption();
echo '<figure class="addmargin"><a title="' . trim(strip_tags( $cap )) .'" href="' . get_permalink() . '">' . get_the_post_thumbnail($post->ID, 'medium') . '</a></figure>';
} ?>

<?php
  echo '<p>' . get_the_excerpt() . '</p>';
?>

</section><!-- end article section -->

</article> <!-- end article -->

<?php endwhile; endif; ?>

<?php if(function_exists('wp_paginate')) {
    wp_paginate();
} ?>

</section><!-- end section main -->

<?php get_sidebar(); ?>

</section><!-- end section Content -->

<?php get_footer(); ?>