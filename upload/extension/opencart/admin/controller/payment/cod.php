<?php
namespace Opencart\Admin\Controller\Extension\Opencart\Payment;
class Cod extends \Opencart\System\Engine\Controller {
	public function index(): void {
		$this->load->language('extension/opencart/payment/cod');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['breadcrumbs'] = [];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'])
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment')
		];

		$data['breadcrumbs'][] = [
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/opencart/payment/cod', 'user_token=' . $this->session->data['user_token'])
		];

		$data['action'] = $this->url->link('extension/opencart/payment/cod', 'user_token=' . $this->session->data['user_token']);

		$data['back'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=payment');

		$data['payment_cod_total'] = $this->config->get('payment_cod_total');
		$data['payment_cod_order_status_id'] = $this->config->get('payment_cod_order_status_id');

		$this->load->model('localisation/order_status');

		$data['order_statuses'] = $this->model_localisation_order_status->getOrderStatuses();

		$data['payment_cod_geo_zone_id'] = $this->config->get('payment_cod_geo_zone_id');

		$this->load->model('localisation/geo_zone');

		$data['geo_zones'] = $this->model_localisation_geo_zone->getGeoZones();

		$data['payment_cod_status'] = $this->config->get('payment_cod_status');
		$data['payment_cod_sort_order'] = $this->config->get('payment_cod_sort_order');

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/opencart/payment/cod', $data));
	}

	public function save(): void {
		$this->load->language('extension/opencart/payment/cod');

		$json = [];

		if (!$this->user->hasPermission('modify', 'extension/opencart/payment/cod')) {
			$json['error'] = $this->language->get('error_permission');
		}

		if (!$json) {
			$this->load->model('setting/setting');

			$this->model_setting_setting->editSetting('payment_cod', $this->request->post);

			$json['success'] = $this->language->get('text_success');
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}