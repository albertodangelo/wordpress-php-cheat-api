<?php
/**
 * Register a new "Task Logger" role and grant capabilities for various roles.
 *
 * Called from taskbook.php.
 * 
 * @package  Taskbook
 * @link     https://developer.wordpress.org/plugins/users/roles-and-capabilities/
 */


/**
 * Taskbook User erhalten eigene "Rollen" damit ein Taskbook User nur 
 * seine eigenen tasks anschauen und editieren kann
 */
function activate_taskbook_user() {
    add_role( "taskbook_user", "Taskbook User" );
}
function deactivate_taskbook_user() {
    remove_role( "" );
}

/**
 * Dem Taskbook User werden die nöttaskbook_userigen Rechte zugewiesen
 */
function activate_taskbook_roles() {

    // taskbook user
    $roles = array("administrator", "taskbook_user");

    foreach($roles as $the_role) {
        $role = get_role( $the_role );
        $role->add_cap('read');
        $role->add_cap('edit_tasks');
        $role->add_cap('publish_tasks');
        $role->add_cap('edit_published_tasks');
    }

    $manager_roles = array('administrator');

    foreach($manager_roles as $the_role) {
        $role = get_role( $the_role );
        $role->add_cap('read_private_tasks');
        $role->add_cap('edit_others_tasks');
        $role->add_cap('edit_private_tasks');
        $role->add_cap('delete_tasks');
        $role->add_cap('delete_published_tasks');
        $role->add_cap('delete_private_tasks');
        $role->add_cap('delete_others_tasks');
    }

}
function deactivate_taskbook_roles() {

    $manager_roles = array('administrator');

    foreach($manager_roles as $the_role) {

        $role = get_role( $the_role );
        
        $role->remove_cap('read');
        $role->remove_cap('edit_tasks');
        $role->remove_cap('publish_tasks');
        $role->remove_cap('edit_published_tasks');
        $role->remove_cap('read_private_tasks');
        $role->remove_cap('edit_others_tasks');
        $role->remove_cap('edit_private_tasks');
        $role->remove_cap('delete_tasks');
        $role->remove_cap('delete_published_tasks');
        $role->remove_cap('delete_private_tasks');
        $role->remove_cap('delete_others_tasks');
    }
}
