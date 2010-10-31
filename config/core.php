<?php
/**
 * Feedback plugin configuration
 *
 * @package     app
 * @subpackage  app.plugins.feedback.config
 * @since		0.1
 * @author		Ben Rasmusen <benrasmusen@gmail.com>
 */

$config = array(
	'to_email' 		=> 'feedback@example.com', 	// To: email address that feedback is sent to
	'subject' 		=> 'New feedback message', 	// Subject line of feedback email
	'db_enabled' 	=> true 					// Enable saving the feedback to the DB
);

Configure::write('Feedback', $config);

?>