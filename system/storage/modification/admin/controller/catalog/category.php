<?php
class ControllerCatalogCategory extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		$this->getList();
	}

	public function add() {
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_category->addCategory($this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function edit() {
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validateForm()) {
			$this->model_catalog_category->editCategory($this->request->get['category_id'], $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getForm();
	}

	public function delete() {
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $category_id) {
				$this->model_catalog_category->deleteCategory($category_id);
			}

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	public function repair() {
		$this->load->language('catalog/category');

		$this->document->setTitle($this->language->get('heading_title'));

		$this->load->model('catalog/category');

		if ($this->validateRepair()) {
			$this->model_catalog_category->repairCategories();

			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			$this->response->redirect($this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, true));
		}

		$this->getList();
	}

	protected function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'name';
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
			'href' => $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, true)
		);

$data['button_import'] = $this->language->get('button_import');
        $data['import'] = $this->url->link('catalog/category/import', 'token=' . $this->session->data['token'],true);
$data['button_export'] = $this->language->get('button_export');
	$data['export'] = $this->url->link('catalog/category/category_export', 'token=' . $this->session->data['token'],true);

		$data['add'] = $this->url->link('catalog/category/add', 'token=' . $this->session->data['token'] . $url, true);
		$data['delete'] = $this->url->link('catalog/category/delete', 'token=' . $this->session->data['token'] . $url, true);
		$data['repair'] = $this->url->link('catalog/category/repair', 'token=' . $this->session->data['token'] . $url, true);

		$data['categories'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);

		$category_total = $this->model_catalog_category->getTotalCategories();

		$results = $this->model_catalog_category->getCategories($filter_data);

		foreach ($results as $result) {
			$data['categories'][] = array(
				'category_id' => $result['category_id'],
				'name'        => $result['name'],
				'sort_order'  => $result['sort_order'],
				'edit'        => $this->url->link('catalog/category/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $result['category_id'] . $url, true),
				'delete'      => $this->url->link('catalog/category/delete', 'token=' . $this->session->data['token'] . '&category_id=' . $result['category_id'] . $url, true)
			);
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_list'] = $this->language->get('text_list');
		$data['text_no_results'] = $this->language->get('text_no_results');
		$data['text_confirm'] = $this->language->get('text_confirm');

		$data['column_name'] = $this->language->get('column_name');
		$data['column_sort_order'] = $this->language->get('column_sort_order');
		$data['column_action'] = $this->language->get('column_action');

		$data['button_add'] = $this->language->get('button_add');
		$data['button_edit'] = $this->language->get('button_edit');
		$data['button_delete'] = $this->language->get('button_delete');
		$data['button_rebuild'] = $this->language->get('button_rebuild');

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

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['sort_name'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . '&sort=name' . $url, true);
		$data['sort_sort_order'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . '&sort=sort_order' . $url, true);

		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $category_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url . '&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($category_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($category_total - $this->config->get('config_limit_admin'))) ? $category_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $category_total, ceil($category_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/category_list', $data));
	}

 public function import() {

        $excel_field_error = 0;
		
        $_SESSION['categorylist']=array();

        $this->load->language('sale/customer');
        //$this->load->model('sale/order');

        $data['heading_title'] = "Import Category Data";

        $data['entry_import'] = $this->language->get('Upload CSV File');

        $data['entry_insertonly'] = $this->language->get('Insert Only');

        $data['action'] = $this->url->link('catalog/category/import', 'token=' . $this->session->data['token'], 'SSL');

        $data['importdataurl'] = $this->url->link('catalog/category/importcategory', 'token=' . $this->session->data['token'], 'SSL');
        $data['sampleexport'] = $this->url->link('catalog/category/categorysampleexport', 'token=' . $this->session->data['token'], 'SSL');
        $data['sample_export'] = $this->language->get('Sample Csv File');

        $data['breadcrumbs'] = array();

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('text_home'),
            'href'      => $this->url->link('common/home', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => false
        );

        $data['breadcrumbs'][] = array(
            'text'      => $this->language->get('heading_title'),
            'href'      => $this->url->link('catalog/category', 'token=' . $this->session->data['token'], 'SSL'),
            'separator' => ' :: '
        );


        if(isset($_POST['submit']))
        {

	    $version_check=$_POST['opcversion'];	
            $insertonly=0;

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
					
                    $category_array = array();
					$temp=0;
					
                    $columns = PHPExcel_Cell::columnIndexFromString($xldata->getHighestColumn());

                    if($columns == 11)
                    {
                        for ($i = 0; $i < $k; $i++) {  // Excel row loop start
                            //Skip the header row
                            if ($isFirstRow) {
                                $isFirstRow = FALSE;
                                continue;
                            }

                            $category_name = $this->getCell($xldata, $i, 1);
                            $description = $this->getCell($xldata, $i, 2);                            
                            $meta_description = $this->getCell($xldata, $i, 3);                           
                            $meta_keyword = $this->getCell($xldata, $i, 4); 
							                          
                            $parent_ID = $this->getCell($xldata, $i, 5);
                            $image = $this->getCell($xldata, $i, 6);	
							
							$array1=explode("/",$image);
							$array2 = array_shift($array1);							
							array_unshift($array1,"catalog");							
							$array_image=implode("/",$array1);
							///print_r($array_image);
													
                            $top = $this->getCell($xldata, $i, 7);						
                            $store_id = $this->getCell($xldata, $i, 8);	
							$store_id_array=array();
							$store_id_array[]=$store_id;
							
					
							$column = $this->getCell($xldata, $i, 9);
									
							$sort_order = $this->getCell($xldata, $i, 10);
							$status = $this->getCell($xldata, $i, 11);
               		
		                    $custom_language_id=is_numeric($this->config->get('config_language_id'))?$this->config->get('config_language_id'):1;
						
                                $category_description[$custom_language_id]['name'] = $category_name;
                                $category_description[$custom_language_id]['description'] = $description;
                                $category_description[$custom_language_id]['meta_title'] = '';
                                $category_description[$custom_language_id]['meta_description'] = $meta_description;
                                $category_description[$custom_language_id]['meta_keyword'] = $meta_keyword;
								
								$category_array[$temp]['category_description'] = $category_description;
								
								$category_array[$temp]['language_id'] = 1;					
                                $category_array[$temp]['parent_id'] = $parent_ID;
								$category_array[$temp]['image'] = $array_image;
								$category_array[$temp]['top'] = $top;
								$category_array[$temp]['category_store'] = $store_id_array;							
								
								$category_array[$temp]['column'] = $column;
								$category_array[$temp]['sort_order'] = $sort_order;
								$category_array[$temp]['status'] = ($status == "Enable" ? 1 : 0);
								
							    $temp++;

                            } // Excel row loop end
    

                        $category_list_data=$category_array;
						//print_r($category_list_data);exit;

                    }
                    else
                    {
                        $excel_field_error = 1;
                    }

			 }//opc version check end

                } //file upload end

                if(!$excel_field_error)
                {

                    $data['sampletabledata']= $category_list_data;

                    $_SESSION['categorylist'] = $category_list_data;
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

        /* $this->load->model('design/layout');
       $data['layouts']=$this->model_design_layout->getLayouts();*/

        $data['header']=$this->load->controller('common/header');
        $data['footer']=$this->load->controller('common/footer');
        $data['column_left']=$this->load->controller('common/column_left');

        if (isset($this->request->server['HTTPS']) && (($this->request->server['HTTPS'] == 'on') || ($this->request->server['HTTPS'] == '1'))) {
            $data['base'] = $this->config->get('config_ssl');
        } else {
            $data['base'] = $this->config->get('config_url');
        }

        $this->response->setOutput($this->load->view('catalog/category_import.tpl',$data));//print_r($_SESSION['categorylist']);exit;

    }



    public function importcategory()
	{
	$this->load->model('catalog/category');
	if(isset($_SESSION['categorylist']) && is_array($_SESSION['categorylist']))
	{
		//print_r($_SESSION['categorylist']);
		
						foreach($_SESSION['categorylist'] as $categorydata)
						{                            
                                $productexist = $this->model_catalog_category->addCategory($categorydata);                                
                           
                        } 
					
			unset($_SESSION['categorylist']);
			$url = '';			
			$this->response->redirect($this->url->link('catalog/category', 'token=' . $this->session->data['token'] ,true));	
	
	}
	
	//exit;
	}

    function getCell(&$worksheet, $row, $col, $default_val = '') {
        $col -= 1; // we use 1-based, PHPExcel uses 0-based column index
        $row += 1; // we use 0-based, PHPExcel used 1-based row index
        return ($worksheet->cellExistsByColumnAndRow($col, $row)) ? $worksheet->getCellByColumnAndRow($col, $row)->getValue() : $default_val;
    }

    public function categorysampleexport()
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
		
       //customer field
        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, 'Category Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, 'Description');
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, 'Meta_description');
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, 'Meta_keyword');
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, 'Parent ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, 'Image');
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, 'Top');
		$objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, 'Store_id');
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, 'Column');
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, 'Sort Order');
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, 'Status');

       

        header("Content-Type: text/csv; charset=utf-8");
        header('Content-Disposition: attachment;filename="category_list_'.date("Y m d G i s").'.csv"');
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
	     $this->error['errorfile_opcversion'] = $this->language->get('Please Select upload version');
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

//export category
public function category_export(){      
      
		$temp_count = 1;		 
		$this->load->model('catalog/category');
		$results=array();
        $results_description = $this->model_catalog_category->ExportgetCategoryDescriptions(); //print_r($results_description);exit;        
        
        foreach ($results_description as $result) { //print_r($result['name']);exit;
        	//customer table
        	$category_list[$temp_count]['name']        					= $result['name'];
            $category_list[$temp_count]['description']        			= $this->cleanString($result['description']);
			$category_list[$temp_count]['meta_description']        		= $result['meta_description'];
			$category_list[$temp_count]['meta_keyword']        			= $result['meta_keyword'];
			
			$category_list[$temp_count]['parent_id']        			= $result['parent_id'];
			$category_list[$temp_count]['image']        				= $result['image'];
			$category_list[$temp_count]['top']        					= $result['top'];
			$category_list[$temp_count]['store_id']        				= $result['store_id'];
			$category_list[$temp_count]['column']        				= $result['column'];
			$category_list[$temp_count]['sort_order']        			= $result['sort_order'];
			$category_list[$temp_count]['status']        				= ($result['status'] == 1 ? 'Enable' : 'Disable');			
			
            $temp_count++;
        }  
	   
        
        $category = array();
        
        $category_column=array();        
		        
         $category_column = array('Category Name','Description','Meta_description','Meta_keyword','Parent ID','Image','Top','Store_id','Column','Sort Order','Status');
            
        $category[0] = $category_column;          
  
        foreach($category_list as $category_row)
        {
            $category[]=$category_row;
        }
     
                        header( 'Content-Type: text/csv' );
				        header( 'Content-Disposition: attachment;filename="Category_List_'.date("Y m d G i s").'.csv"');
						$out = fopen('php://output', 'w');
				
						foreach ($category as $fields) {
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
						return ($text);
					}

	protected function getForm() {
		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_form'] = !isset($this->request->get['category_id']) ? $this->language->get('text_add') : $this->language->get('text_edit');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_default'] = $this->language->get('text_default');
		$data['text_enabled'] = $this->language->get('text_enabled');
		$data['text_disabled'] = $this->language->get('text_disabled');

		$data['entry_name'] = $this->language->get('entry_name');
		$data['entry_description'] = $this->language->get('entry_description');
		$data['entry_meta_title'] = $this->language->get('entry_meta_title');
		$data['entry_meta_description'] = $this->language->get('entry_meta_description');
		$data['entry_meta_keyword'] = $this->language->get('entry_meta_keyword');
		$data['entry_keyword'] = $this->language->get('entry_keyword');
		$data['entry_parent'] = $this->language->get('entry_parent');
		$data['entry_filter'] = $this->language->get('entry_filter');
		$data['entry_store'] = $this->language->get('entry_store');
		$data['entry_image'] = $this->language->get('entry_image');
		$data['entry_top'] = $this->language->get('entry_top');
		$data['entry_column'] = $this->language->get('entry_column');
		$data['entry_sort_order'] = $this->language->get('entry_sort_order');
		$data['entry_status'] = $this->language->get('entry_status');
		$data['entry_layout'] = $this->language->get('entry_layout');

		$data['help_filter'] = $this->language->get('help_filter');
		$data['help_keyword'] = $this->language->get('help_keyword');
		$data['help_top'] = $this->language->get('help_top');
		$data['help_column'] = $this->language->get('help_column');

		$data['button_save'] = $this->language->get('button_save');
		$data['button_cancel'] = $this->language->get('button_cancel');

		$data['tab_general'] = $this->language->get('tab_general');
		$data['tab_data'] = $this->language->get('tab_data');
		$data['tab_design'] = $this->language->get('tab_design');

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

		if (isset($this->error['keyword'])) {
			$data['error_keyword'] = $this->error['keyword'];
		} else {
			$data['error_keyword'] = '';
		}

		if (isset($this->error['parent'])) {
			$data['error_parent'] = $this->error['parent'];
		} else {
			$data['error_parent'] = '';
		}
		
		$url = '';

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
			'href' => $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, true)
		);

		if (!isset($this->request->get['category_id'])) {
			$data['action'] = $this->url->link('catalog/category/add', 'token=' . $this->session->data['token'] . $url, true);
		} else {
			$data['action'] = $this->url->link('catalog/category/edit', 'token=' . $this->session->data['token'] . '&category_id=' . $this->request->get['category_id'] . $url, true);
		}

		$data['cancel'] = $this->url->link('catalog/category', 'token=' . $this->session->data['token'] . $url, true);

		if (isset($this->request->get['category_id']) && ($this->request->server['REQUEST_METHOD'] != 'POST')) {
			$category_info = $this->model_catalog_category->getCategory($this->request->get['category_id']);
		}

		$data['token'] = $this->session->data['token'];

		$this->load->model('localisation/language');

		$data['languages'] = $this->model_localisation_language->getLanguages();

		if (isset($this->request->post['category_description'])) {
			$data['category_description'] = $this->request->post['category_description'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_description'] = $this->model_catalog_category->getCategoryDescriptions($this->request->get['category_id']);
		} else {
			$data['category_description'] = array();
		}

		if (isset($this->request->post['path'])) {
			$data['path'] = $this->request->post['path'];
		} elseif (!empty($category_info)) {
			$data['path'] = $category_info['path'];
		} else {
			$data['path'] = '';
		}

		if (isset($this->request->post['parent_id'])) {
			$data['parent_id'] = $this->request->post['parent_id'];
		} elseif (!empty($category_info)) {
			$data['parent_id'] = $category_info['parent_id'];
		} else {
			$data['parent_id'] = 0;
		}

		$this->load->model('catalog/filter');

		if (isset($this->request->post['category_filter'])) {
			$filters = $this->request->post['category_filter'];
		} elseif (isset($this->request->get['category_id'])) {
			$filters = $this->model_catalog_category->getCategoryFilters($this->request->get['category_id']);
		} else {
			$filters = array();
		}

		$data['category_filters'] = array();

		foreach ($filters as $filter_id) {
			$filter_info = $this->model_catalog_filter->getFilter($filter_id);

			if ($filter_info) {
				$data['category_filters'][] = array(
					'filter_id' => $filter_info['filter_id'],
					'name'      => $filter_info['group'] . ' &gt; ' . $filter_info['name']
				);
			}
		}

		$this->load->model('setting/store');

		$data['stores'] = $this->model_setting_store->getStores();

		if (isset($this->request->post['category_store'])) {
			$data['category_store'] = $this->request->post['category_store'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_store'] = $this->model_catalog_category->getCategoryStores($this->request->get['category_id']);
		} else {
			$data['category_store'] = array(0);
		}

		if (isset($this->request->post['keyword'])) {
			$data['keyword'] = $this->request->post['keyword'];
		} elseif (!empty($category_info)) {
			$data['keyword'] = $category_info['keyword'];
		} else {
			$data['keyword'] = '';
		}

		if (isset($this->request->post['image'])) {
			$data['image'] = $this->request->post['image'];
		} elseif (!empty($category_info)) {
			$data['image'] = $category_info['image'];
		} else {
			$data['image'] = '';
		}

		$this->load->model('tool/image');

		if (isset($this->request->post['image']) && is_file(DIR_IMAGE . $this->request->post['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($this->request->post['image'], 100, 100);
		} elseif (!empty($category_info) && is_file(DIR_IMAGE . $category_info['image'])) {
			$data['thumb'] = $this->model_tool_image->resize($category_info['image'], 100, 100);
		} else {
			$data['thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}

		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);

		if (isset($this->request->post['top'])) {
			$data['top'] = $this->request->post['top'];
		} elseif (!empty($category_info)) {
			$data['top'] = $category_info['top'];
		} else {
			$data['top'] = 0;
		}

		if (isset($this->request->post['column'])) {
			$data['column'] = $this->request->post['column'];
		} elseif (!empty($category_info)) {
			$data['column'] = $category_info['column'];
		} else {
			$data['column'] = 1;
		}

		if (isset($this->request->post['sort_order'])) {
			$data['sort_order'] = $this->request->post['sort_order'];
		} elseif (!empty($category_info)) {
			$data['sort_order'] = $category_info['sort_order'];
		} else {
			$data['sort_order'] = 0;
		}

		if (isset($this->request->post['status'])) {
			$data['status'] = $this->request->post['status'];
		} elseif (!empty($category_info)) {
			$data['status'] = $category_info['status'];
		} else {
			$data['status'] = true;
		}

		if (isset($this->request->post['category_layout'])) {
			$data['category_layout'] = $this->request->post['category_layout'];
		} elseif (isset($this->request->get['category_id'])) {
			$data['category_layout'] = $this->model_catalog_category->getCategoryLayouts($this->request->get['category_id']);
		} else {
			$data['category_layout'] = array();
		}

		$this->load->model('design/layout');

		$data['layouts'] = $this->model_design_layout->getLayouts();

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('catalog/category_form', $data));
	}

	protected function validateForm() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		foreach ($this->request->post['category_description'] as $language_id => $value) {
			if ((utf8_strlen($value['name']) < 2) || (utf8_strlen($value['name']) > 255)) {
				$this->error['name'][$language_id] = $this->language->get('error_name');
			}

			if ((utf8_strlen($value['meta_title']) < 3) || (utf8_strlen($value['meta_title']) > 255)) {
				$this->error['meta_title'][$language_id] = $this->language->get('error_meta_title');
			}
		}

		if (isset($this->request->get['category_id']) && $this->request->post['parent_id']) {
			$results = $this->model_catalog_category->getCategoryPath($this->request->post['parent_id']);
			
			foreach ($results as $result) {
				if ($result['path_id'] == $this->request->get['category_id']) {
					$this->error['parent'] = $this->language->get('error_parent');
					
					break;
				}
			}
		}

		if (utf8_strlen($this->request->post['keyword']) > 0) {
			$this->load->model('catalog/url_alias');

			$url_alias_info = $this->model_catalog_url_alias->getUrlAlias($this->request->post['keyword']);

			if ($url_alias_info && isset($this->request->get['category_id']) && $url_alias_info['query'] != 'category_id=' . $this->request->get['category_id']) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}

			if ($url_alias_info && !isset($this->request->get['category_id'])) {
				$this->error['keyword'] = sprintf($this->language->get('error_keyword'));
			}
		}
		
		if ($this->error && !isset($this->error['warning'])) {
			$this->error['warning'] = $this->language->get('error_warning');
		}
		
		return !$this->error;
	}

	protected function validateDelete() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	protected function validateRepair() {
		if (!$this->user->hasPermission('modify', 'catalog/category')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}

	public function autocomplete() {
		$json = array();

		if (isset($this->request->get['filter_name'])) {
			$this->load->model('catalog/category');

			$filter_data = array(
				'filter_name' => $this->request->get['filter_name'],
				'sort'        => 'name',
				'order'       => 'ASC',
				'start'       => 0,
				'limit'       => 5
			);

			$results = $this->model_catalog_category->getCategories($filter_data);

			foreach ($results as $result) {
				$json[] = array(
					'category_id' => $result['category_id'],
					'name'        => strip_tags(html_entity_decode($result['name'], ENT_QUOTES, 'UTF-8'))
				);
			}
		}

		$sort_order = array();

		foreach ($json as $key => $value) {
			$sort_order[$key] = $value['name'];
		}

		array_multisort($sort_order, SORT_ASC, $json);

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
