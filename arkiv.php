<?php
/*
Template Name: Arkiv
*/
get_header(); ?>

<section id="Content" class="clearfix">

<h1>Arkiv</h1>

<section id="Main" role="main">

<?php
$args = array( 'taxonomy' => 'nummer' );
$terms = get_terms( $args);
$count = count($terms);
$i=0;
$showwmax = 20;


foreach ($terms as $term) {
  $i++;
  $artid = $term->term_id;
  $issue = get_metadata("taxonomy", $term->term_id, 'nr', true);
  $month = get_metadata("taxonomy", $term->term_id, 'manad', true);
  $year = get_metadata("taxonomy", $term->term_id, 'ar', true);
  
  if ($i <= $showwmax) {
  
  	echo '<h2 class="nomargin"><a class="nummer" href="/nummer/' . $term->slug . '">' . $term->name . '</a></h2>' .
  	'<ul class="meta"><li class="ss-rocket">Nummer ' . $issue . '</li><li class="capitalize ss-calendar">' . $month . '</span> ' . $year . '</li></ul>' .
  	'<p class="nomargin">' . $term->description . '</p>';
  
  	if ($i==1){ ?>
      <ul class="artikelLista">
        <?php
          $wpq = array( 'taxonomy' => 'nummer', 'term' => $term->slug );
          $artiklar = new WP_Query ($wpq);
        ?>
        <?php foreach( $artiklar->posts as $post ) : ?>
          <li>
            <a href="<?php echo get_permalink( $post->ID ); ?>" <?php post_class(); ?>">
              <?php echo $post->post_title; ?>
            </a>
          </li>
        <?php endforeach ?>
      </ul>
      <div class="spacergif"></div>
  <?php	 } else {
    echo '<div class="spacergif"></div>';
    }
    
  }
  
}?>


<h2 class="nomargin">Månadsarkiv</h2>
<ul class="monthly">
<?php $args = array(
    'type'            => 'monthly',
    'format'          => 'html', 
    'show_post_count' => true,
    'echo'            => 1
);
wp_get_archives( $args ); ?> 
</ul>

</section><!-- end section main -->

<?php get_sidebar(); ?>

</section><!-- end section Content -->

<?php get_footer(); ?>