<?php
/**
 * Feedback plugin configuration
 *
 * @package     app
 * @subpackage  app.plugins.feedback.config
 * @since		0.1
 * @author		Ben Rasmusen <benrasmusen@gmail.com>
 */

// To: email address that feedback is sent to
Configure::write('Feedback.to_email', 'feedback@example.com');

// Subject line of feedback email
Configure::write('Feedback.subject', 'New feedback message');

// Enable saving the feedback to the DB
Configure::write('Feedback.db_enabled', true);

?>