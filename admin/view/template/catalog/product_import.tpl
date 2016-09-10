<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  
		<div class="page-header">
			<div class="container-fluid">
			
			<?php if(!isset($sampletabledata)){ ?>
			  <div class="pull-right"><a href="<?php echo $sampleexport; ?>" data-toggle="tooltip" title="<?php echo $sample_export; ?>" class="btn btn-success"><i class="fa fa-file-excel-o"></i></a> <button class="btn btn-primary" title="" data-toggle="tooltip" form="form" type="submit" name="submit" data-original-title="Save"><i class="fa fa-save"></i></button>
			  </div>
			<?php } ?>  
			  
			  <h1><?php echo $heading_title; ?></h1>
			  <ul class="breadcrumb">
				<?php foreach ($breadcrumbs as $breadcrumb) { ?>
				<li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
				<?php } ?>
			  </ul>
			</div>
		  </div>
  

	<div class="content">
			
			<?php if(isset($sampletabledata)) { 
			
			$product_table_data="";
			
			$product_table_data .="<div class='table-responsive'><table class='table table-bordered table-hover'><thead><tr><td class='text-center'>Product Name</td><td class='text-left'>Model</td><td class='text-left'>Price</td><td class='text-left'>Quantity</td><td class='text-left'>Manufacture Name</td><td class='text-left'>Status</td></tr></thead><tbody>";						
			
			$excel_fields_error = array();
			$product_names = array();
			
			$excel_field_validate = 1;
			
			foreach($sampletabledata as $productdata)
				{		

//print_r($productdata['name']);exit;
foreach($productdata['product_description'] as $langkey => $langval) {
                                if($productdata['status']==1){
									$status="Enable";
								}
								else{
									$status="Disable";
								}
								$product_table_data .="<tr><td class='left'>".$langval['name']."</td><td class='left'>".$productdata['model']."</td><td class='left'>".$productdata['price']."</td><td class='left'>".$productdata['quantity']."</td><td class='left'>".$productdata['manufacturer']."</td><td class='left'>".$status."</td></tr>";
								
								/*if($excel_field_validate)
								{
									if ($langval['name'] == '') { 
										$excel_fields_error['name']="Enter Product Name";
										$excel_field_validate=0;
										}
										
if(in_array($langval['name'],$product_names) && in_array($productdata['product_category'],$product_names))
										{

												$excel_fields_error['product_name_exist']="Don't Repeat same Product and category name";
												$excel_field_validate=0;
												continue;									
										}
										else
										{
											$product_names[] =	$langval['name'];
                                            $product_names[] =	$productdata['product_category'];
										}
}
										
									if ($productdata['model'] == '') { 
										$excel_fields_error['model']="Enter Model Name";
										$excel_field_validate=0;
										}
										
									if ($productdata['categorynames'] == '') { 
										$excel_fields_error['categorynames']="Enter Product Category";
										$excel_field_validate=0;
										}
										
									if (in_array(0,$productdata['product_category'])) { 
										$excel_fields_error['product_category']="Enter Valid Product Category only";
										$excel_field_validate=0;
										}
										
									if ($productdata['quantity'] == '') { 
										$excel_fields_error['quantity']="Enter Product quantity";
										$excel_field_validate=0;
										}
										if ($productdata['price'] == '') { 
										echo "1".$productdata['price']."1";
										}
									if ($productdata['price'] == '') { 
										$excel_fields_error['price']="Enter Product Price";
										$excel_field_validate=0;
										}
										
										
									if ($productdata['stock_status_id'] == 0) { 
										$excel_fields_error['stock_status_id']="Enter Valid Stock Status";
										$excel_field_validate=0;
										}
										
									if ($productdata['manufacturer_id'] == 0) { 
										$excel_fields_error['manufacturer_id']="Enter Valid Manufacturer";
										$excel_field_validate=0;
										}*/
										
								}
								
				}		
						
			$product_table_data .="</tbody></table></div>";
			?>
			 <div class="buttons"> 	
			 <?php if($excel_field_validate) { ?>
			 <a href="<?php echo $importdataurl; ?>" class="button">Publish</a>	
			 <?php } ?>
			 <a href="<?php echo $action; ?>" class="button">Go Back</a>	 
			 </div>
			 
			 <?php if(!$excel_field_validate) { ?>	 
			 <div>
			 </br>
			 <h4>Warning :
			 <?php
			 if(count($excel_fields_error)>0)
			 {
				 foreach($excel_fields_error as $current_error)
				 {
					echo "<span class='error'>".$current_error."</span><br>";
				 }	 
			 }
			 ?>	 
			 </h4>	
			 <h5>Kindly goback then upload valid Excel file only</h5>
			 </div>
			 <?php }  ?>
			 <h4></h4>
			 <?php echo $product_table_data; ?>	 
			 <?php } else { ?>
			  <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			  <table class="table table-bordered table-hover">
				<tr>
					<td>
					<?php echo "Select Upload Opencart Version";?>
					</td>
                                    <td>
				   <select name='opcversion'>
	   				  <option value="">--Select Version--</option>
					 <option value="opc2200">Opencart 2200</option>
					 <option value="opc2302">Opencart 2302</option> 
					  
			          </select> <br>       
 			   <?php if ($error_file_opcversion) { ?>
			   <span class="error"><?php echo $error_file_opcversion; ?></span>
			   <?php } ?>                 
                                   </td>

				</tr>	

			  <tr>
			  <td class="text-left"><?php echo $entry_import; ?></td>
			  <td class="text-left">
			  <input type='file' name='file' />
			   <?php if ($error_file) { ?>
			   <span class="error"><?php echo $error_file; ?></span>
			   <?php } ?>
			   <?php if ($error_fields) { ?>
			   <span class="error"><?php echo $error_fields; ?></span>
			   <?php } ?>
			  </td>
			  </tr>		
			  </table>
			  </form>
			 <?php } ?>
    </div>
  </div>
  <?php echo $footer; ?>
</div>

<style type="text/css">
.button {
text-decoration: none;
color: #FFF;
display: inline-block;
padding: 3px 5px;
background: #003A88;
-webkit-border-radius: 10px 10px 10px 10px;
-moz-border-radius: 10px 10px 10px 10px;
-khtml-border-radius: 10px 10px 10px 10px;
border-radius: 10px 10px 10px 10px;
cursor:pointer;
}

.error
{
	color:red;
}
</style>
