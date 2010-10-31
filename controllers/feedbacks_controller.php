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
	
	public $name = 'Feedbacks';
	
	public $components = array('Email');
	
	public function send() {
		
		$saved = $sent = false;
		
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
	
	public function sent() {}
	
	public function admin_index() {
		
	}
	
	public function admin_view($id=null) {
		
	}
	
	public function admin_edit($id=null) {
		
	}
	
	public function admin_delete($id=null) {
		
	}
	
}
?>