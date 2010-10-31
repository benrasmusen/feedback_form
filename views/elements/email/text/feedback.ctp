<?php __('Feedback:') ?>

<?php __('Email') ?>: <?php echo $feedback['Feedback']['email'] ?>

<?php __('Feedback') ?>: <?php echo $feedback['Feedback']['comments'] ?>

<?php if (!empty($feedback['Feedback']['extras'])): ?>
	
	<?php foreach ($feedback['Feedback']['extras'] as $name => $value): ?>
		<?php $name ?>: <?php echo $value ?>
		
	<?php endforeach ?>
	
<?php endif ?>
