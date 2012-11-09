<?php get_header(); ?>

<section id="Content" class="clearfix">

<?php if (have_posts()) : while (have_posts()) : the_post(); ?>

<h1><?php the_title(); ?></h1>

<div id="Main" role="main">

<section class="post_content clearfix">

<?php 
if (!has_excerpt()) {} else {echo '<p class="excerpt">' . get_the_excerpt() . '</p>' ;}
if (has_post_thumbnail()) {
$cap = the_post_thumbnail_caption();
$fullSrc = wp_get_attachment_image_src(get_post_thumbnail_id(), 'large');
echo '<figure><a class="lightbox" title="' . trim(strip_tags( $cap )) .'" href="' . $fullSrc[0] . '">' . get_the_post_thumbnail($post->ID, 'medium') . '</a><figcaption>' . $cap . '</figcaption></figure>';
} ?>

<?php
//Klistrad 
if (is_sticky()) {

the_content(); ?>
<div class="entry-meta clearfix"><!-- start entry-meta -->
  <?php if(get_query_var('author_name')) :
    $curauth = get_user_by('slug', get_query_var('author_name'));
  else :
    $curauth = get_userdata(get_query_var('author'));
  endif; 
  $dattr = array(
		'size'	=> "thumbnail",
		'alt'	=> "alttext",
		);
  $dattr = array(
			'size'	=> "full",
			'alt'	=> "alttesxt",
		); ?>
		
		<?php echo'<a class="profilbild alignleft" title="'. get_the_author() .'" href="' . get_author_posts_url(get_the_author_meta( 'ID' )) .'">'; $avatar = mt_profile_img(get_the_author_meta( 'ID' ), $dattr); echo '</a>'; ?>
  <?php $baseUrl = get_bloginfo('url');$month = get_the_time('m');$year  = get_the_time('Y');?>
<ul class="entry-meta-lista">
  <li class="ss-user"><?php the_author_posts_link(); ?></li>
  <li class="ss-calendar"><time datetime="<?php the_time('c'); ?>"><a title="Arkiv för <?php the_time('F Y'); ?>" href="<?php  echo $baseUrl .'/'. $year .'/'. $month . '/'; ?>"><?php the_time('j F Y'); ?></a></time></li>
  <?php if (has_category()) { ?>
    <li class="ss-catface"><?php the_category(', '); ?></li>
  <?php } ?>
  <?php if (has_tag()){ ?>
    <li class="ss-tag"><?php the_tags('', ', ', ''); ?></li>
  <?php } ?>
</ul>
<p class="entry-meta-bio"><?php the_author_meta('user_description'); ?></p>
</div><!-- end entry-meta-wrapper -->
<?php }

// För de som är inloggade 
else if (is_user_logged_in()) {

the_content(); ?>
<div class="entry-meta clearfix"><!-- start entry-meta -->
  <?php if(get_query_var('author_name')) :
    $curauth = get_user_by('slug', get_query_var('author_name'));
  else :
    $curauth = get_userdata(get_query_var('author'));
  endif; 
  $dattr = array(
		'size'	=> "thumbnail",
		'alt'	=> "alttext",
		);
  $dattr = array(
			'size'	=> "full",
			'alt'	=> "alttesxt",
		); ?>
		
		<?php echo'<a class="profilbild alignleft" title="'. get_the_author() .'" href="' . get_author_posts_url(get_the_author_meta( 'ID' )) .'">'; $avatar = mt_profile_img(get_the_author_meta( 'ID' ), $dattr); echo '</a>'; ?>
  <?php $baseUrl = get_bloginfo('url');$month = get_the_time('m');$year  = get_the_time('Y');?>
<ul class="entry-meta-lista">
  <li class="ss-user"><?php the_author_posts_link(); ?></li>
  <li class="ss-calendar"><time datetime="<?php the_time('c'); ?>"><a title="Arkiv för <?php the_time('F Y'); ?>" href="<?php  echo $baseUrl .'/'. $year .'/'. $month . '/'; ?>"><?php the_time('j F Y'); ?></a></time></li>
  <?php if (has_category()) { ?>
    <li class="ss-catface"><?php the_category(', '); ?></li>
  <?php } ?>
  <?php if (has_tag()){ ?>
    <li class="ss-tag"><?php the_tags('', ', ', ''); ?></li>
  <?php } ?>
</ul>
<p class="entry-meta-bio"><?php the_author_meta('user_description'); ?></p>
</div><!-- end entry-meta-wrapper -->
<?php }

// Inte inloggad
else { ?>
  <div class="hr"></div><hr />
  <p>Logga in för att läsa hela artikeln.</p>
  <?php wp_login_form();
    $my_id = 8699;
    $post_123 = get_post($my_id); 
    $body = $post_123->post_content;
    echo($body);
} ?>

</section><!-- end post_content section -->

<?php if (is_user_logged_in()){
  comments_template(); 
} else if(is_sticky()){
  comments_template(); 
}

?>

<?php endwhile; endif ?>

</div><!-- end section main -->

<?php get_sidebar(); ?>

</section><!-- end section Content -->

<?php get_footer(); ?>