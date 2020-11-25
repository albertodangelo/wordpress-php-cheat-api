<?php
/**
 * Alle Felder für unsere Beispiel Applikation "Taskbook"
 * 
 * @category Tasbook
 * @package  Demo_CMB2
 * @license  http://www.opensource.org/licenses/gpl-license.php GPL v2.0 (or later)
 * @link     https://github.com/CMB2/CMB2
 */

/**
 * Get the bootstrap! If using the plugin from wordpress.org, REMOVE THIS!
 */

if ( file_exists( dirname( __FILE__ ) . '/cmb2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/cmb2/init.php';
} elseif ( file_exists( dirname( __FILE__ ) . '/CMB2/init.php' ) ) {
	require_once dirname( __FILE__ ) . '/CMB2/init.php';
}

function taskbook_limit_rest_view_to_logged_users( $is_allowed, $cmb_controller) {
	if( !is_user_logged_in()) {
		$is_allowed = false;
	}

	return $is_allowed;
}

/**
 * MANUELLE ANZEIGE
 * Obwohl Taks status im Hintergrund automatisch aktualisiert werden 
 * (sihe status.php)
 * wird der aktuelle Status trotzdem angezeigt
 */
function taskbook_status_cb( $field_args, $field ) {
	$classes     = $field->row_classes();
	$label       = $field->args( 'name' );
    $status      = get_post_meta( get_the_ID(), 'task_status', true );
	?>
	<div class="cmb-row custom-field-row <?php echo esc_attr( $classes ); ?>">
		<div class="cmb-th">
            <label><?php echo esc_attr( $label ); ?></label>
        </div>
        <div class="cmb-td">
            <p><?php echo esc_attr( $status ); ?>
        </div>
	</div>
	<?php
}

add_action( 'cmb2_init', 'taskbook_register_rest_api_box' );

/**
 * Der Hook für die REST API kann nur mittles 'cmb2_init' erfolgen.
 * Mehr darüber: https://github.com/CMB2/CMB2/wiki/REST-API
 */
function taskbook_register_rest_api_box () {

	$cmb_rest = new_cmb2_box ( array(
		'id' 			=> 'taskbox_rest_metabox',
		'title'			=> esc_html__( 'Aufgabenbuch Daten', 'taskbook' ),
		'object_types'	=> array( 'task'), // Posttype
		'show_in_rest'	=> WP_REST_Server::ALLMETHODS, // https://github.com/CMB2/CMB2/wiki/REST-API#permissions
		'get_box_permissions_check_cb' => 'taskbook_limit_rest_view_to_logged_users' // CALLBACK => Nur eingeloggede User dürfen Zugriff auf diese Felder haben
	));

	$cmb_rest->add_field( array(
		'name'			=> esc_html__( 'Prognose', 'taskbook' ),
		'desc'			=> esc_html__( 'Was wird passieren', 'taskbook'),
		'id'			=> 'taskbook_prediction',
		'type'			=> 'wysiwyg',
		'options'		=> array(
			'textarea_rows'	=> 5,
		),
	));
	
	$cmb_rest->add_field( array(
		'name'             => esc_html__( 'Vorbereitende Tasks', 'taskbook' ),
		'desc'             => esc_html__( 'Was glaubst du wird passieren?', 'taskbook' ),
		'id'               => 'taskbook_pre_level',
		'type'             => 'radio',
		'options'          => array(
			'5' => esc_html__( 'Sehr entspannt', 'taskbook' ),
			'4' => esc_html__( 'Ziemlich entspannt', 'taskbook' ),
			'3' => esc_html__( 'Kein problem', 'taskbook' ),
			'2' => esc_html__( 'Ein wenig angespannt', 'taskbook' ),
			'1' => esc_html__( 'Total gestresst', 'taskbook' ),
		),
		'before'			=> '<p>'. esc_html__( 'Wie ist dein Stresslevel, wenn du an bevorstehende Aufgaben denkst?', 'taskbook' ),
	) );

	
	$cmb_rest->add_field( array(
		'name'			=> esc_html__( 'Resultat', 'taskbook' ),
		'desc'			=> esc_html__( 'Was ist tatsächlich passiert?', 'taskbook'),
		'id'			=> 'taskbook_outcome',
		'type'			=> 'wysiwyg',
		'options'		=> array(
			'textarea_rows'	=> 5,
		),
	));

	
	$cmb_rest->add_field( array(
		'name'             => esc_html__( 'Vorbereitende Tasks', 'taskbook' ),
		'desc'             => esc_html__( 'Was glaubst du wird passieren?', 'taskbook' ),
		'id'               => 'taskbook_post_level',
		'type'             => 'radio',
		'options'          => array(
			'5' => esc_html__( 'Sehr entspannt', 'taskbook' ),
			'4' => esc_html__( 'Ziemlich entspannt', 'taskbook' ),
			'3' => esc_html__( 'Kein problem', 'taskbook' ),
			'2' => esc_html__( 'Ein wenig angespannt', 'taskbook' ),
			'1' => esc_html__( 'Total gestresst', 'taskbook' ),
		),
		'before'			=> '<p>'. esc_html__( 'Wie war der tatsächliche Stresslevel bei dieser Aufgabe?', 'taskbook' ),
	) );

	$cmb_rest->add_field( array(
		'name' => esc_html__( 'Aufgaben Status', 'taskbook' ),
		'id'   => 'taskbook_task_status',
		'render_row_cb' => 'taskbook_status_cb',
	) );
}

