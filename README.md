CakePHP Feedback Form Plugin
============================

Author: [Ben Rasmusen](http://benrasmusen.com/) <[benrasmusen@gmail.com](mailto:benrasmusen@gmail.com)>

Summary
-------

This plugin provides a simple, straight forward feedback form. Optionally embed the element anywhere in a view and submit via AJAX, as well as save the feedback to the database. **This plugin is a work in progress, suggestions are always appreciated, and bugs are to be expected.**

Notes
-----

* This plugin requires jQuery (tested with jQuery 1.4.2) for AJAX submission.
* This plugin has been tested with CakePHP 1.3.5.
* You must enable admin routes for admin functionality.
* Saving feedback to the database is optional (see config setting in config/core.php).

Installation
------------

1. Download the plugin and place it in /app/plugins/feedback.
2. For AJAX submission make sure you've included [jQuery](http://docs.jquery.com/Downloading\_jQuery#Download\_jQuery) in the layout.
3. Adjust the settings in config/core.php to your preferences.
4. Add the following to the bottom of your /app/config/core.php file to include the feedback configs:
	* `require_once APP . 'plugins' . DS . 'feedback' . DS . 'config' . DS . 'core.php';`
5. Run the SQL in config/schema/feedback.sql if you want to save the feedback to the db.
6. Enable admin routing if you want to view the feedback via admin.
7. Standalone feedback page available in views/feedbacks/send.ctp.
8. Embedable element in views/elements/form.ctp.
	* NOTE: see element header for notes on adding additional fields