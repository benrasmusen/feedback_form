<?php
/**
 * Feedback Form
 *
 * @package     plugins.feedback
 * @subpackage  app.plugins.feedback.views.elements
 * @since		0.1
 * @author		Ben Rasmusen <benrasmusen@gmail.com>
 * @param	array 	$options
 *
 * Accepts (all optional):
 * 	$options = array(
 *  	'ajax' => true,
 *  	'email' => false,
 *  	'extras' => array(
 *  		// Any extra fields. 
 *  		// Key = name of input, Value (array) = form input options array
 *  		'name' => array(
 *  			'type' => 'textarea',
 *  			'label' => 'Full Name'
 *  		),
 *  	),
 *  )
 *
 */

$default_options = array(
	'ajax' => false,
	'email' => true,
	'extras' => array()
);

if (isset($options)) {
	$options = Set::merge($default_options, $options);
} else {
	$options = $default_options;
}

?>
<div id="feedback-form-wrapper">
	
	<?php echo $this->Form->create(
		'Feedback', 
		array(
			'url' => array(
				'controller' => 'feedbacks',
				'action' => 'send',
				'plugin' => 'feedback'
			),
			'id' => 'FeedbackSendForm'
		)
	); ?>
	
	<?php 
	if ($options['email']) {
		echo $this->Form->input(
			'email',
			array(
				'type' => 'text',
				'label' => __('Email (optional)', true),
				'title' => __('Email (optional)', true)
			)
		);
	}
	?>
	
	<?php
	// Output extras
	if (!empty($options['extras'])) {
		foreach ($options['extras'] as $name => $input_options) {
			echo $this->Form->input('extras.' . $name, $input_options);
		}
	}
	?>
	
	<?php echo $this->Form->input(
		'comments',
		array(
			'type' => 'textarea',
			'label' => __('Comments', true),
			'title' => __('Comments', true)
		)
	); ?>
	
	<?php echo $this->Form->submit(__('Send', true)); ?>
	
	<?php echo $this->Form->end(); ?>
	
	<?php if ($options['ajax']): ?>
		<div id="ajax-loading" style="display:none">
			<?php echo $this->Html->image('loading.gif') ?>
		</div>
	<?php endif ?>
	
</div>
<?php if ($options['ajax']): ?>
	
	<?php $this->Html->scriptStart(array('inline' => false)) ?>
	
	$(document).ready(function(){
		
		$('#FeedbackSendForm').submit(function(){
			
			$('#FeedbackSendForm #ajax-loading').show();
			$('#FeedbackSendForm .error-message, #FeedbackSendForm .success-message').remove();
			$('#FeedbackSendForm .form-error').removeClass('form-error');
			
			$.ajax({
				type: $(this).attr('method'),
				data: $(this).serialize(),
				url: $(this).attr('action'),
				dataType: "json",
				success: function(response) {
					if (response.success) {
						$('<div class="success-message">' + response.message + '</div>').prependTo('#FeedbackSendForm');
						$(':input','#FeedbackSendForm')
						 .not(':button, :submit, :reset, :hidden')
						 .val('')
						 .removeAttr('checked')
						 .removeAttr('selected');
						$('#FeedbackSendForm #ajax-loading').hide();
					} else {
						for (var field in response.data.errors.validation) {
							$('#Feedback' + field.charAt(0).toUpperCase() + field.slice(1)).addClass('form-error');
							$('<div class="error-message">' + response.data.errors.validation[field] + '</div>').insertAfter('#Feedback' + field.charAt(0).toUpperCase() + field.slice(1));
						}
						$('#FeedbackSendForm #ajax-loading').hide();
					}
				}
			});
			
			return false;
			
		});
		
	});
	
	<?php $this->Html->scriptEnd() ?>
	
<?php endif ?>