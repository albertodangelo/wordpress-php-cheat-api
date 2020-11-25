<?php
/**
 * Register a new task_status field and set it automatically
 * based on the status of the taskbook_outcome field.
 *
 * Called from taskbook.php.
 * 
 * @package  Taskbook
 * @link     https://developer.wordpress.org/reference/functions/register_rest_field/
 */

/**
 * Es wird nach dem Update des Taskfields der Hook "rest_after_insert_task"
 * ausgeführt und geprüft, ob es einen Taks gibt. Je nachdem wird "in progress" oder "Completed"
 * in das Feld gesetzt 
 */

add_action( 'rest_after_insert_task', 'taskbook_change_status', 10, 2 );
function taskbook_change_status( $post, $request ) {

	// Get the contents of the taskbook_outcome field.
	$outcome = get_post_meta( $post->ID, 'taskbook_outcome', true );

	// Update task_status based on whether $outcome has content:
	if ( 0 === strlen($outcome) ) {
		update_post_meta( $post->ID, 'task_status', 'In progress' );
	} else {
		update_post_meta( $post->ID, 'task_status', 'Completed' );
	}

}



/**
 * Hier kommt ein neues Textfeld für das Field "task_status"
 */

add_action( 'rest_api_init', 'taskbook_register_task_status' );
 
function taskbook_register_task_status() {
 
    register_rest_field( 
        'task', 
        'task_status', 
        array(
           'get_callback'    => 'taskbook_get_task_status',
           'schema'          => null,
        )
    );
}
 
function taskbook_get_task_status( $object, $field_name, $request ) {
    return get_post_meta( $object['id'], $field_name, true );
}
