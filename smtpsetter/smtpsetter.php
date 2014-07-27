<?php
/*
Plugin Name: smtpsetter
Plugin Script: smtpsetter.php
Plugin URI: https://github.com/ssx/wp-smtpsetter/
Description: A Wordpress plugin that will you to set the SMTP server used throughout Wordpress
Version: 0.1
Author: Scott Wilcox
Author URI: http://dor.ky

=== RELEASE NOTES ===
2014-07-01 - v1.0 -Initial version
*/

class MySettingsPage
{
    /**
     * Holds the values to be used in the fields callbacks
     */
    private $options;

    /**
     * Start up
     */
    public function __construct()
    {
        add_action( 'admin_menu', array( $this, 'add_plugin_page' ) );
        add_action( 'admin_init', array( $this, 'page_init' ) );
    }

    /**
     * Add options page
     */
    public function add_plugin_page()
    {
        // This page will be under "Settings"
        add_options_page(
            'Settings Admin',
            'SMTP Settings',
            'manage_options',
            'smtp-setter-admin',
            array( $this, 'create_admin_page' )
        );
    }

    /**
     * Options page callback
     */
    public function create_admin_page()
    {
        // Set class property
        $this->options = get_option( 'my_option_name' );
        ?>
        <div class="wrap">
            <?php screen_icon(); ?>
            <h2>SMTP Settings</h2>
            <form method="post" action="options.php">
            <?php
                // This prints out all hidden setting fields
                settings_fields( 'my_option_group' );
                do_settings_sections( 'smtp-setter-admin' );
                submit_button();
            ?>
            </form>
        </div>
        <?php
    }

    /**
     * Register and add settings
     */
    public function page_init()
    {
        register_setting(
            'my_option_group', // Option group
            'my_option_name', // Option name
            array( $this, 'sanitize' ) // Sanitize
        );

        add_settings_section(
            'setting_section_id', // ID
            'My Custom Settings', // Title
            array( $this, 'print_section_info' ), // Callback
            'smtp-setter-admin' // Page
        );

        add_settings_field(
            'id_number', // ID
            'ID Number', // Title
            array( $this, 'id_number_callback' ), // Callback
            'smtp-setter-admin', // Page
            'setting_section_id' // Section
        );

        add_settings_field(
            'title',
            'Title',
            array( $this, 'title_callback' ),
            'smtp-setter-admin',
            'setting_section_id'
        );
    }

    /**
     * Sanitize each setting field as needed
     *
     * @param array $input Contains all settings fields as array keys
     */
    public function sanitize( $input )
    {
        $new_input = array();
        if( isset( $input['id_number'] ) )
            $new_input['id_number'] = absint( $input['id_number'] );

        if( isset( $input['title'] ) )
            $new_input['title'] = sanitize_text_field( $input['title'] );

        return $new_input;
    }

    /**
     * Print the Section text
     */
    public function print_section_info()
    {
        print 'Enter your settings below:';
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function id_number_callback()
    {
        printf(
            '<input type="text" id="id_number" name="my_option_name[id_number]" value="%s" />',
            isset( $this->options['id_number'] ) ? esc_attr( $this->options['id_number']) : ''
        );
    }

    /**
     * Get the settings option array and print one of its values
     */
    public function title_callback()
    {
        printf(
            '<input type="text" id="title" name="my_option_name[title]" value="%s" />',
            isset( $this->options['title'] ) ? esc_attr( $this->options['title']) : ''
        );
    }
}

if( is_admin() )
    $my_settings_page = new MySettingsPage();

// smtpsetter parameters will be saved in the database
function smtpsetter_add_options() {
	// smtpsetter_add_options: add options to DB for this plugin

	add_option('smtpsetter_server', 'smtp.example.org');
}
smtpsetter_add_options();

// smtpsetter_showhtml will generate the (HTML) output
function smtpsetter_showhtml($param1 = 0, $param2 = "test") {
	global $wpdb;

	// get your parameter values from the database
	$smtpsetter_nb_widgets = get_option('smtpsetter_nb_widgets');

	// content will be added when function 'smtpsetter_showhtml()' is called
	return $smtpsetter_html;
}

add_action('phpmailer_init','send_smtp_email');
function send_smtp_email( $phpmailer )
{
    // Define that we are sending with SMTP
    $phpmailer->isSMTP();

    // The hostname of the mail server
    $phpmailer->Host = "smtp.example.org";

    // Use SMTP authentication (true|false)
    $phpmailer->SMTPAuth = true;

    // SMTP port number - likely to be 25, 465 or 587
    $phpmailer->Port = "587";

    // Username to use for SMTP authentication
    $phpmailer->Username = "yourusername";

    // Password to use for SMTP authentication
    $phpmailer->Password = "yourpassword";

    // The encryption system to use - ssl (deprecated) or tls
    $phpmailer->SMTPSecure = "tls";

	// If you want to set the from email/name then do so here
    $phpmailer->From = "your-email-address";
    $phpmailer->FromName = "Your Name";
}
