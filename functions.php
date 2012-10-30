<?php 

/**** Add post thumbnail functionality ****/
if (function_exists('add_theme_support')){
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 287, 200, true );//  thumbnail size 160 = 16/9
add_image_size( 'medium', 627, 627 ); // medium == 2 columns
add_image_size( 'large', 1440, 1024 ); // lightbox size 
}

remove_filter('term_description','wpautop');

/****  Logo for login form ****/
function my_login_logo() { ?>
    <style type="text/css">
        body.login div#login h1 a {
            background-image: url(<?php echo get_bloginfo( 'template_directory' ) ?>/img/gransbrytning-logo.svg);
            padding-bottom: 0px;
        }
    </style>
<?php }
add_action( 'login_enqueue_scripts', 'my_login_logo' );

function my_login_logo_url() {
    return get_bloginfo( 'url' );
}
add_filter( 'login_headerurl', 'my_login_logo_url' );

function my_login_logo_url_title() {
    return 'Gränsbrytning';
}
add_filter( 'login_headertitle', 'my_login_logo_url_title' );



/**** Maintenance mode ****/
function admin_maintenace_mode() {
    global $current_user;
    get_currentuserinfo();
    if($current_user->user_login != 'admin') { ?>
			<style> .updated{margin:3em !important;} </style><?
			die('<h3 id="message" class="updated">Underhållsarbete pågår.</h3>');
		}
}
//add_action('admin_head', 'admin_maintenace_mode');

/**** Badge ****/
function getBadge () {
 if (!is_page() && !is_search() && !is_404() && !is_home()) {
    global $post;
    $term_list = wp_get_post_terms($post->ID, "nummer", array("fields" => "all"));
  } else {
    $term_list = get_terms("nummer");
  }
  
  $baseurl = get_home_url();
  
  if ($term_list) {
      $taxonomyID = $term_list[0] -> term_id;
      $year = get_metadata("taxonomy", $taxonomyID, 'ar', true);
      $issue = get_metadata("taxonomy", $taxonomyID, 'nr', true);
      $description = $term_list[0] -> description;
      $slug = $term_list[0] -> slug;
    
      echo '
      <div id="Badge">
      <a id="Issue" href="' . $baseurl . '/nummer/'. $slug . '">' . $issue . '</a>
      <a id="Year" href="' . $baseurl . '/' . $year . '">' . $year . '</a>
      </div>';
    } else {
      global $post;
      $thayear = $post->post_name;
      echo '
      <div id="Badge">
      <a id="Issue" href="' . $baseurl. '">/</a>
      <a id="Year" href="' . $baseurl . '/' . get_the_date( "Y" ) . '">' . get_the_date( "Y" ) . '</a></div>';
    }
}

/**** Get subscriber role ****/
/*
function is_subscriber() {
	global $current_user;
	get_currentuserinfo();
	if ( current_user_can('read') ) {
      return true;
  } else {
    return false;
  }
}
*/

/**** Enqueue jquery ****/
function enqueue_jquery() {
    if( !is_admin() ){
    	wp_deregister_script('jquery');
    	wp_register_script('jquery', ("https://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"), false, '1.8.0', true);
    	wp_enqueue_script('jquery');
    }
}
add_action('wp_enqueue_scripts', 'enqueue_jquery');

/* remove plugin script/css */
function my_deregister_plugs() {
    $handles = array('wp-paginate', 'fdfootnote_script', 'jetpack-widgets');
    foreach($handles as $handle){
        wp_deregister_style( $handle);
        wp_deregister_script( $handle);
    }
}
add_action( 'wp_print_styles', 'my_deregister_plugs', 100 );



/**** Remove css for wp-paginate ****/
/*
function my_deregister_styles(){wp_deregister_style('wp-paginate');}
add_action('wp_print_styles','my_deregister_styles',100);
*/

/**** Remove js for wp-footnote ****/
/*
function my_deregister_footnotes() {
	wp_deregister_script( 'fd_footnotes' );
}
add_action( 'wp_print_scripts', 'my_deregister_footnotes', 100 );
*/
/* rc='http://gransbrytning.se/wp-content/plugins/fd-footnotes/fdfootnotes.js?ver=1.3'></script> */


/**** Remove rel="cat" since it's not valid html5 ****/
function add_nofollow_cat( $text ) {
  $text = str_replace('rel="category tag"', '', $text); 
  return $text;
}
add_filter( 'the_category', 'add_nofollow_cat' );


/**** Post thumnail captions ****/
function the_post_thumbnail_caption() {
  global $post;
  $thumbnail_id    = get_post_thumbnail_id($post->ID);
  $thumbnail_image = get_posts(array('p' => $thumbnail_id, 'post_type' => 'attachment'));
  if ($thumbnail_image && isset($thumbnail_image[0])) {
    return $thumbnail_image[0]->post_excerpt;
  }
}


/**** Enable menus ****/
add_action( 'init', 'register_my_menus' );
function register_my_menus() {
	register_nav_menus(
		array(
			'huvudnavigering' => __( 'Huvudnavigering' ),
			'enkolumnnsavigering' => __( 'Enkolumnnsavigering' )
		)
	);
}


/**** Visual editor styles ****/
add_action( 'after_setup_theme', 'wptuts_theme_setup' );
function wptuts_theme_setup() {
    set_user_setting( 'dfw_width', 500 );
}
add_editor_style();


/**** Add post classes  ****/
function additional_post_classes( $classes ) {
	global $wp_query;
	if( $wp_query->found_posts < 1 ) {return $classes;}
	if( $wp_query->current_post == 0 ) {$classes[] = 'post-first';}
	if( $wp_query->current_post % 2 ) {$classes[] = 'post-even';} else {$classes[] = 'post-odd';}
	if( $wp_query->current_post == ( $wp_query->post_count - 1 ) ) {$classes[] = 'post-last';}
	return $classes;
}
add_filter( 'post_class', 'additional_post_classes' );


/**** Remove target _blank etc. ****/
function rel_external($content){
	$regexp = '/\<a[^\>]*(target="_([\w]*)")[^\>]*\>[^\<]*\<\/a>/smU';
	if( preg_match_all($regexp, $content, $matches) ){
		for ($m=0;$m<count($matches[0]);$m++) {
			if ($matches[2][$m] == 'blank') {
				$temp = str_replace($matches[1][$m], 'rel="external"', $matches[0][$m]);
				$content = str_replace($matches[0][$m], $temp, $content);
			} else if ($matches[2][$m] == 'self') {
				$temp = str_replace(' ' . $matches[1][$m], '', $matches[0][$m]);
				$content = str_replace($matches[0][$m], $temp, $content);
			}
		}
	}
	return $content;
}
add_filter('the_content', 'rel_external');

/* -----------------------------
MODIFIED WPAUTOP - Allow HTML5 block elements in wordpress posts
----------------------------- */

function html5autop($pee, $br = 1) {
   if ( trim($pee) === '' )
      return '';
   $pee = $pee . "\n"; // just to make things a little easier, pad the end
   $pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
   // Space things out a little
// *insertion* of section|article|aside|header|footer|hgroup|figure|details|figcaption|summary
   $allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr|fieldset|legend|section|article|aside|header|footer|hgroup|figure|details|figcaption|summary)';
   $pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
   $pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
   $pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
   if ( strpos($pee, '<object') !== false ) {
      $pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
      $pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
   }
   $pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
   // make paragraphs, including one at the end
   $pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
   $pee = '';
   foreach ( $pees as $tinkle )
      $pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
   $pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
// *insertion* of section|article|aside
   $pee = preg_replace('!<p>([^<]+)</(div|address|form|section|article|aside)>!', "<p>$1</p></$2>", $pee);
   $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
   $pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
   $pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
   $pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
   $pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
   $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
   if ($br) {
      $pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', create_function('$matches', 'return str_replace("\n", "<WPPreserveNewline />", $matches[0]);'), $pee);
      $pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
      $pee = str_replace('<WPPreserveNewline />', "\n", $pee);
   }
   $pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
// *insertion* of img|figcaption|summary
   $pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol|img|figcaption|summary)[^>]*>)!', '$1', $pee);
   if (strpos($pee, '<pre') !== false)
      $pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee );
   $pee = preg_replace( "|\n</p>$|", '</p>', $pee );

   return $pee;
}

// remove the original wpautop function
remove_filter('the_excerpt', 'wpautop');
remove_filter('the_content', 'wpautop');
  
// add our new html5autop function
add_filter('the_excerpt', 'html5autop');
add_filter('the_content', 'html5autop');


/**** rewrite captions to figure ****/
/*
add_shortcode('wp_caption', 'fixed_img_caption_shortcode');
add_shortcode('caption', 'fixed_img_caption_shortcode');

function fixed_img_caption_shortcode($attr, $content = null) {
	// Allow plugins/themes to override the default caption template.
	$output = apply_filters('img_caption_shortcode', '', $attr, $content);
	if ( $output != '' ) return $output;
	extract(shortcode_atts(array(
		'id'=> '',
		'align'	=> 'alignnone',
		'width'	=> '',
		'caption' => ''), $attr));
	return '<figure class="wp-caption">'
	. do_shortcode( $content ) . '<figcaption class="wp-caption-text">'
	. $caption . '</figcaption></figure>';
}
*/




/**
 * Filter to replace the [caption] shortcode text with HTML5 compliant code
 *
 * @return text HTML content describing embedded figure
 **/
function my_img_caption_shortcode_filter($val, $attr, $content = null)
{
	extract(shortcode_atts(array(
		'id'	=> '',
		'align'	=> '',
		'width'	=> '',
		'caption' => ''
	), $attr));
	
	if ( 1 > (int) $width || empty($caption) )
		return $val;

	$capid = '';
	if ( $id ) {
		$id = esc_attr($id);
		$capid = 'id="figcaption_'. $id . '" ';
		$id = 'id="' . $id . '" aria-labelledby="figcaption_' . $id . '" ';
	}

	return '<figure ' . $id . 'class="wp-caption ' . esc_attr($align) . '">' . do_shortcode( $content ) . '<figcaption ' . $capid 
	. 'class="wp-caption-text">' . $caption . '</figcaption></figure>';
}
/* add_filter('img_caption_shortcode', 'my_img_caption_shortcode_filter',10,3); */


/**** add "lightbox" to all image links ****/
function my_addlightboxrel($content) {
  global $post;
  if (isset($caption)){
      $cap = $caption;
  } else {
      $cap = "";
  }
  $pattern ="/<a(.*?)href=('|\")(.*?).(bmp|gif|jpeg|jpg|png)('|\")(.*?)>/i";
  $replacement = '<a$1href=$2$3.$4$5 class="lightbox" title="'. $cap.'"$6>';
  $content = preg_replace($pattern, $replacement, $content);
  return $content;
}
/* add_filter('the_content', 'my_addlightboxrel'); */


/**** Archive date function ****/
function theme_get_archive_date() {
	if (is_day()) $this_archive = get_the_time('j F Y');
	elseif (is_month()) $this_archive = get_the_time('F Y');
	else $this_archive = get_the_time('Y');
	return $this_archive;
}

/**** Enable automatic feeds (new in 3.0+) ****/
if(function_exists('add_theme_support')) {
    add_theme_support('automatic-feed-links');
}

/**** Remove header stuff ****/
//remove_action( 'wp_head', 'feed_links_extra', 3 ); // Removes the links to the extra feeds such as category feeds
//remove_action( 'wp_head', 'feed_links', 2 ); // Removes links to the general feeds: Post and Comment Feed


remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');

function my_remove_recent_comments_style() {
	global $wp_widget_factory;
	remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
}
add_action('widgets_init', 'my_remove_recent_comments_style');


/**** Excerpt length ****/
function new_excerpt_length($length) {return 40;}
add_filter('excerpt_length', 'new_excerpt_length');


/**** Insert thumbnails in RSS ****/
function insertThumbnailRSS($content) {
   global $post;
   if(has_post_thumbnail( $post->ID)){
       $content = '<p>' . get_the_post_thumbnail( $post->ID, 'thumbnail' ) . '</p>' . $content;
   }
   return $content;
}
add_filter('the_excerpt_rss', 'insertThumbnailRSS');
add_filter('the_content_feed', 'insertThumbnailRSS');

// Don't add the wp-includes/js/comment-reply.js script to single post pages unless threaded comments are enabled
// adapted from http://bigredtin.com/behind-the-websites/including-wordpress-comment-reply-js/
function theme_queue_js(){
  if (!is_admin()){
    if ( is_singular() AND comments_open() AND (get_option('thread_comments') == 1))
      wp_enqueue_script( 'comment-reply' );
  }
}
add_action('get_header', 'theme_queue_js');


/**** Comments ****/
function custom_comments_callback($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
<div class="comment-wrap clearfix">

<div class="metaHolder clearfix">
<?php echo get_avatar(get_comment_author_email(), $size = '55'); ?>
<ul class="comment-meta">
<li class="comment-meta-author ss-user"><?php printf(__('%s'), get_comment_author_link()); ?></li>
<li class="comment-meta-date ss-clock"><a class="comment-permalink" href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php comment_date('j F Y'); ?> @ <?php comment_time('H.i'); ?></a> <?php edit_comment_link('Redigera &raquo;', '', ''); ?></li>
</ul>
<?php if ($comment->comment_approved == '0') : ?>
<p class="comment-moderation"><?php _e('Your comment is awaiting moderation.'); ?></p>
<?php endif; ?>
</div>

<div class="comment-text"><?php comment_text(); ?></div>
<p class="reply" id="comment-reply-<?php comment_ID(); ?>">
<?php comment_reply_link(array_merge($args, array('reply_text'=>'Svara', 'login_text'=>'Logga in för att svara', 'add_below'=>'comment-reply', 'depth'=>$depth, 'max_depth'=>$args['max_depth']))); ?>
</p>
</div>

<?php } // WP adds the closing </li>


/**** Pingbacks ****/
function custom_ping_callback($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
<div class="comment-wrap">

<h4><?php printf(__('%s'), get_comment_author_link()); ?></h4>
<p class="pingbackdate"><a href="http://en.support.wordpress.com/pingbacks/" title="Förklaring av pingback på engelska">Pingback</a> <span>den</span> <a class="comment-permalink" href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php comment_date('j F, Y'); ?> @ <?php comment_time('H.i'); ?></a></p>
<?php comment_text(); ?>
<div class="clear"></div>

</div>

<?php } // WP adds the closing </li>

/**** Trackbacks ****/
function custom_track_callback($comment, $args, $depth) {
$GLOBALS['comment'] = $comment; ?>

<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
<div class="comment-wrap">

<h4><?php printf(__('%s'), get_comment_author_link()); ?></h4>
<p class="pingbackdate"><a href="http://en.support.wordpress.com/trackbacks/" title="Förklaring av trackbacks på engelska">Trackback</a> <span>den</span> <a class="comment-permalink" href="<?php echo htmlspecialchars(get_comment_link($comment->comment_ID)); ?>"><?php comment_date('j F, Y'); ?> @ <?php comment_time('H.i'); ?></a></p>
<?php comment_text(); ?>
<div class="clear"></div>

</div>

<?php } // WP adds the closing </li>


/**** Enable widgets ****/
function widgets_init_pj() {
	register_sidebar(array(
	'id' => 'sidebar',
	'name' => 'Sidebar',
	'before_widget' => '<li id="%1$s" class="widget-container %2$s">',
	'after_widget' => '</li>',
	'description' => '',
	'before_title' => '<h3 class="widget-title">',
	'after_title' => '</h3>'));
}
add_action( 'widgets_init', 'widgets_init_pj' );


/**** Limit the archive widget to X months ****/
function my_limit_archives( $args ) {
    $args['limit'] = 10;
    return $args;
}
add_filter( 'widget_archives_args', 'my_limit_archives' );


/**** Remove widgets from wp-admin panel ****/
function remove_dashboard_widgets() {
	global $wp_meta_boxes;
/* 	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']); 
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
 	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']); */
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
/* 	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']); */
/* 	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']); */
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
}
/* if (!current_user_can('manage_options')) { */
/* add_action('wp_dashboard_setup', 'remove_dashboard_widgets' ); */


/**** Disable auto formatting in posts shortcode ****/
/**** Usage: [raw]Unformatted content[/raw] ****/
function my_formatter($content) {
	$new_content = '';
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
	foreach ($pieces as $piece) {
		if (preg_match($pattern_contents, $piece, $matches)) {
			$new_content .= $matches[1];
		} else {
			$new_content .= wptexturize(wpautop($piece));
		}
	}
	return $new_content;
}
remove_filter('the_content', 'wpautop');
remove_filter('the_content', 'wptexturize');
add_filter('the_content', 'my_formatter', 99);

/**** Enable widget shortcode ****/
add_filter('widget_text', 'do_shortcode');


?>