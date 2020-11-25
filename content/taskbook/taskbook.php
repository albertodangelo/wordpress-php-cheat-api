<?php
/*
Plugin Name: Task Book
Plugin URI:  https://dangelodesign.ch
Description: Plugin gehört zum Kurs WP Building a Headless App with REST API.
Version:     1.0.0
Author:      Alberto D'Angelo
Author URI:  https://dangelodesign.ch
Text Domain: taskbook
Domain Path: /languages
License:     GPL3

Task Book is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Task Book is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Task Book. If not, see https://www.gnu.org/licenses/gpl.html.
*/

/**
 * Register Task post type.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/posttypes.php';
register_activation_hook( __FILE__, 'taskbook_rewrite_flush' );


/**
 * Register Task Logger role.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/roles.php';
register_activation_hook( __FILE__, 'activate_taskbook_user' );
register_deactivation_hook( __FILE__, 'deactivate_taskbook_user');

/**
 * Add Capabilities to task users
 */
register_activation_hook( __FILE__, 'activate_taskbook_roles' );
register_deactivation_hook( __FILE__, 'deactivate_taskbook_roles');


/**
 * Register task_status field.
 */
require_once plugin_dir_path( __FILE__ ) . 'includes/status.php';

/**
 * Alle Custom Felder für die Eingaben
 * Prediction, Pre-task stress level, Outcome, Post-taks stress level
 */
 require_once plugin_dir_path( __FILE__ ) . 'includes/cmb2-functions.php';