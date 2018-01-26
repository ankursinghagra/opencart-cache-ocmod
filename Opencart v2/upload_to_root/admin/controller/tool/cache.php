<?php 
class ControllerToolCache extends Controller {

	public function index() {
		$this->load->language('tool/cache');

		$this->document->setTitle($this->language->get('heading_title'));

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
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('tool/cache', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['user_token'] = $this->session->data['user_token'];

		//$data['export'] = $this->url->link('tool/backup/export', 'user_token=' . $this->session->data['user_token'], true);
		
		//$this->load->model('tool/backup');

		//$data['tables'] = $this->model_tool_backup->getTables();

		$data['clear'] = $this->url->link('tool/cache/clear', 'user_token=' . $this->session->data['user_token'], true);

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('tool/cache', $data));
	}

	public function clear(){

		$this->load->language('tool/cache');

		if (!$this->user->hasPermission('modify', 'tool/cache')) {
			$this->session->data['error'] = $this->language->get('text_error');
		} else {
			/*yourcode here*/

			$this->load->model('tool/cache');
			//The name of the folder.
			$folder = DIR_CACHE;
			 
			//Get a list of all of the file names in the folder.
			$files = glob($folder . '/*');
			 
			foreach ($files as $file) {
				$this->model_tool_cache->deleteAll($file);
			}
			

			/*yourcode here*/
			$this->session->data['success'] = $this->language->get('text_success');
		}
		$this->response->redirect($this->url->link('tool/cache', 'user_token=' . $this->session->data['user_token'], true));
	}
}
?>