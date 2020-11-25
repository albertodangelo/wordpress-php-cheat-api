<?php
/**
 * Plugin Name:       REST API Demo Plugin
 * Plugin URI:        https://linkedin.com/learning
 * Description:       Plugin to add fields to the REST API
 * Version:           1.0.0
 * Requires at least: 4.7
 * Author:            Morten Rand-Hendriksen
 * Author URI:        https://lnkd.in/mor10
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       rest-demo-plugin
 */

/**
 * Add new fields to the REST API response.
 * @link https://developer.wordpress.org/reference/functions/register_rest_field/
 */
add_action( 'rest_api_init', 'RDP_add_new_fields' );

function RDP_add_new_fields() {
    register_rest_field( 
        'post',     // Object(s) the filed is being registered to
        'catlinks', // Attribute (field) name
         array(     // Array of arguments
            'get_callback'    => 'RDP_get_category_links', // Retrieves the field value.
            'update_callback' => null,                 // Updates the field value.
            'schema'          => null,                 // Creates schema for the field.
        ) 
    );
    register_rest_field( 
        'post',     // Object(s) the filed is being registered to
        'previous_post_ID', // Attribute (field) name
         array(     // Array of arguments
            'get_callback'    => 'RDP_get_previous_post_ID', // Retrieves the field value.
            'update_callback' => null,                 // Updates the field value.
            'schema'          => null,                 // Creates schema for the field.
        ) 
    );
    register_rest_field( 
        'post',     // Object(s) the filed is being registered to
        'previous_post_title', // Attribute (field) name
         array(     // Array of arguments
            'get_callback'    => 'RDP_get_previous_post_title', // Retrieves the field value.
            'update_callback' => null,                 // Updates the field value.
            'schema'          => null,                 // Creates schema for the field.
        ) 
    );
    register_rest_field( 
        'post',     // Object(s) the filed is being registered to
        'previous_post_permalink', // Attribute (field) name
         array(     // Array of arguments
            'get_callback'    => 'RDP_get_previous_post_permalink', // Retrieves the field value.
            'update_callback' => null,                 // Updates the field value.
            'schema'          => null,                 // Creates schema for the field.
        ) 
    );
}

function RDP_get_previous_post_ID() {
	
   return get_previous_post()->ID;
}
function RDP_get_previous_post_title() {
   return get_the_title( get_previous_post() );
}
function RDP_get_previous_post_permalink() {
    return get_the_permalink( get_previous_post( ));
}

/**
 * Get all the categories for the current post.
 * Make links for each category and string them together.
 * Return string of category links.
 */
function RDP_get_category_links() {
    $categories = get_the_category();
    $separator = ', ';
    $output = '';
    if ( ! empty( $categories ) ) {
        foreach( $categories as $category ) {
            $output .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '">' . esc_html( $category->name ) . '</a>' . $separator;
        }
        $output = trim( $output, $separator );
    }
    return $output;
}