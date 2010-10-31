<?php
/**
 * File Description
 *
 * @package     plugins.feedback
 * @subpackage  app.plugins.feedback.models
 * @since		0.1
 * @author		Ben Rasmusen <benasmusen@gmail.com>
 */
class Feedback extends FeedbackAppModel {
	
    public $validate = array(
        'comments' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Comments cannot be empty.'
		)
	);
	
	public function beforeSave(&$Model, $options=array()) {
		
		// Serialize extras to be stored in the DB.
		if (isset($this->data['Feedback']['extras'])) {
			
			$this->data['Feedback']['extras'] = serialize($this->data['Feedback']['extras']);
			
		}
		
		return parent::beforeSave($options);
		
	}
	
	public function afterFind(&$Model, $results) {
		
		// UnSerialize extras to be displayed.
		if (!empty($results['Feedback']['extras'])) {
			
			$results['Feedback']['extras'] = unserialize($results['Feedback']['extras']);
			
		}
		
		return $results;
		
	}

}
?>