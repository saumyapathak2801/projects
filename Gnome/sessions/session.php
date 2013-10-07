<?php
/*
Plugin Name: Sessions
Description: Declares a plugin that will create a custom post type
Version: 1.0
Author: Saumya
 */
add_action('init','create_session');
function create_session(){
	$labels = array(
		'name' => 'Session',
		'singular_name' => 'Session',
		'add_new' => 'Add New',
		'add_new_item' => 'Add new session',
		'edit' => 'Edit',
		'edit_item' => 'Edit session information',
		'new_item' => 'New Session',
		'view' => 'View',
		'view_item' => 'View session details',
		'search_items' => 'Search sessions',
		'not_found' => 'No sessions found',
		'not_found_in_trash' => 'No session information found in Trash',
		'parent' => 'Parent'
	);
	$args = array(
		'labels' => $labels,
		'public' => true,
		'menu_position' => 15,
		'supports' => array(
			'title','editor','thumbnail',
		),
		'taxonomy' => array(''),
		'menu_icon' =>plugins_url( 'image.png', __FILE__ ),
		'has_archive' => true
	);
	register_post_type('session',$args);
}

add_action('admin_init','add_session');
function add_session(){
	add_meta_box('session_details',
		'Speaker of the session','display_speaker',
		'session','normal','high');
}

function display_speaker($spk){
	global $post;
	$mypost = array('post_type'=>'speakers');
	$loop= new WP_Query($mypost);
	$custom=get_post_custom($post->ID);
	$speaker=$custom['spk'][0];
?>
<label><b>Speaker</b></br>
<select name="spk" >
<?php while($loop->have_posts()) : $loop->the_post();?>
<option value="<?php the_title(); ?>"><?php echo the_title();?></option>
<?php endwhile; ?>
</select>
<?php
}
add_action('save_post','save_session_details',10,0);
function save_session_details(){
	global $post;
	update_post_meta($post->ID,"spk",$_POST['spk']);
}
add_filter( 'template_include',
	'template_func', 1 );


function template_func( $template_path ) {
	if ( get_post_type() == 'session' ) {
		if ( is_single() ) {
			// checks if the file exists in the theme first,
			// otherwise serve the file from the plugin
			if ( $theme_file = locate_template( array
				( 'single-session.php' ) ) ) {
					$template_path = $theme_file;
				} else {
					$template_path = plugin_dir_path( __FILE__ ) .
						'/single-session.php';
				}
		}
	}
	return $template_path;
}
?>
