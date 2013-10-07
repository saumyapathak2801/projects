<?php
/*
Plugin Name: Speakers
Description: Declares a plugin that will create a custom post type
Version: 1.0
Author: Saumya
*/
add_action('init','create_speaker');
function create_speaker(){
	$labels = array(
	'name' => 'Speakers',
	'singular_name' => 'Speaker',
	'add_new' => 'Add New',
	'add_new_item' => 'Add new speaker',
	'edit' => 'Edit',
	'edit_item' => 'Edit speaker information',
	'new_item' => 'New Speaker',
	'view' => 'View',
	'view_item' => 'View speaker details',
	'search_items' => 'Search speakers',
	'not_found' => 'No speakers found',
	'not_found_in_trash' => 'No speaker information found in Trash',
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
	register_post_type('speakers',$args);
}

add_action('admin_init','add_spk');
function add_spk(){
	add_meta_box('speaker_details',
	'Details about the speaker','display_speaker_details',
	'speakers','normal','high');
}

function display_speaker_details($spk){
	global $post;
	$custom=get_post_custom($post->ID);
//	if(!$custom){die();}
//echo $post->ID;
	$links=$custom['links'][0];
	$sessions=$custom['sessions'][0];
//	get_post_meta($spk->ID,'links','true');
	//get_post_meta($spk->ID,'sessions','true');
	?>
	<label><b>Links</b>(enter seperated with ';')</label></br>
	<textarea rows="2" cols="55" name="links"><?php echo $links; ?></textarea>
<!--	<input type="text" name="links" value="<?php echo $links; ?>"/><?php// echo $links?>--></br>
	<label><b>Sessions</b>(enter seperated with ';')</label></br>
	<textarea rows="2" cols="55" name="sessions"><?php echo $sessions; ?></textarea></br>
	<?php
	}
add_action('save_post','save_speaker_details',10,0);
function save_speaker_details(){
	global $post;
	update_post_meta($post->ID,"links",$_POST['links']);
	update_post_meta($post->ID,"sessions",$_POST['sessions']);
}
add_filter( 'template_include',
'template_function', 1 );


function template_function( $template_path ) {
if ( get_post_type() == 'speakers' ) {
if ( is_single() ) {
// checks if the file exists in the theme first,
// otherwise serve the file from the plugin
if ( $theme_file = locate_template( array
( 'single-speakers.php' ) ) ) {
$template_path = $theme_file;
} else {
$template_path = plugin_dir_path( __FILE__ ) .
'/single-speakers.php';
}
}
}
return $template_path;
}
?>
