<?php
/*
Plugin Name: smtpsetter
Plugin Script: smtpsetter.php
Plugin URI: http://.../smtpsetter (where should people go for this plugin?)
Description: (...)
Version: 0.1
Author: Your name
Author URI: http://... (your blog/site URL)

=== RELEASE NOTES ===
2014-07-01 - v1.0 -Initial version
*/

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