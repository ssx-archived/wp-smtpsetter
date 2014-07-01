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