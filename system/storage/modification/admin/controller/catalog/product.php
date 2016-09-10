<?php
class ControllerCatalogProduct extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->addProduct($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_product->editProduct($this->request->get['product_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->deleteProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function copy() {
		$this->load->language('catalog/product');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/product');

		if (isset($this->request->post['selected']) && $this->validateCopy()) {
			foreach ($this->request->post['selected'] as $product_id) {
				$this->model_catalog_product->copyProduct($product_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['filter_name'])) {
				$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_model'])) {
				$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
			}

			if (isset($this->request->get['filter_price'])) {
				$url .= '&filter_price=' . $this->request->get['filter_price'];
			}

			if (isset($this->request->get['filter_quantity'])) {
				$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
			}

			if (isset($this->request->get['filter_status'])) {
				$url .= '&filter_status=' . $this->request->get['filter_status'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}

		if (isset($this->request->get['filter_image'])) {
			$filter_image = $this->request->get['filter_image'];
		} else {
			$filter_image = null;
		}

		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'pd.name';
		}

		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true)
		);

		$data['add'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['copy'] = $this->url->link('catalog/product/copy', 'token=' . $this->session->data['token'] . $url, true);
$data['button_import'] = $this->language->get('button_import');
        $data['import'] = $this->url->link('catalog/product/import', 'token=' . $this->session->data['token'] . $url, 'SSL');
$data['button_export'] = $this->language->get('button_export');
        $data['export'] = $this->url->link('catalog/product/products_export', 'token=' . $this->session->data['token']. $url, 'SSL');

		$data['delete'] = $this->url->link('catalog/product/delete', 'token=' . $this->session->data['token'] . $url, true);

		$data['products'] = array();

		$filter_data = array(
			'filter_name'	  => $filter_name,
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status,
			'filter_image'    => $filter_image,
			'sort'            => $sort,
			'order'           => $order,
			'start'           => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit'           => $this->config->get('config_limit_admin')
		);

		$this->load->model('tool/image');

		$product_total = $this->model_catalog_product->getTotalProducts($filter_data);

		$results = $this->model_catalog_product->getProducts($filter_data);

		foreach ($results as $result) {
			if (is_file(DIR_IMAGE . $result['image'])) {
				$image = $this->model_tool_image->resize($result['image'], 40, 40);
			} else {
				$image = $this->model_tool_image->resize('no_image.png', 40, 40);
			}

			$special = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']);

			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || strtotime($product_special['date_start']) < time()) && ($product_special['date_end'] == '0000-00-00' || strtotime($product_special['date_end']) > time())) {
					$special = $product_special['price'];

					break;
				}
			}

			$data['products'][] = array(
				'product_id' => $result['product_id'],
				'image'      => $image,
				'name'       => $result['name'],
				'model'      => $result['model'],
				'price'      => $result['price'],
				'special'    => $special,
				'quantity'   => $result['quantity'],
				'status'     => $result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'),
				'edit'       => $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $result['product_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_image'] = $this->language->get('column_image');
		$data['column_name'] = $this->language->get('column_name');
		$data['column_model'] = $this->language->get('column_model');
		$data['column_price'] = $this->language->get('column_price');
		$data['column_quantity'] = $this->language->get('column_quantity');
		$data['column_status'] = $this->language->get('column_status');
		$data['column_action'] = $this->language->get('column_action');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_image'] = $this->language->get('entry_image');

		$data['button_copy'] = $this->language->get('button_copy');
		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_filter'] = $this->language->get('button_filter');

		$data['token'] = $this->session->data['token'];

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];

			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=pd.name' . $url, true);
		$data['sort_model'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.model' . $url, true);
		$data['sort_price'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.price' . $url, true);
		$data['sort_quantity'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.quantity' . $url, true);
		$data['sort_status'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.status' . $url, true);
		$data['sort_order'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . '&sort=p.sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['filter_image'])) {
			$url .= '&filter_image=' . $this->request->get['filter_image'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $product_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($product_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($product_total - $this->config->get('config_limit_admin'))) ? $product_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $product_total, ceil($product_total / $this->config->get('config_limit_admin')));

		$data['filter_name'] = $filter_name;
		$data['filter_model'] = $filter_model;
		$data['filter_price'] = $filter_price;
		$data['filter_quantity'] = $filter_quantity;
		$data['filter_status'] = $filter_status;
		$data['filter_image'] = $filter_image;

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/product_list', $data));
	}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['product_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_yes'] = $this->language->get('text_yes');
		$data['text_no'] = $this->language->get('text_no');
		$data['text_plus'] = $this->language->get('text_plus');
		$data['text_minus'] = $this->language->get('text_minus');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_option'] = $this->language->get('text_option');
		$data['text_option_value'] = $this->language->get('text_option_value');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_percent'] = $this->language->get('text_percent');
		$data['text_amount'] = $this->language->get('text_amount');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_model'] = $this->language->get('entry_model');
		$data['entry_sku'] = $this->language->get('entry_sku');
		$data['entry_upc'] = $this->language->get('entry_upc');
		$data['entry_ean'] = $this->language->get('entry_ean');
		$data['entry_jan'] = $this->language->get('entry_jan');
		$data['entry_isbn'] = $this->language->get('entry_isbn');
		$data['entry_mpn'] = $this->language->get('entry_mpn');
		$data['entry_location'] = $this->language->get('entry_location');
		$data['entry_minimum'] = $this->language->get('entry_minimum');
		$data['entry_shipping'] = $this->language->get('entry_shipping');
		$data['entry_date_available'] = $this->language->get('entry_date_available');
		$data['entry_quantity'] = $this->language->get('entry_quantity');
		$data['entry_stock_status'] = $this->language->get('entry_stock_status');
		$data['entry_price'] = $this->language->get('entry_price');
		$data['entry_tax_class'] = $this->language->get('entry_tax_class');
		$data['entry_points'] = $this->language->get('entry_points');
		$data['entry_option_points'] = $this->language->get('entry_option_points');
		$data['entry_subtract'] = $this->language->get('entry_subtract');
		$data['entry_weight_class'] = $this->language->get('entry_weight_class');
		$data['entry_weight'] = $this->language->get('entry_weight');
		$data['entry_dimension'] = $this->language->get('entry_dimension');
		$data['entry_length_class'] = $this->language->get('entry_length_class');
		$data['entry_length'] = $this->language->get('entry_length');
		$data['entry_width'] = $this->language->get('entry_width');
		$data['entry_height'] = $this->language->get('entry_height');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_additional_image'] = $this->language->get('entry_additional_image');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_manufacturer'] = $this->language->get('entry_manufacturer');
		$data['entry_download'] = $this->language->get('entry_download');
		$data['entry_category'] = $this->language->get('entry_category');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_related'] = $this->language->get('entry_related');
		$data['entry_attribute'] = $this->language->get('entry_attribute');
		$data['entry_text'] = $this->language->get('entry_text');
		$data['entry_option'] = $this->language->get('entry_option');
		$data['entry_option_value'] = $this->language->get('entry_option_value');
		$data['entry_required'] = $this->language->get('entry_required');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_date_start'] = $this->language->get('entry_date_start');
		$data['entry_date_end'] = $this->language->get('entry_date_end');
		$data['entry_priority'] = $this->language->get('entry_priority');
		$data['entry_tag'] = $this->language->get('entry_tag');
		$data['entry_customer_group'] = $this->language->get('entry_customer_group');
		$data['entry_reward'] = $this->language->get('entry_reward');
		$data['entry_layout'] = $this->language->get('entry_layout');
		$data['entry_recurring'] = $this->language->get('entry_recurring');

		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_sku'] = $this->language->get('help_sku');
		$data['help_upc'] = $this->language->get('help_upc');
		$data['help_ean'] = $this->language->get('help_ean');
		$data['help_jan'] = $this->language->get('help_jan');
		$data['help_isbn'] = $this->language->get('help_isbn');
		$data['help_mpn'] = $this->language->get('help_mpn');
		$data['help_minimum'] = $this->language->get('help_minimum');
		$data['help_manufacturer'] = $this->language->get('help_manufacturer');
		$data['help_stock_status'] = $this->language->get('help_stock_status');
		$data['help_points'] = $this->language->get('help_points');
		$data['help_category'] = $this->language->get('help_category');
		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_download'] = $this->language->get('help_download');
		$data['help_related'] = $this->language->get('help_related');
		$data['help_tag'] = $this->language->get('help_tag');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');
		$data['button_attribute_add'] = $this->language->get('button_attribute_add');
		$data['button_option_add'] = $this->language->get('button_option_add');
		$data['button_option_value_add'] = $this->language->get('button_option_value_add');
		$data['button_discount_add'] = $this->language->get('button_discount_add');
		$data['button_special_add'] = $this->language->get('button_special_add');
		$data['button_image_add'] = $this->language->get('button_image_add');
		$data['button_remove'] = $this->language->get('button_remove');
		$data['button_recurring_add'] = $this->language->get('button_recurring_add');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_attribute'] = $this->language->get('tab_attribute');
		$data['tab_option'] = $this->language->get('tab_option');
		$data['tab_recurring'] = $this->language->get('tab_recurring');
		$data['tab_discount'] = $this->language->get('tab_discount');
		$data['tab_special'] = $this->language->get('tab_special');
		$data['tab_image'] = $this->language->get('tab_image');
		$data['tab_links'] = $this->language->get('tab_links');
		$data['tab_reward'] = $this->language->get('tab_reward');
		$data['tab_design'] = $this->language->get('tab_design');
		$data['tab_openbay'] = $this->language->get('tab_openbay');

		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->error['name'])) {
			$data['error_name'] = $this->error['name'];
		} else {
			$data['error_name'] = array();
		}

		if (isset($this->error['meta_title'])) {
			$data['error_meta_title'] = $this->error['meta_title'];
		} else {
			$data['error_meta_title'] = array();
		}

		if (isset($this->error['model'])) {
			$data['error_model'] = $this->error['model'];
		} else {
			$data['error_model'] = '';
		}

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		$url = '';

		if (isset($this->request->get['filter_name'])) {
			$url .= '&filter_name=' . urlencode(html_entity_decode($this->request->get['filter_name'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_model'])) {
			$url .= '&filter_model=' . urlencode(html_entity_decode($this->request->get['filter_model'], ENT_QUOTES, 'UTF-8'));
		}

		if (isset($this->request->get['filter_price'])) {
			$url .= '&filter_price=' . $this->request->get['filter_price'];
		}

		if (isset($this->request->get['filter_quantity'])) {
			$url .= '&filter_quantity=' . $this->request->get['filter_quantity'];
		}

		if (isset($this->request->get['filter_status'])) {
			$url .= '&filter_status=' . $this->request->get['filter_status'];
		}

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'token=' . $this->session->data['token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['product_id'])) {
			$data['action'] = $this->url->link('catalog/product/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/product/edit', 'token=' . $this->session->data['token'] . '&product_id=' . $this->request->get['product_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['product_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$product_info = $this->model_catalog_product->getProduct($this->request->get['product_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['product_description'])) {
			$data['product_description'] = $this->request->post['product_description'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_description'] = $this->model_catalog_product->getProductDescriptions($this->request->get['product_id']);
		} else {
			$data['product_description'] = array();
		}

		if (isset($this->request->post['model'])) {
			$data['model'] = $this->request->post['model'];
		} elseif (!empty($product_info)) {
			$data['model'] = $product_info['model'];
		} else {
			$data['model'] = '';
		}

		if (isset($this->request->post['sku'])) {
			$data['sku'] = $this->request->post['sku'];
		} elseif (!empty($product_info)) {
			$data['sku'] = $product_info['sku'];
		} else {
			$data['sku'] = '';
		}

		if (isset($this->request->post['upc'])) {
			$data['upc'] = $this->request->post['upc'];
		} elseif (!empty($product_info)) {
			$data['upc'] = $product_info['upc'];
		} else {
			$data['upc'] = '';
		}

		if (isset($this->request->post['ean'])) {
			$data['ean'] = $this->request->post['ean'];
		} elseif (!empty($product_info)) {
			$data['ean'] = $product_info['ean'];
		} else {
			$data['ean'] = '';
		}

		if (isset($this->request->post['jan'])) {
			$data['jan'] = $this->request->post['jan'];
		} elseif (!empty($product_info)) {
			$data['jan'] = $product_info['jan'];
		} else {
			$data['jan'] = '';
		}

		if (isset($this->request->post['isbn'])) {
			$data['isbn'] = $this->request->post['isbn'];
		} elseif (!empty($product_info)) {
			$data['isbn'] = $product_info['isbn'];
		} else {
			$data['isbn'] = '';
		}

		if (isset($this->request->post['mpn'])) {
			$data['mpn'] = $this->request->post['mpn'];
		} elseif (!empty($product_info)) {
			$data['mpn'] = $product_info['mpn'];
		} else {
			$data['mpn'] = '';
		}

		if (isset($this->request->post['location'])) {
			$data['location'] = $this->request->post['location'];
		} elseif (!empty($product_info)) {
			$data['location'] = $product_info['location'];
		} else {
			$data['location'] = '';
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['product_store'])) {
			$data['product_store'] = $this->request->post['product_store'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_store'] = $this->model_catalog_product->getProductStores($this->request->get['product_id']);
		} else {
			$data['product_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($product_info)) {
			$data['keyword'] = $product_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['shipping'])) {
			$data['shipping'] = $this->request->post['shipping'];
		} elseif (!empty($product_info)) {
			$data['shipping'] = $product_info['shipping'];
		} else {
			$data['shipping'] = 1;
		}

		if (isset($this->request->post['price'])) {
			$data['price'] = $this->request->post['price'];
		} elseif (!empty($product_info)) {
			$data['price'] = $product_info['price'];
		} else {
			$data['price'] = '';
		}

		$this->load->model('catalog/recurring');

		$data['recurrings'] = $this->model_catalog_recurring->getRecurrings();

		if (isset($this->request->post['product_recurrings'])) {
			$data['product_recurrings'] = $this->request->post['product_recurrings'];
		} elseif (!empty($product_info)) {
			$data['product_recurrings'] = $this->model_catalog_product->getRecurrings($product_info['product_id']);
		} else {
			$data['product_recurrings'] = array();
		}

		$this->load->model('localisation/tax_class');

		$data['tax_classes'] = $this->model_localisation_tax_class->getTaxClasses();

		if (isset($this->request->post['tax_class_id'])) {
			$data['tax_class_id'] = $this->request->post['tax_class_id'];
		} elseif (!empty($product_info)) {
			$data['tax_class_id'] = $product_info['tax_class_id'];
		} else {
			$data['tax_class_id'] = 0;
		}

		if (isset($this->request->post['date_available'])) {
			$data['date_available'] = $this->request->post['date_available'];
		} elseif (!empty($product_info)) {
			$data['date_available'] = ($product_info['date_available'] != '0000-00-00') ? $product_info['date_available'] : '';
		} else {
			$data['date_available'] = date('Y-m-d');
		}

		if (isset($this->request->post['quantity'])) {
			$data['quantity'] = $this->request->post['quantity'];
		} elseif (!empty($product_info)) {
			$data['quantity'] = $product_info['quantity'];
		} else {
			$data['quantity'] = 1;
		}

		if (isset($this->request->post['minimum'])) {
			$data['minimum'] = $this->request->post['minimum'];
		} elseif (!empty($product_info)) {
			$data['minimum'] = $product_info['minimum'];
		} else {
			$data['minimum'] = 1;
		}

		if (isset($this->request->post['subtract'])) {
			$data['subtract'] = $this->request->post['subtract'];
		} elseif (!empty($product_info)) {
			$data['subtract'] = $product_info['subtract'];
		} else {
			$data['subtract'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($product_info)) {
			$data['sort_order'] = $product_info['sort_order'];
		} else {
			$data['sort_order'] = 1;
		}

		$this->load->model('localisation/stock_status');

		$data['stock_statuses'] = $this->model_localisation_stock_status->getStockStatuses();

		if (isset($this->request->post['stock_status_id'])) {
			$data['stock_status_id'] = $this->request->post['stock_status_id'];
		} elseif (!empty($product_info)) {
			$data['stock_status_id'] = $product_info['stock_status_id'];
		} else {
			$data['stock_status_id'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($product_info)) {
			$data['status'] = $product_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['weight'])) {
			$data['weight'] = $this->request->post['weight'];
		} elseif (!empty($product_info)) {
			$data['weight'] = $product_info['weight'];
		} else {
			$data['weight'] = '';
		}

		$this->load->model('localisation/weight_class');

		$data['weight_classes'] = $this->model_localisation_weight_class->getWeightClasses();

		if (isset($this->request->post['weight_class_id'])) {
			$data['weight_class_id'] = $this->request->post['weight_class_id'];
		} elseif (!empty($product_info)) {
			$data['weight_class_id'] = $product_info['weight_class_id'];
		} else {
			$data['weight_class_id'] = $this->config->get('config_weight_class_id');
		}

		if (isset($this->request->post['length'])) {
			$data['length'] = $this->request->post['length'];
		} elseif (!empty($product_info)) {
			$data['length'] = $product_info['length'];
		} else {
			$data['length'] = '';
		}

		if (isset($this->request->post['width'])) {
			$data['width'] = $this->request->post['width'];
		} elseif (!empty($product_info)) {
			$data['width'] = $product_info['width'];
		} else {
			$data['width'] = '';
		}

		if (isset($this->request->post['height'])) {
			$data['height'] = $this->request->post['height'];
		} elseif (!empty($product_info)) {
			$data['height'] = $product_info['height'];
		} else {
			$data['height'] = '';
		}

		$this->load->model('localisation/length_class');

		$data['length_classes'] = $this->model_localisation_length_class->getLengthClasses();

		if (isset($this->request->post['length_class_id'])) {
			$data['length_class_id'] = $this->request->post['length_class_id'];
		} elseif (!empty($product_info)) {
			$data['length_class_id'] = $product_info['length_class_id'];
		} else {
			$data['length_class_id'] = $this->config->get('config_length_class_id');
		}

		$this->load->model('catalog/manufacturer');

		if (isset($this->request->post['manufacturer_id'])) {
			$data['manufacturer_id'] = $this->request->post['manufacturer_id'];
		} elseif (!empty($product_info)) {
			$data['manufacturer_id'] = $product_info['manufacturer_id'];
		} else {
			$data['manufacturer_id'] = 0;
		}

		if (isset($this->request->post['manufacturer'])) {
			$data['manufacturer'] = $this->request->post['manufacturer'];
		} elseif (!empty($product_info)) {
			$manufacturer_info = $this->model_catalog_manufacturer->getManufacturer($product_info['manufacturer_id']);

			if ($manufacturer_info) {
				$data['manufacturer'] = $manufacturer_info['name'];
			} else {
				$data['manufacturer'] = '';
			}
		} else {
			$data['manufacturer'] = '';
		}

		// Categories
		$this->load->model('catalog/category');

		if (isset($this->request->post['product_category'])) {
			$categories = $this->request->post['product_category'];
		} elseif (isset($this->request->get['product_id'])) {
			$categories = $this->model_catalog_product->getProductCategories($this->request->get['product_id']);
		} else {
			$categories = array();
		}

		$data['product_categories'] = array();

		foreach ($categories as $category_id) {
			$category_info = $this->model_catalog_category->getCategory($category_id);

			if ($category_info) {
				$data['product_categories'][] = array(
					'category_id' => $category_info['category_id'],
					'name'        => ($category_info['path']) ? $category_info['path'] . ' &gt; ' . $category_info['name'] : $category_info['name']
				);
			}
		}

		// Filters
		$this->load->model('catalog/filter');

		if (isset($this->request->post['product_filter'])) {
			$filters = $this->request->post['product_filter'];
		} elseif (isset($this->request->get['product_id'])) {
			$filters = $this->model_catalog_product->getProductFilters($this->request->get['product_id']);
		} else {
			$filters = array();
		}

		$data['product_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['product_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		// Attributes
		$this->load->model('catalog/attribute');

		if (isset($this->request->post['product_attribute'])) {
			$product_attributes = $this->request->post['product_attribute'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_attributes = $this->model_catalog_product->getProductAttributes($this->request->get['product_id']);
		} else {
			$product_attributes = array();
		}

		$data['product_attributes'] = array();

		foreach ($product_attributes as $product_attribute) {
			$attribute_info = $this->model_catalog_attribute->getAttribute($product_attribute['attribute_id']);

			if ($attribute_info) {
				$data['product_attributes'][] = array(
					'attribute_id'                  => $product_attribute['attribute_id'],
					'name'                          => $attribute_info['name'],
					'product_attribute_description' => $product_attribute['product_attribute_description']
				);
			}
		}

		// Options
		$this->load->model('catalog/option');

		if (isset($this->request->post['product_option'])) {
			$product_options = $this->request->post['product_option'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_options = $this->model_catalog_product->getProductOptions($this->request->get['product_id']);
		} else {
			$product_options = array();
		}

		$data['product_options'] = array();

		foreach ($product_options as $product_option) {
			$product_option_value_data = array();

			if (isset($product_option['product_option_value'])) {
				foreach ($product_option['product_option_value'] as $product_option_value) {
					$product_option_value_data[] = array(
						'product_option_value_id' => $product_option_value['product_option_value_id'],
						'option_value_id'         => $product_option_value['option_value_id'],
						'quantity'                => $product_option_value['quantity'],
						'subtract'                => $product_option_value['subtract'],
						'price'                   => $product_option_value['price'],
						'price_prefix'            => $product_option_value['price_prefix'],
						'points'                  => $product_option_value['points'],
						'points_prefix'           => $product_option_value['points_prefix'],
						'weight'                  => $product_option_value['weight'],
						'weight_prefix'           => $product_option_value['weight_prefix']
					);
				}
			}

			$data['product_options'][] = array(
				'product_option_id'    => $product_option['product_option_id'],
				'product_option_value' => $product_option_value_data,
				'option_id'            => $product_option['option_id'],
				'name'                 => $product_option['name'],
				'type'                 => $product_option['type'],
				'value'                => isset($product_option['value']) ? $product_option['value'] : '',
				'required'             => $product_option['required']
			);
		}

		$data['option_values'] = array();

		foreach ($data['product_options'] as $product_option) {
			if ($product_option['type'] == 'select' || $product_option['type'] == 'radio' || $product_option['type'] == 'checkbox' || $product_option['type'] == 'image') {
				if (!isset($data['option_values'][$product_option['option_id']])) {
					$data['option_values'][$product_option['option_id']] = $this->model_catalog_option->getOptionValues($product_option['option_id']);
				}
			}
		}

		$this->load->model('customer/customer_group');

		$data['customer_groups'] = $this->model_customer_customer_group->getCustomerGroups();

		if (isset($this->request->post['product_discount'])) {
			$product_discounts = $this->request->post['product_discount'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_discounts = $this->model_catalog_product->getProductDiscounts($this->request->get['product_id']);
		} else {
			$product_discounts = array();
		}

		$data['product_discounts'] = array();

		foreach ($product_discounts as $product_discount) {
			$data['product_discounts'][] = array(
				'customer_group_id' => $product_discount['customer_group_id'],
				'quantity'          => $product_discount['quantity'],
				'priority'          => $product_discount['priority'],
				'price'             => $product_discount['price'],
				'date_start'        => ($product_discount['date_start'] != '0000-00-00') ? $product_discount['date_start'] : '',
				'date_end'          => ($product_discount['date_end'] != '0000-00-00') ? $product_discount['date_end'] : ''
			);
		}

		if (isset($this->request->post['product_special'])) {
			$product_specials = $this->request->post['product_special'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_specials = $this->model_catalog_product->getProductSpecials($this->request->get['product_id']);
		} else {
			$product_specials = array();
		}

		$data['product_specials'] = array();

		foreach ($product_specials as $product_special) {
			$data['product_specials'][] = array(
				'customer_group_id' => $product_special['customer_group_id'],
				'priority'          => $product_special['priority'],
				'price'             => $product_special['price'],
				'date_start'        => ($product_special['date_start'] != '0000-00-00') ? $product_special['date_start'] : '',
				'date_end'          => ($product_special['date_end'] != '0000-00-00') ? $product_special['date_end'] :  ''
			);
		}
		
		// Image
		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($product_info)) {
			$data['image'] = $product_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($product_info) && is_file(DIR_IMAGE . $product_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($product_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		// Images
		if (isset($this->request->post['product_image'])) {
			$product_images = $this->request->post['product_image'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_images = $this->model_catalog_product->getProductImages($this->request->get['product_id']);
		} else {
			$product_images = array();
		}

		$data['product_images'] = array();

		foreach ($product_images as $product_image) {
			if (is_file(DIR_IMAGE . $product_image['image'])) {
				$image = $product_image['image'];
				$thumb = $product_image['image'];
			} else {
				$image = '';
				$thumb = 'no_image.png';
			}

			$data['product_images'][] = array(
				'image'      => $image,
				'thumb'      => $this->model_tool_image->resize($thumb, 100, 100),
				'sort_order' => $product_image['sort_order']
			);
		}

		// Downloads
		$this->load->model('catalog/download');

		if (isset($this->request->post['product_download'])) {
			$product_downloads = $this->request->post['product_download'];
		} elseif (isset($this->request->get['product_id'])) {
			$product_downloads = $this->model_catalog_product->getProductDownloads($this->request->get['product_id']);
		} else {
			$product_downloads = array();
		}

		$data['product_downloads'] = array();

		foreach ($product_downloads as $download_id) {
			$download_info = $this->model_catalog_download->getDownload($download_id);

			if ($download_info) {
				$data['product_downloads'][] = array(
					'download_id' => $download_info['download_id'],
					'name'        => $download_info['name']
				);
			}
		}

		if (isset($this->request->post['product_related'])) {
			$products = $this->request->post['product_related'];
		} elseif (isset($this->request->get['product_id'])) {
			$products = $this->model_catalog_product->getProductRelated($this->request->get['product_id']);
		} else {
			$products = array();
		}

		$data['product_relateds'] = array();

		foreach ($products as $product_id) {
			$related_info = $this->model_catalog_product->getProduct($product_id);

			if ($related_info) {
				$data['product_relateds'][] = array(
					'product_id' => $related_info['product_id'],
					'name'       => $related_info['name']
				);
			}
		}

		if (isset($this->request->post['points'])) {
			$data['points'] = $this->request->post['points'];
		} elseif (!empty($product_info)) {
			$data['points'] = $product_info['points'];
		} else {
			$data['points'] = '';
		}

		if (isset($this->request->post['product_reward'])) {
			$data['product_reward'] = $this->request->post['product_reward'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_reward'] = $this->model_catalog_product->getProductRewards($this->request->get['product_id']);
		} else {
			$data['product_reward'] = array();
		}

		if (isset($this->request->post['product_layout'])) {
			$data['product_layout'] = $this->request->post['product_layout'];
		} elseif (isset($this->request->get['product_id'])) {
			$data['product_layout'] = $this->model_catalog_product->getProductLayouts($this->request->get['product_id']);
		} else {
			$data['product_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/product_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['product_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 3) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		if ((utf8_strlen($this->request->post['model']) < 1) || (utf8_strlen($this->request->post['model']) > 64)) {
			$this->error['model'] = $this->language->get('error_model');
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['product_id']) && $url_alias_info['query'] != 'product_id=' . $this->request->get['product_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['product_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}

		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}

		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateCopy() {
		if (!$this->user->hasPermission('modify', 'catalog/product')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

 public function import() {
		
		$excel_field_error = 0;
		$_SESSION['productlist']=array();
	
		$this->load->language('catalog/product');
		
		$this->load->model('catalog/product');
		$this->load->model('catalog/category');
		$this->load->model('catalog/manufacturer');
		$this->load->model('localisation/stock_status');
		$this->load->model('localisation/length_class');
		$this->load->model('localisation/weight_class');
		$this->load->model('localisation/tax_class');
		$this->load->model('tool/image');
		
		$data['heading_title'] = "Import Product Data";
		
		

		$data['entry_import'] = $this->language->get('Upload CSV File');
		
		$data['entry_insertonly'] = $this->language->get('Insert Only');	
				
		$data['action'] = $this->url->link('catalog/product/import', 'token=' . $this->session->data['token'], 'SSL');
		
		$data['importdataurl'] = $this->url->link('catalog/product/importproducts', 'token=' . $this->session->data['token'], 'SSL');
		
		
		$data['sampleexport'] = $this->url->link('catalog/product/productsampleexport', 'token=' . $this->session->data['token'], 'SSL');
		$data['sample_export'] = $this->language->get('Sample Csv File');
		
  		$data['breadcrumbs'] = array();

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('text_home'),
			'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),  		
      		'separator' => false
   		);

   		$data['breadcrumbs'][] = array(
       		'text'      => $this->language->get('heading_title'),
			'href'      => $this->url->link('catalog/product', 'token=' . $this->session->data['token'], 'SSL'),
      		'separator' => ' :: '
   		);
		
		
		if(isset($_POST['submit']))
		{		
				$insertonly=0;
				$version_check=$_POST['opcversion'];
				
				if(isset($_POST['insertonly']) && $_POST['insertonly']==1)
				$insertonly=1;
				
				
				if($this->validateImport())
				{  // import form validate start
				
				 if ((isset($this->request->files['file'])) && (is_uploaded_file($this->request->files['file']['tmp_name']))) 
				 { //file upload start

					if($version_check=="opc2200" || $version_check=="opc2302")
						{ //opc version check start
				 
							@set_time_limit(3600);
						if (substr(@ini_get("memory_limit"), 0, -1) < "512") {
									@ini_set("memory_limit", "512M");
								}
						ini_set("memory_limit", "512M");
						ini_set("max_execution_time", 180);
						ini_set('display_errors', 1);
						ini_set('log_errors', 1);
						error_reporting(E_ALL);
						//set_time_limit( 60 );
						
						$filename = $this->request->files['file']['tmp_name'];

						//chdir('../system/library/PHPExcel'); // change directory to PHPExcel library
						//require_once( 'Classes/PHPExcel.php' );
						//chdir('../../../admin');

						require_once('../system/library/PHPExcel/Classes/PHPExcel.php' );

						$inputFileType = PHPExcel_IOFactory::identify($filename);
						$objReader = PHPExcel_IOFactory::createReader($inputFileType);
						//$objReader->setReadDataOnly(true);
						$reader = $objReader->load($filename);
						$reader = &$reader;						
					//			$this->clearCache();
					
						$xldata = $reader->getSheet(0);
						
						$isFirstRow = TRUE;
						
						$i = 0;
						
						$k = $xldata->getHighestRow();
						
						$columns = PHPExcel_Cell::columnIndexFromString($xldata->getHighestColumn());

						$product_list_data = array();
						$product_array = array();
						$temp=0;//declared
					    $array_additional_image=array();
						
						if($columns == 47)
						{
						
						$customer_list_array=array();
						for ($i = 0; $i < $k; $i++) {  // Excel row loop start
							//Skip the header row
							if ($isFirstRow) {
								$isFirstRow = FALSE;
								continue;
							}			
							
							$product_categories=array();				
							
							// Collect Detail
							$productname = $this->getCell($xldata, $i, 1);
					        $description = $this->getCell($xldata, $i, 2);
							$meta_description = $this->getCell($xldata, $i, 3);
							$meta_keyword = $this->getCell($xldata, $i, 4);
							$tag = $this->getCell($xldata, $i, 5);
							
							$model = $this->getCell($xldata, $i, 6);
							
							$store_id = $this->getCell($xldata, $i, 7);
							$store_id_array=array();
							$store_id_array[]=$store_id;
							
							$sku =$this->getCell($xldata, $i, 8);
							$upc = $this->getCell($xldata, $i, 9);
							$ean = $this->getCell($xldata, $i, 10);							
							$jan = $this->getCell($xldata, $i, 11);
							$isbn = $this->getCell($xldata, $i, 12);
							$mpn = $this->getCell($xldata, $i, 13);
							$location = $this->getCell($xldata, $i, 14);							
							$quantity = $this->getCell($xldata, $i, 15);
							$stock_status_name = $this->getCell($xldata, $i, 16);
							$stock_status_id=$this->model_catalog_product->getStockStatusId($stock_status_name);
				            $product_image_path = $this->getCell($xldata, $i, 17);
							//print_r(array_map('trim',explode("/",$product_image_path)));exit
							$array1=explode("/",$product_image_path);
							$array2 = array_shift($array1);							
							array_unshift($array1,"catalog");							
							$array_image=implode("/",$array1);
							//print_r($array3);exit;
							
							$require_shipping = $this->getCell($xldata, $i, 18);							
							$price = $this->getCell($xldata, $i, 19);
							$tax_class_id = $this->getCell($xldata, $i, 20);
							$date_available = $this->getCell($xldata, $i, 21);
							$weight = $this->getCell($xldata, $i, 22);							
							$weight_class_id = $this->getCell($xldata, $i, 23);
							$length = $this->getCell($xldata, $i, 24);
							$width = $this->getCell($xldata, $i, 25);
							$height = $this->getCell($xldata, $i, 26);
							$length_class_id = $this->getCell($xldata, $i, 27);
							$subtract = $this->getCell($xldata, $i, 28);
							$minimum = $this->getCell($xldata, $i, 29);
							$sort_order = $this->getCell($xldata, $i, 30);
							$viewed= $this->getCell($xldata, $i, 31);
							$points = $this->getCell($xldata, $i, 32);
							$status = $this->getCell($xldata, $i, 33);
							
							$manufacturer_name = $this->getCell($xldata, $i, 34);
							$manufacturer_id=$this->model_catalog_product->getImportManufacturerId($manufacturer_name);
							
							$get_product_category_id=array();
							$product_category = $this->getCell($xldata, $i, 35);
							$explode_product_category=explode(",",$product_category);
							foreach ($explode_product_category as $explode_product_category1) {								
								$get_product_category_id[]=$this->model_catalog_product->getImportCategoryId($explode_product_category1);								
							}							
							
						    $additional_image_path = $this->getCell($xldata, $i, 36);							
							$array11=explode(",",$additional_image_path);
							//print_r($array11);exit;
							$short=0;
				            foreach ($array11 as $array12) {
								$array13=explode("/",$array12);
								//print_r($array13);exit;
							    $array14 = array_shift($array13);
								//print_r($array13)	;exit;						
							    array_unshift($array13,"catalog");							
							    $array_additional_image[$short]['image']=implode("/",$array13);
								$array_additional_image[$short]['sort_order']=$short;
								$short++;
								
							}						
							
							$option_type = $this->getCell($xldata, $i, 37);			
							$get_option_id=$this->model_catalog_product->getOptionId($option_type);											
						    $get_option_type=$this->model_catalog_product->getOptionTypeId($get_option_id);							
							$required = $this->getCell($xldata, $i, 38);							
							$option_value = $this->getCell($xldata, $i, 39);
							$get_option_value_id=$this->model_catalog_product->getOptionValueId($option_value);							
							$option_value_quantity = $this->getCell($xldata, $i, 40);
							$option_value_subtract = $this->getCell($xldata, $i, 41);														
							$option_value_price= $this->getCell($xldata, $i, 42);
							$option_value_price_prefix = $this->getCell($xldata, $i, 43);
							$option_value_points = $this->getCell($xldata, $i, 44);
							$option_value_points_prefix= $this->getCell($xldata, $i, 45);
							$option_value_weight = $this->getCell($xldata, $i, 46);
							$option_value_weight_prefix = $this->getCell($xldata, $i, 47);
		
							if(!empty($productname)){
							$temp++;
							$temp_option=0;
							$temp_option_value=0;
						    $product_description=array();
							$custom_language_id=is_numeric($this->config->get('config_language_id'))?$this->config->get('config_language_id'):1;
							
					        $product_description[$custom_language_id]['name'] = $productname;
						    $product_description[$custom_language_id]['description'] = $description;
							$product_description[$custom_language_id]['meta_title'] = '12345';
						    $product_description[$custom_language_id]['meta_description'] = $meta_description;
							$product_description[$custom_language_id]['meta_keyword'] = $meta_keyword;
							$product_description[$custom_language_id]['tag'] = $meta_description;							
							
							$product_array[$temp]['product_description'] = $product_description;							
							
							$product_array[$temp]['model'] = $model;
							$product_array[$temp]['product_store'] = $store_id_array;
							$product_array[$temp]['sku'] = $sku;
						    $product_array[$temp]['upc'] = $upc;
						    $product_array[$temp]['ean'] = $ean;
							$product_array[$temp]['jan'] = $jan;
							$product_array[$temp]['isbn'] = $isbn;
							$product_array[$temp]['mpn'] = $mpn;
							$product_array[$temp]['location'] = $location;
							$product_array[$temp]['quantity'] = $quantity;
						    $product_array[$temp]['stock_status_id'] = $stock_status_id;
						    $product_array[$temp]['image'] = $array_image;
							$product_array[$temp]['shipping'] = ($require_shipping == "Yes")?1:0;
							$product_array[$temp]['price'] = $price;
							$product_array[$temp]['tax_class_id'] = $tax_class_id;
							$product_array[$temp]['date_available'] = $date_available;
							$product_array[$temp]['weight'] = $weight;
						    $product_array[$temp]['weight_class_id'] = $weight_class_id;
						    $product_array[$temp]['length'] = $length;
							$product_array[$temp]['width'] = $width;
							$product_array[$temp]['height'] = $height;
							$product_array[$temp]['length_class_id'] = $length_class_id;							
					        $product_array[$temp]['subtract'] = $subtract;
						    $product_array[$temp]['minimum'] = $minimum;
						    $product_array[$temp]['sort_order'] = $sort_order;
							$product_array[$temp]['viewed'] = $viewed;
							$product_array[$temp]['points'] = $points;
							$product_array[$temp]['status'] = ($status == "Enabled")?1:0;
							$product_array[$temp]['product_image'] = $array_additional_image;			
							
							// loop categories
							$product_array[$temp]['manufacturer'] = $manufacturer_name;							
							$product_array[$temp]['manufacturer_id'] = $manufacturer_id;							
							$product_array[$temp]['product_category'] = $get_product_category_id;
							
							$product_array[$temp]['product_option'][$temp_option]['product_option_id'] = '';
							$product_array[$temp]['product_option'][$temp_option]['name'] = $option_type;
							$product_array[$temp]['product_option'][$temp_option]['option_id'] = $get_option_id;
							$product_array[$temp]['product_option'][$temp_option]['type'] = $get_option_type;														
							$product_array[$temp]['product_option'][$temp_option]['required'] = ($required == "Yes")?1:0;
							$product_array[$temp]['product_option'][$temp_option]['value'] = $option_value;	
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['option_value_id']=$get_option_value_id; 
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['product_option_value_id']='';
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['quantity']=$option_value_quantity;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['subtract']=$option_value_subtract;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['price_prefix']=$option_value_price_prefix;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['price']=$option_value_price;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['points_prefix']=$option_value_points_prefix;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['points']=$option_value_points;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['weight_prefix']=$option_value_weight_prefix;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['weight']=$option_value_weight;
							}
							else
							{
								
								if(!empty($option_type)){
							$temp_option++;
							$temp_option_value++;
							$product_array[$temp]['product_option'][$temp_option]['product_option_id'] = '';
							$product_array[$temp]['product_option'][$temp_option]['name'] = $option_type;
							$product_array[$temp]['product_option'][$temp_option]['option_id'] = $get_option_id;
							$product_array[$temp]['product_option'][$temp_option]['type'] = $get_option_type;							
							$product_array[$temp]['product_option'][$temp_option]['required'] = ($required == "Yes")?1:0;
							$product_array[$temp]['product_option'][$temp_option]['value'] = $option_value;	
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['option_value_id']=$get_option_value_id; 
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['product_option_value_id']='';
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['quantity']=$option_value_quantity;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['subtract']=($option_value_subtract == "Yes")?1:0;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['price_prefix']=$option_value_price_prefix;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['price']=$option_value_price;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['points_prefix']=$option_value_points_prefix;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['points']=$option_value_points;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['weight_prefix']=$option_value_weight_prefix;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['weight']=$option_value_weight;
								}
								else{
							$temp_option_value++;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['option_value_id']=$get_option_value_id; 
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['product_option_value_id']='';
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['quantity']=$option_value_quantity;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['subtract']=($option_value_subtract == "Yes")?1:0;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['price_prefix']=$option_value_price_prefix;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['price']=$option_value_price;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['points_prefix']=$option_value_points_prefix;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['points']=$option_value_points;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['weight_prefix']=$option_value_weight_prefix;
							$product_array[$temp]['product_option'][$temp_option]['product_option_value'][$temp_option_value]['weight']=$option_value_weight;
								}
							}                
							
						
						} // Excel row loop end
						
							$product_list_data=$product_array;
						}
						else
						{
			             $excel_field_error = 1;
						}

						 }//opc version check end
						
					    } //file upload end		
						
						
						if(!$excel_field_error)
						{


							$data['sampletabledata']=$product_list_data;
							
							$_SESSION['productlist'] = $product_list_data;
						}

				} // import form validate end		
		
		}
		
        if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->error['errorfile'])) {
			$data['error_file'] = $this->error['errorfile'];
		} else {
			$data['error_file'] = '';
		}
 if (isset($this->error['errorfile_opcversion'])) {
            $data['error_file_opcversion'] = $this->error['errorfile_opcversion'];
        } else {
            $data['error_file_opcversion'] = '';
        }
		
		if($excel_field_error)
			{
			$data['error_fields'] = 'Upload like our Sample Excel File';			
			}
		else
			{
			$data['error_fields'] = '';			
			}
		
		
		
		$this->load->model('design/layout');
		$data['layouts']=$this->model_design_layout->getLayouts();
		
		$data['header']=$this->load->controller('common/header');
		$data['footer']=$this->load->controller('common/footer');
		$data['column_left']=$this->load->controller('common/column_left');

		
		$this->response->setOutput($this->load->view('catalog/product_import.tpl',$data));
		
	}
	

	public function importproducts()
	{
	$this->load->model('catalog/product');
	if(isset($_SESSION['productlist']) && is_array($_SESSION['productlist']))
	{
						foreach($_SESSION['productlist'] as $productdata)
						{                            
                                $productexist = $this->model_catalog_product->addProduct($productdata);                                
                           
                        } 
					
			unset($_SESSION['productlist']);
			$url = '';			
			$this->response->redirect($this->url->link('catalog/product', 'token=' . $this->session->data['token'] . $url, 'SSL'));	
	
	}
	
	
	}
	
    function getCell(&$worksheet, $row, $col, $default_val = '') {
        $col -= 1; // we use 1-based, PHPExcel uses 0-based column index
        $row += 1; // we use 0-based, PHPExcel used 1-based row index
        return ($worksheet->cellExistsByColumnAndRow($col, $row)) ? $worksheet->getCellByColumnAndRow($col, $row)->getValue() : $default_val;
    }
	
	
	public function productsampleexport()
	{
		/* Include PHPExcel class */
		//chdir('../system/library/PHPExcel');
		//require_once( 'Classes/PHPExcel.php' );
		//chdir('../../../admin');

		require_once('../system/library/PHPExcel/Classes/PHPExcel.php' );
		
		// Instantiate a new PHPExcel object
		$objPHPExcel = new PHPExcel(); 
		// Set the active Excel worksheet to sheet 0
		$objPHPExcel->setActiveSheetIndex(0); 
		// Initialise the Excel row number
		$rowCount = 1; 
		
		/* Add Heading Row */ 
			$objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Product Name'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Description'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'meta_description'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'meta_keyword');  		
			$objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'tag');			
			
		    $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'model');
			$objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'store_id'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'sku'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'upc'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'ean');  		
			$objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'jan');
			$objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, 'isbn'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, 'mpn'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, 'location');  		
			$objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, 'quantity'); 						
		    $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, 'stock_status_id'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, 'product_image_path'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, 'require_shipping'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, 'price');  		
			$objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, 'tax_class_id');
			$objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, 'date_available'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, 'weight'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, 'weight_class_id');  		
			$objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, 'length'); 			
			$objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, 'width'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, 'height'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, 'length_class_id'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, 'subtract');  		
			$objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, 'minimum');
			$objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowCount, 'sort_order'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, 'viewed'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount, 'points');  		
			$objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, 'status'); 			
    
			$objPHPExcel->getActiveSheet()->SetCellValue('AH'.$rowCount, 'Manufacturer Name'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('AI'.$rowCount, 'Category Name'); 			
			$objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$rowCount, 'Additional Image');		 			
			
			$objPHPExcel->getActiveSheet()->SetCellValue('AK'.$rowCount, 'Select Type'); 			
			$objPHPExcel->getActiveSheet()->SetCellValue('AL'.$rowCount, 'Required');      
			$objPHPExcel->getActiveSheet()->SetCellValue('AM'.$rowCount, 'Option Value'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('AN'.$rowCount, 'Quantity');       
			$objPHPExcel->getActiveSheet()->SetCellValue('AO'.$rowCount, 'Subtrack stock');       
			$objPHPExcel->getActiveSheet()->SetCellValue('AP'.$rowCount, 'Price');      
			$objPHPExcel->getActiveSheet()->SetCellValue('AQ'.$rowCount, 'Price Prefix'); 			
			$objPHPExcel->getActiveSheet()->SetCellValue('AR'.$rowCount, 'Ponits'); 
			$objPHPExcel->getActiveSheet()->SetCellValue('AS'.$rowCount, 'Ponits Prdefix');
            $objPHPExcel->getActiveSheet()->SetCellValue('AT'.$rowCount, 'Weight');
			$objPHPExcel->getActiveSheet()->SetCellValue('AU'.$rowCount, 'weight Prefix');
		
			
		header("Content-Type: text/csv; charset=utf-8");
		header('Content-Disposition: attachment;filename="product_list_'.date("Y m d G i s").'.csv"'); 
		//header('Content-Disposition: attachment;filename="category_list_'.date("Y m d G i s").'.xlsx"'); 
		header('Cache-Control: max-age=0'); 
			
		// Instantiate a Writer to create an OfficeOpenXML Excel .xlsx file
		//$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel,'CSV');
		// Write the Excel file to filename some_excel_file.xlsx in the current directory
		//$objWriter->save('some_excel_file.xlsx'); 
		
		/* Download CsV file in downloads */
		$objWriter->save('php://output'); 
					
//        chdir('../../..');
	}
	protected function validateImport() {
		 /*if (!$this->user->hasPermission('modify', 'sale/customer')) {
				$this->error['warning'] = $this->language->get('error_permission');
		}*/
		if(!$_POST['opcversion']){
	    	 $this->error['errorfile_opcversion'] = $this->language->get('Please Select upload Opencart version');
       		 }
		
		if (!$this->request->files['file']['tmp_name']) {
				$this->error['errorfile'] = $this->language->get('Please Upload a Excel/CSV file');
		}
		elseif($_FILES["file"]["name"])
		{
			$allowedExts = array("csv", "xlsx", "xls");
			$temp = explode(".", $_FILES["file"]["name"]);
			$extension = end($temp);
			
			if(!in_array($extension, $allowedExts))
				$this->error['errorfile'] = $this->language->get('Please Upload a Excel/CSV file');	
		}
		
		if (!$this->error) {
			return true;
		} else {
			return false;
		}
	}
//export products
public function products_export(){
	 
	 if (isset($this->request->get['filter_name'])) {
			$filter_name = $this->request->get['filter_name'];
		} else {
			$filter_name = null;
		}

		if (isset($this->request->get['filter_model'])) {
			$filter_model = $this->request->get['filter_model'];
		} else {
			$filter_model = null;
		}

		if (isset($this->request->get['filter_price'])) {
			$filter_price = $this->request->get['filter_price'];
		} else {
			$filter_price = null;
		}

		if (isset($this->request->get['filter_quantity'])) {
			$filter_quantity = $this->request->get['filter_quantity'];
		} else {
			$filter_quantity = null;
		}

		if (isset($this->request->get['filter_status'])) {
			$filter_status = $this->request->get['filter_status'];
		} else {
			$filter_status = null;
		}
		
		$filter_product_data = array(
			'filter_name'	  => $filter_name, 
			'filter_model'	  => $filter_model,
			'filter_price'	  => $filter_price,
			'filter_quantity' => $filter_quantity,
			'filter_status'   => $filter_status
		);
		
       $this->load->model('catalog/product');
       $results = $this->model_catalog_product->getProducts($filter_product_data);
	   
       $product_list = array();
	   $temp_count = 1;
	   
		foreach ($results as $result) { //print_r($results);exit;
			//print_r($results);  
		
			/*$special = false;

			$product_specials = $this->model_catalog_product->getProductSpecials($result['product_id']); 

			foreach ($product_specials  as $product_special) {
				if (($product_special['date_start'] == '0000-00-00' || $product_special['date_start'] < date('Y-m-d')) && ($product_special['date_end'] == '0000-00-00' || $product_special['date_end'] > date('Y-m-d'))) {
					$special = $product_special['price'];

					break;
				}					
			}	*/	
			
				    //$product_list[$temp_count]['product_id']  			= $result['product_id'];
					$product_list[$temp_count]['name']        			= $result['name'];
					$product_list[$temp_count]['description']    		= $this->cleanString($result['description']);
					$product_list[$temp_count]['meta_description']      = $result['meta_description'];
					$product_list[$temp_count]['meta_keyword']        	= $result['meta_keyword'];
					$product_list[$temp_count]['tag']        			= $result['tag'];					
					
					$product_list[$temp_count]['model']       			= $result['model'];
					$export_store_id = $this->model_catalog_product->getstoreID($result['product_id']);//print_r($export_store_id['store_id']);
					$product_list[$temp_count]['product_store']       		= $export_store_id['store_id'];
					$product_list[$temp_count]['sku']       			= $result['sku'];
					$product_list[$temp_count]['upc']       			= $result['upc'];
					$product_list[$temp_count]['ean']       			= $result['ean'];
					$product_list[$temp_count]['jan']       			= $result['jan'];
					$product_list[$temp_count]['isbn']       			= $result['isbn'];
					$product_list[$temp_count]['mpn']       			= $result['mpn'];
					$product_list[$temp_count]['location']       		= $result['location'];
					$product_list[$temp_count]['quantity']       		= $result['quantity'];
					
					$export_OutOfStockName = $this->model_catalog_product->getOutOfStockName($result['stock_status_id']);
					$product_list[$temp_count]['stock_status_id']       = $export_OutOfStockName;
					$product_list[$temp_count]['product_image_path']	= $result['image'];
					$product_list[$temp_count]['require_shipping']	    = ($result['shipping'] == 1 ? 'Yes' : 'No');
					$product_list[$temp_count]['price']       			= $result['price'];
					$product_list[$temp_count]['tax_class_id']          = $result['tax_class_id'];
					$product_list[$temp_count]['date_available']       	= $result['date_available'];
					$product_list[$temp_count]['weight']       			= $result['weight'];
					$product_list[$temp_count]['weight_class_id']       = $result['weight_class_id'];
					$product_list[$temp_count]['length']       			= $result['length'];
					$product_list[$temp_count]['width']       			= $result['width'];
					$product_list[$temp_count]['height']       			= $result['height'];
					$product_list[$temp_count]['length_class_id']       = $result['length_class_id'];
					$product_list[$temp_count]['subtract']       		= $result['subtract'];
					$product_list[$temp_count]['minimum']       		= $result['minimum'];
					$product_list[$temp_count]['sort_order']       		= $result['sort_order'];
					$product_list[$temp_count]['viewed']       			= $result['viewed'];
					$product_list[$temp_count]['points']       			= $result['points'];
					$product_list[$temp_count]['status']      			= ($result['status'] ? $this->language->get('text_enabled') : $this->language->get('text_disabled'));

				
            //take manufacturer name.........
			    $export_get_manufacturer_id = $this->model_catalog_product->export_getmanufacturerid($result['manufacturer_id']); 
				
			if(!empty($export_get_manufacturer_id)){
				
				foreach($export_get_manufacturer_id as $export_get_manufacturer_name){			
					
			    $product_list[$temp_count]['manufacturer_name']  = $export_get_manufacturer_name;	
				 				
					
				}
			}
			else
			{
				
				$product_list[$temp_count]['manufacturer_name']  = '';
			}
				
			//take category name	.........
				$export_get_category_id = $this->model_catalog_product->export_getcategoryid($result['product_id']);				
			    $temp=array();
				$export_get_category_name=array();
				  
			   foreach($export_get_category_id as $export_get_category_id1){
			   	 					  	
						$export_get_category_name[] = $this->model_catalog_product->export_getcategory_name($export_get_category_id1['category_id']);
				   
               }
				
			   foreach ($export_get_category_name as $export_get_category_name1) {				 	
						  	
							$temp[]=$export_get_category_name1['name'];
						  	
			   }	
				
			   $category_name = implode(',',$temp);
			   
			   $product_list[$temp_count]['category_name']    	= (isset($category_name) ? $category_name : ""); 
				

              //take additional image for products......
              $temp_image=array();			  
			  
              $export_get_additional_image_path = $this->model_catalog_product->export_getimagepath($result['product_id']);	 
			 $additional_image_path ="";
			  foreach ($export_get_additional_image_path as $export_get_additional_image_path1) {
	
			  	    $temp_image[]=$export_get_additional_image_path1['image'];
			      
	                $additional_image_path = implode(',',$temp_image);
				
			  }
			  $product_list[$temp_count]['additional_image_path']    	= $additional_image_path;
			  
			
				
			//take product option value	.....
			
			$export_get_option_details = $this->model_catalog_product->export_getoption_details($result['product_id']);
			//print_r($export_get_option_details);exit;
		 $option_temp=0;
		 foreach ($export_get_option_details as $getproduct_option_name1) { //start loop2
			     	
					
			     	
				 	if($option_temp==0){
					
					 $product_list[$temp_count]['option_type'] = $getproduct_option_name1['name'];
					 $product_list[$temp_count]['required'] = ($getproduct_option_name1['required'] == 1 ? 'Yes' : 'No');
	
					}
					else{
												
		   			//$product_list[$temp_count]['product_id']  			= '';
				        $product_list[$temp_count]['name']        			= '';
					$product_list[$temp_count]['description']    		= '';	
					$product_list[$temp_count]['meta_description']      = '';
					$product_list[$temp_count]['meta_keyword']        	= '';
					$product_list[$temp_count]['tag']        			= '';			
					
					$product_list[$temp_count]['model']       			= '';
					$product_list[$temp_count]['product_store']       	= '';
					$product_list[$temp_count]['sku']       			= '';
					$product_list[$temp_count]['upc']       			= '';
					$product_list[$temp_count]['ean']       			= '';
					$product_list[$temp_count]['jan']       			= '';
					$product_list[$temp_count]['isbn']       			= '';
					$product_list[$temp_count]['mpn']       			= '';
					$product_list[$temp_count]['location']       		= '';
					$product_list[$temp_count]['quantity']       		= '';
					$product_list[$temp_count]['stock_status_id']       = '';
					$product_list[$temp_count]['product_image_path']	= '';
					$product_list[$temp_count]['require_shipping']	    = '';
					$product_list[$temp_count]['price']       			= '';
					$product_list[$temp_count]['tax_class_id']          = '';
					$product_list[$temp_count]['date_available']       	= '';
					$product_list[$temp_count]['weight']       			= '';
					$product_list[$temp_count]['weight_class_id']       = '';
					$product_list[$temp_count]['length']       			= '';
					$product_list[$temp_count]['width']       			= '';
					$product_list[$temp_count]['height']       			= '';
					$product_list[$temp_count]['length_class_id']       = '';
					$product_list[$temp_count]['subtract']       		= '';
					$product_list[$temp_count]['minimum']       		= '';
					$product_list[$temp_count]['sort_order']       		= '';
					$product_list[$temp_count]['viewed']       			= '';
					$product_list[$temp_count]['points']       			= '';
					$product_list[$temp_count]['status']      			='';
					
					$product_list[$temp_count]['manufacturer_name']  = '';
					$product_list[$temp_count]['category_name']    	= '';
					$product_list[$temp_count]['additional_image_path']    	= '';					
					$product_list[$temp_count]['option_type'] = $getproduct_option_name1['name'];					
					$product_list[$temp_count]['required'] = ($getproduct_option_name1['required'] == 1 ? 'Yes' : 'No');
					
					}
					
					
					
					$t1=0;
					if(!empty($getproduct_option_name1['product_option_value'])){
					     	foreach ($getproduct_option_name1['product_option_value'] as $getproduct_option_value1) {
							
							 
								 if($t1==0){
								 		
								 	         $product_list[$temp_count]['option_value'] = $getproduct_option_value1['option_value_name'];
											 $product_list[$temp_count]['option_value_quantity'] = $getproduct_option_value1['quantity'];
											 $product_list[$temp_count]['option_value_subtract'] = ($getproduct_option_value1['subtract']==1 ? 'Yes' : 'No');
											 $product_list[$temp_count]['option_value_price'] = $getproduct_option_value1['price'];
											 $product_list[$temp_count]['option_value_price_prefix'] = $getproduct_option_value1['price_prefix'];
											 $product_list[$temp_count]['option_value_points'] = $getproduct_option_value1['points'];
											 $product_list[$temp_count]['option_value_points_prefix'] = $getproduct_option_value1['points_prefix'];
											 $product_list[$temp_count]['option_value_weight'] = $getproduct_option_value1['weight'];
											 $product_list[$temp_count]['option_value_weight_prefix'] = $getproduct_option_value1['weight_prefix'];
									            
									 }
									 else{
									            //$product_list[$temp_count]['product_id']  			= '';
											    $product_list[$temp_count]['name']        			= '';
												$product_list[$temp_count]['description']    		= '';
												$product_list[$temp_count]['meta_description']      = $result['meta_description'];
												$product_list[$temp_count]['meta_keyword']        	= $result['meta_keyword'];
												$product_list[$temp_count]['tag']        			= $result['tag'];
											
												
												$product_list[$temp_count]['model']       			= '';
												$product_list[$temp_count]['product_store']       	= '';
												$product_list[$temp_count]['sku']       			= '';
												$product_list[$temp_count]['upc']       			= '';
												$product_list[$temp_count]['ean']       			= '';
												$product_list[$temp_count]['jan']       			= '';
												$product_list[$temp_count]['isbn']       			= '';
												$product_list[$temp_count]['mpn']       			= '';
												$product_list[$temp_count]['location']       		= '';
												$product_list[$temp_count]['quantity']       		= '';
												$product_list[$temp_count]['stock_status_id']       = '';
												$product_list[$temp_count]['product_image_path']	= '';
												$product_list[$temp_count]['require_shipping']	    = '';
												$product_list[$temp_count]['price']       			= '';
												$product_list[$temp_count]['tax_class_id']          = '';
												$product_list[$temp_count]['date_available']       	= '';
												$product_list[$temp_count]['weight']       			= '';
												$product_list[$temp_count]['weight_class_id']       = '';
												$product_list[$temp_count]['length']       			= '';
												$product_list[$temp_count]['width']       			= '';
												$product_list[$temp_count]['height']       			= '';
												$product_list[$temp_count]['length_class_id']       = '';
												$product_list[$temp_count]['subtract']       		= '';
												$product_list[$temp_count]['minimum']       		= '';
												$product_list[$temp_count]['sort_order']       		= '';
												$product_list[$temp_count]['viewed']       			= '';
												$product_list[$temp_count]['points']       			= '';
												$product_list[$temp_count]['status']      			='';
					
												
												$product_list[$temp_count]['manufacturer_name']  = '';
												$product_list[$temp_count]['category_name']    	= '';
												$product_list[$temp_count]['additional_image_path']    	= '';												
												$product_list[$temp_count]['option_type'] = '';
												$product_list[$temp_count]['required'] = '';
					
								 	             $product_list[$temp_count]['option_value'] = $getproduct_option_value1['option_value_name'];
												 $product_list[$temp_count]['option_value_quantity'] = $getproduct_option_value1['quantity'];
												 $product_list[$temp_count]['option_value_subtract'] = ($getproduct_option_value1['subtract']==1 ? 'Yes' : 'No');
												 $product_list[$temp_count]['option_value_price'] = $getproduct_option_value1['price'];
												 $product_list[$temp_count]['option_value_price_prefix'] = $getproduct_option_value1['price_prefix'];
												 $product_list[$temp_count]['option_value_points'] = $getproduct_option_value1['points'];
												 $product_list[$temp_count]['option_value_points_prefix'] = $getproduct_option_value1['points_prefix'];
												 $product_list[$temp_count]['option_value_weight'] = $getproduct_option_value1['weight'];
												 $product_list[$temp_count]['option_value_weight_prefix'] = $getproduct_option_value1['weight_prefix'];
									         
											
									     }								
							 
							 $t1++;$temp_count++;
				         }
						 
                     }
                      
$option_temp++;$temp_count++;
					}
					
$temp_count++;
				}	
									
			//print_r($product_list);exit;						
						$products_data = array();
						
						$products_column=array();
						
						$products_column = array('Product Name', 'Product Description','Meta Description','Meta Keyword','Tag', 'Model', 'Store_id','sku','upc','ean','jan','isbn','mpn','location','quantity','stock_status_id','image','Require shipping','price','tax_class_id','date_available','weight','weight_class_id','length','width','height','length_class_id','subtract','minimum','sort_order','viewed','Points','Status', 'Manufacturer Name', 'Category Name','Additional Image','Select Type','Required','Option Value','Quantity','Subtrack stock','Price','Price Prefix','Ponits','Ponits Prdefix','Weight','weight Prefix');
						//$products_column = array('Product ID', 'Product Name',  'Model', 'Price', 'Quantity', 'Require Shipping', 'Image', 'Manufacturer Name', 'Category Name');
							
						$products_data[0]=   $products_column;   
						
						foreach($product_list as $products_row)
						{
							$products_data[]=   $products_row;            
						} 		


				        header( 'Content-Type: text/csv' );
				        header( 'Content-Disposition: attachment;filename="product_list_'.date("Y m d G i s").'.csv"');
						$out = fopen('php://output', 'w');
				
						foreach ($products_data as $fields) {
						    fputcsv($out, $fields);
						}
						
						fclose($out);
	

					
}
public function cleanString($text) {
						// 1) convert á ô => a o
						$text = preg_replace("/[áàâãªä]/u","a",$text);
						$text = preg_replace("/[ÁÀÂÃÄ]/u","A",$text);
						$text = preg_replace("/[ÍÌÎÏ]/u","I",$text);
						$text = preg_replace("/[íìîï]/u","i",$text);
						$text = preg_replace("/[éèêë]/u","e",$text);
						$text = preg_replace("/[ÉÈÊË]/u","E",$text);
						$text = preg_replace("/[óòôõºö]/u","o",$text);
						$text = preg_replace("/[ÓÒÔÕÖ]/u","O",$text);
						$text = preg_replace("/[úùûü]/u","u",$text);
						$text = preg_replace("/[ÚÙÛÜ]/u","U",$text);
						$text = preg_replace("/[’‘‹›‚]/u","'",$text);
						$text = preg_replace("/[“”«»„]/u",'"',$text);
						$text = str_replace("–","-",$text);
						$text = str_replace(" "," ",$text);
						$text = str_replace("ç","c",$text);
						$text = str_replace("Ç","C",$text);
						$text = str_replace("ñ","n",$text);
						$text = str_replace("Ñ","N",$text);
					 
						//2) Translation CP1252. &ndash; => -
						$trans = get_html_translation_table(HTML_ENTITIES); 
						$trans[chr(130)] = '&sbquo;';    // Single Low-9 Quotation Mark 
						$trans[chr(131)] = '&fnof;';    // Latin Small Letter F With Hook 
						$trans[chr(132)] = '&bdquo;';    // Double Low-9 Quotation Mark 
						$trans[chr(133)] = '&hellip;';    // Horizontal Ellipsis 
						$trans[chr(134)] = '&dagger;';    // Dagger 
						$trans[chr(135)] = '&Dagger;';    // Double Dagger 
						$trans[chr(136)] = '&circ;';    // Modifier Letter Circumflex Accent 
						$trans[chr(137)] = '&permil;';    // Per Mille Sign 
						$trans[chr(138)] = '&Scaron;';    // Latin Capital Letter S With Caron 
						$trans[chr(139)] = '&lsaquo;';    // Single Left-Pointing Angle Quotation Mark 
						$trans[chr(140)] = '&OElig;';    // Latin Capital Ligature OE 
						$trans[chr(145)] = '&lsquo;';    // Left Single Quotation Mark 
						$trans[chr(146)] = '&rsquo;';    // Right Single Quotation Mark 
						$trans[chr(147)] = '&ldquo;';    // Left Double Quotation Mark 
						$trans[chr(148)] = '&rdquo;';    // Right Double Quotation Mark 
						$trans[chr(149)] = '&bull;';    // Bullet 
						$trans[chr(150)] = '&ndash;';    // En Dash 
						$trans[chr(151)] = '&mdash;';    // Em Dash 
						$trans[chr(152)] = '&tilde;';    // Small Tilde 
						$trans[chr(153)] = '&trade;';    // Trade Mark Sign 
						$trans[chr(154)] = '&scaron;';    // Latin Small Letter S With Caron 
						$trans[chr(155)] = '&rsaquo;';    // Single Right-Pointing Angle Quotation Mark 
						$trans[chr(156)] = '&oelig;';    // Latin Small Ligature OE 
						$trans[chr(159)] = '&Yuml;';    // Latin Capital Letter Y With Diaeresis 
						$trans['euro'] = '&euro;';    // euro currency symbol 
						ksort($trans); 
						 
						foreach ($trans as $k => $v) {
							$text = str_replace($v, $k, $text);
						}
					 
						// 3) remove <p>, <br/> ...
						$text = strip_tags($text); 
						 
						// 4) &amp; => & &quot; => '
						$text = html_entity_decode($text);
						 
						// 5) remove Windows-1252 symbols like "TradeMark", "Euro"...
						$text = preg_replace('/[^(\x20-\x7F)]*/','', $text); 
						 
						$targets=array('\r\n','\n','\r','\t');
						$results=array(" "," "," ","");
						$text = str_replace($targets,$results,$text);
					 
						//XML compatible
						/*
						$text = str_replace("&", "and", $text);
						$text = str_replace("<", ".", $text);
						$text = str_replace(">", ".", $text);
						$text = str_replace("\\", "-", $text);
						$text = str_replace("/", "-", $text);
						*/
						 
						return ($text);
					}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name']) || isset($this->request->get['filter_model'])) {
			$this->load->model('catalog/product');
			$this->load->model('catalog/option');

			if (isset($this->request->get['filter_name'])) {
				$filter_name = $this->request->get['filter_name'];
			} else {
				$filter_name = '';
			}

			if (isset($this->request->get['filter_model'])) {
				$filter_model = $this->request->get['filter_model'];
			} else {
				$filter_model = '';
			}

			if (isset($this->request->get['limit'])) {
				$limit = $this->request->get['limit'];
			} else {
				$limit = 5;
			}

			$filter_data = array(
				'filter_name'  => $filter_name,
				'filter_model' => $filter_model,
				'start'        => 0,
				'limit'        => $limit
			);

			$results = $this->model_catalog_product->getProducts($filter_data);

			foreach ($results as $result) {
				$option_data = array();

				$product_options = $this->model_catalog_product->getProductOptions($result['product_id']);

				foreach ($product_options as $product_option) {
					$option_info = $this->model_catalog_option->getOption($product_option['option_id']);

					if ($option_info) {
						$product_option_value_data = array();

						foreach ($product_option['product_option_value'] as $product_option_value) {
							$option_value_info = $this->model_catalog_option->getOptionValue($product_option_value['option_value_id']);

							if ($option_value_info) {
								$product_option_value_data[] = array(
									'product_option_value_id' => $product_option_value['product_option_value_id'],
									'option_value_id'         => $product_option_value['option_value_id'],
									'name'                    => $option_value_info['name'],
									'price'                   => (float)$product_option_value['price'] ? $this->currency->format($product_option_value['price'], $this->config->get('config_currency')) : false,
									'price_prefix'            => $product_option_value['price_prefix']
								);
							}
						}

						$option_data[] = array(
							'product_option_id'    => $product_option['product_option_id'],
							'product_option_value' => $product_option_value_data,
							'option_id'            => $product_option['option_id'],
							'name'                 => $option_info['name'],
							'type'                 => $option_info['type'],
							'value'                => $product_option['value'],
							'required'             => $product_option['required']
						);
					}
				}

				$json[] = array(
					'product_id' => $result['product_id'],
					'name'       => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8')),
					'model'      => $result['model'],
					'option'     => $option_data,
					'price'      => $result['price']
				);
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
