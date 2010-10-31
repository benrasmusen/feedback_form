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
	
	/**
	 * Validation
	 *
	 * @var array
	 */
    public $validate = array(
        'comments' => array(
            'rule' => 'notEmpty',
            'required' => true,
            'allowEmpty' => false,
            'message' => 'Comments cannot be empty.'
		)
	);
	
	/**
	 * beforeSave Callback
	 *
	 * @since	0.1
	 * @author	Ben Rasmusen <benrasmusen@gmail.com>
	 * @param	object	$Model
	 * @param	array	$options
	 * @return	boolean
	 */
	public function beforeSave(&$Model, $options=array()) {
		
		// Serialize extras to be stored in the DB.
		if (!empty($this->data['Feedback']['extras'])) {
			
			$this->data['Feedback']['extras'] = serialize($this->data['Feedback']['extras']);
			
		}
		
		return parent::beforeSave($options);
		
	}
	
	/**
	 * afterFind Callback
	 *
	 * @since	0.1
	 * @author	Ben Rasmusen <ben@mightybrand.com>
	 * @param	array	$results
	 * @return	array
	 */
	public function afterFind($results, $primary) {
		
		if (!empty($results)) {

			if (Set::numeric(array_keys($results))) {

				foreach ($results as $i => $result) {
					
					// UnSerialize extras to be displayed.
					if (!empty($result['Feedback']['extras'])) {

						$results[$i]['Feedback']['extras'] = unserialize($result['Feedback']['extras']);

					}

				}

			} elseif (!empty($results[$Model->alias]['id'])) {

				// UnSerialize extras to be displayed.
				if (!empty($results['Feedback']['extras'])) {

					$results['Feedback']['extras'] = unserialize($results['Feedback']['extras']);

				}

			} elseif (!empty($results['id'])) {

				// UnSerialize extras to be displayed.
				if (!empty($results['extras'])) {

					$results['extras'] = unserialize($results['Feedback']['extras']);

				}

			}

		}
		
		return $results;
		
	}

}
?>