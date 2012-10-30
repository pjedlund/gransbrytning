<aside id="Sidebar" role="complementary">
<ul class="wrapper"><!-- start widget ul-wrapper -->

<li id="nummer" class="widget-container">

<?php
  $term_list = get_terms("nummer");
  $taxonomyID = $term_list[0] -> term_id;
  $month = get_metadata("taxonomy", $taxonomyID, 'manad', true);
  $year = get_metadata("taxonomy", $taxonomyID, 'ar', true);
  $issue = get_metadata("taxonomy", $taxonomyID, 'nr', true);
  $artname = get_metadata("taxonomy", $taxonomyID, 'name', true);
  $description = $term_list[0] -> description;
  $slug = $term_list[0] -> slug;
  $baseurl = get_home_url();

  echo '<h3 class="senaste"><a href="' . $baseurl . '/nummer/' . $slug . '">' . $term_list[0]->name . '</a></h3>';
?>
  <ul>
    <?php 
      $wpq = array( 'taxonomy' => 'nummer', 'term' => $slug );
      $artiklar = new WP_Query ($wpq);
    ?>
    <?php foreach( $artiklar->posts as $post ) : ?>
      <li class="artikel">
        <a <?php post_class(''); ?> href="<?php echo get_permalink( $post->ID ); ?>">
          <?php echo $post->post_title; ?>
        </a>
      </li>
    <?php endforeach ?>
  </ul>

</li><!-- end nummer -->

<li id="search-2" class="widget-container widget_search">
  <h3 class="widget-title">Sök</h3>
  <form role="search" method="get" id="searchform" action="http://gransbrytning.se.preview.citynetwork.se/" >
  <label class="assistive-text" for="s">Sök efter:</label>
  <input type="text" placeholder="Sökord..." value="" name="s" id="s" />
  <input class="button" type="submit" id="searchsubmit" value="Sök" />
</form></li>

<?php wp_list_categories('title_h3=Gränser som bryts&depth=0&exclude=1,95,96,97,98,99&title_li=<h3 class="widget-title">' . __('Gränser som bryts') . '</h3>') ?>

<?php // sidebar
dynamic_sidebar('Sidebar'); ?>

</ul><!-- end widget ul-wrapper -->

</aside><!-- end complementary -->