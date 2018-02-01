<?php
class ControllerExtensionModuleCache extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('extension/module/cache');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('setting/module');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_cache', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		}else if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];

			unset($this->session->data['error']);
		}  else {
			$data['error_warning'] = '';
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/cache', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['user_token'] = $this->session->data['user_token'];

		$data['clear'] = $this->url->link('extension/module/cache/clear', 'user_token=' . $this->session->data['user_token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/cache', $data));
	}
	public function clear(){

		$this->load->language('extension/module/cache');

		/*yourcode here*/

		$this->load->model('extension/module/cache');
		//The name of the folder.
		$folder = DIR_CACHE;
		 
		//Get a list of all of the file names in the folder.
		$files = glob($folder . '/*');
		 
		foreach ($files as $file) {
			$this->model_extension_module_cache->deleteAll($file);
		}
		

		/*yourcode here*/
		$this->session->data['success'] = $this->language->get('text_success');

		$this->response->redirect($this->url->link('extension/module/cache', 'user_token=' . $this->session->data['user_token'], true));
	}

	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/cache')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
}