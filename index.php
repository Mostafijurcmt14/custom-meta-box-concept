<?php
function custom_meta_box() {
    add_meta_box(
        'custom_meta_box_id',       // Unique ID for the metabox
        'Custom Meta Box',          // Title of the metabox
        'custom_meta_box_callback', // Callback function that displays the metabox content
        'post',                     // Post type where the metabox will appear
        'normal',                   // Context where the metabox should be displayed (normal, side, etc.)
        'high'                      // Priority of the metabox (high, core, default, low)
    );
}
add_action('add_meta_boxes', 'custom_meta_box');



function custom_meta_box_callback($post){
	wp_nonce_field('custom_meta_box_nonce_action', 'custom_metabox_value_nonce');
	$value = get_post_meta($post->ID, '_custom_meta_key', true);
	
	echo '<label for="custom_meta_field">Add custom text</label>';
	echo '<input type="text" id="custom_meta_field" name="custom_meta_field" value="'. esc_attr($value). '">';
}


function custom_meta_field_save($post_id){
	if (!isset($_POST['custom_metabox_value_nonce'])) {
        return $post_id;
    }
	 // Sanitize the user input
    $new_value = sanitize_text_field($_POST['custom_meta_field']);

    // Update the meta field in the database
    update_post_meta($post_id, '_custom_meta_key', $new_value);
}
add_action('save_post','custom_meta_field_save');
