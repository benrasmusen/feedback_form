<?php
/**
 * FeedbacksController
 *
 * @package     plugins.feedback
 * @subpackage  app.plugins.feedback.controllers
 * @since		0.1
 * @author		Ben Rasmusen <benrasmusen@gmail.com>
 */
class FeedbacksController extends FeedbackAppController {
	
	/**
	 * Controller Name
	 *
	 * @var string
	 */
	public $name = 'Feedbacks';
	
	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Email');
	
	/**
	 * Paginate
	 *
	 * @var array
	 */
	public $paginate = array(
		'Feedback' => array(
			'limit' => 20
		)
	);
	
	
	/**
	 * Send (feedback)
	 *
	 * @since	0.1
	 * @author	Ben Rasmusen <benrasmusen@gmail.com>
	 * @return	void
	 */
	public function send() {
		
		// Reset variables
		$saved = $sent = false;
		
		// Set response array (used for JSON return)
		$response = array(
			'success' => false,
			'message' => __('There was an error submitting your feedback.', true),
			'data' => array()
		);
		
		if (!empty($this->data)) {
			
			if ($enabled = true) { // replace with Configure::read('Feedback.db.enabled')
				$saved = $this->Feedback->save($this->data);
			} else {
				$saved = true;
			}
			
			if ($saved) {
				$this->Email->reset();
				if (Configure::read('debug') > 0) {
					$this->Email->delivery = 'debug';
				}
				$this->Email->to = 'support@21times.org'; // replace with Configure::read('Feedback.to_email')
				$this->Email->from = $this->data['Feedback']['email'];
				$this->Email->replyTo = $this->data['Feedback']['email'];
				$this->Email->subject = 'New Feedback'; // replace with Configure::read('Feedback.subject')
				$this->Email->template = 'feedback';
				$this->Email->sendAs = 'text';
				$this->set('feedback', $this->data);

				$sent = $this->Email->send();
			}
			
			if ($sent && $saved) {
				$response = array(
					'success' => true,
					'message' => __('Your feedback was submitted successfully!', true)
				);
			} else {
				$response['data']['errors'] = array(
					'validation' => $this->Feedback->invalidFields(),
					'email' => $sent
				);
			}
			
			// Respond based on RequestHandler
			if ($this->RequestHandler->isAjax()) {
				
				die(json_encode($response));
				
			} else {
				
				if ($response['success']) {
					
					$this->Session->setFlash($response['message']);
					$this->redirect(array('action' => 'sent'));
					
				} else {
					
					$this->Session->setFlash($response['message']);
					
				}
				
			}
			
		}
		
	}
	
	/**
	 * Sent ('thanks')
	 *
	 * @since	0.1
	 * @author	Ben Rasmusen <ben@mightybrand.com>
	 * @return	void
	 */
	public function sent() {
		// Custom functionality here if desired
	}
	
	/**
	 * AdminIndex
	 *
	 * @since	0.1
	 * @author	Ben Rasmusen <benrasmusen@gmail.com>
	 * @return	void
	 */
	public function admin_index() {
		
		$this->Feedback->recursive = -1;
		$this->set('feedbacks', $this->paginate('Feedback'));
		
	}
	
	/**
	 * AdminView
	 *
	 * @since	0.1
	 * @author	Ben Rasmusen <benrasmusen@gmail.com>
	 * @param	string	$id
	 * @return	void
	 */
	public function admin_view($id=null) {
		
		$this->Feedback->recursive = -1;
		$feedback = $this->Feedback->read(null, $id);
		
		if (empty($feedback)) {
			$this->redirect(array('action' => 'index','admin' => true));
		}
		
		$this->set('feedback', $feedback);
		
	}
	
	/**
	 * AdminDelete
	 *
	 * @since	0.1
	 * @author	Ben Rasmusen <benrasmusen@gmail.com>
	 * @param	string	$id
	 * @return	void
	 */
	public function admin_delete($id=null) {
		
		if ($id) {
			
			if ($this->Feedback->delete($id)) {
				$this->Session->setFlash(__('Feedback deleted successfully.', true));
				$this->redirect(array('action' => 'index','admin' => true));
			} else {
				$this->Session->setFlash(__('There was an error deleting that feedback.', true));
				$this->redirect(array('action' => 'view', $id, 'admin' => true));
			}
			
		}
		
	}
	
}
?>