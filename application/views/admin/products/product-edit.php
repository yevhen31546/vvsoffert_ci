
<div class="admin-content">
  <div class="container">
    <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <a class="breadcrumb-item" href="<?php echo site_url('admin/products'); ?>">Products</a> <span class="breadcrumb-item active"><?php echo $productInfo->Name; ?></span> </nav>
    
    <!-- /.stats --> 
    
    <!-- /.box -->
    <div class="box">
      <div class="box-inner">
      <?php echo form_open_multipart('',['id'=>'product_update_form']); ?>
        <div class="box-title">
          <h2>Product Info : <?php echo $productInfo->Name; ?></h2>
          <div class="pull-right">
              <label class="form-check-label">
                <button type="submit" class="btn btn-success" name="submit" value="save">Save</button>
                <a href="<?php echo site_url('product/'.url_title($productInfo->Name).'-pid-'.$productInfo->id); ?>" class="btn btn-default" target="new"> View In Website</a>
              </label>
            </div>
        </div>
        <!-- /.box-title -->
        <?php show_session_message(); ?>
        <div class="form-group">
              <label>Product Image <span class="required">*</span></label>
              	<div class="thumbnail">            
            		 
             <?php if(file_exists($productInfo->ImageName)){?>
                 <a href="<?php echo site_url($productInfo->ImageName); ?>" target="new"><img src="<?php echo site_url($productInfo->ImageName); ?>" class="img-rounded" alt="<?php echo $productInfo->Name; ?>" style="max-width:100px"></a>
             <?php }else{ ?>
                 <a href="http://www.vvsoffert.se/scraper/<?php echo $productInfo->ImageName; ?>" target="new"><img src="http://www.vvsoffert.se/scraper/<?php echo $productInfo->ImageName; ?>" class="img-rounded" alt="<?php echo $productInfo->Name; ?>" style="max-width:100px"></a>
                 
             <?php }
             ?>
             <input type='file' name='userfile' size='20' />
                </div>
              <span class="text-danger error-msg" id="err_userfile"></span>
            </div>   
        <div class="row">
          <div class="col-lg-6">           	       	
            <div class="form-group">
              <label >Name <span class="required">*</span></label>
              <input type="hidden" class="form-control" name="id" value="<?php echo set_value('id',html_entity_decode($productInfo->id)); ?>">
              <input type="text" class="form-control" name="Name" value="<?php echo set_value('Name',html_entity_decode($productInfo->Name)); ?>">
              <?php echo form_error('Name') ?>
              <span class="text-danger error-msg" id="err_Name"></span>
            </div>
            <div class="form-group">
              <label >Group <span class="required">*</span></label>
              <?php echo form_dropdown('groupName', $groups, set_value('groupName',html_entity_decode($productInfo->groupName)),'class="form-control"'); ?>
              <?php echo form_error('groupName') ?>
              <span class="text-danger error-msg" id="err_groupName"></span>
            </div>
              <div class="form-group">
              <label>Category ID <span class="required">*</span></label>
              <?php echo form_dropdown('category_id', $mainCategory, set_value('category_id',html_entity_decode($productInfo->category_id)),'class="form-control" id="category_id"'); ?>
              <span class="text-danger error-msg" id="err_category_id"></span>
            </div>
            <div class="form-group">
              <label >Category1 <span class="required">*</span></label>
              <?php echo form_dropdown('category1', $mainCategory, set_value('category1',html_entity_decode($productInfo->category1)),'class="form-control" id="category1"'); ?>
              <?php echo form_error('category1') ?>
              <span class="text-danger error-msg" id="err_category1"></span>
            </div>
            <div class="form-group">
              <label >Category2</label>
              <?php echo form_dropdown('category2', $subCategory, set_value('category2',html_entity_decode($productInfo->category2)),'class="form-control" id="category2"'); ?>
              <?php echo form_error('category2') ?>
              <span class="text-danger error-msg" id="err_category2"></span>
            </div>
            <div class="form-group">
              <label >Category3</label>
              <?php echo form_dropdown('category3', $subCategory2, set_value('category3',html_entity_decode($productInfo->category3)),'class="form-control" id="category3"'); ?>
              <?php echo form_error('category3') ?>
              <span class="text-danger error-msg" id="err_category3"></span>
            </div>
            <div class="form-group">
              <label >Manufacturer <span class="required">*</span></label>
              <input type="text" class="form-control" name="Manufacturer" id="Manufacturer" value="<?php echo set_value('Manufacturer',html_entity_decode($ManufacturerInfo->name)); ?>">
              <?php echo form_error('Manufacturer') ?>
              <span class="text-danger error-msg" id="err_Manufacturer"></span>
            </div>
            <div class="form-group">
              <label >ProductType <span class="required">*</span></label>
              <input type="text" class="form-control" name="ProductType" id="ProductType" value="<?php echo set_value('ProductType',html_entity_decode($productTypeInfo->name)); ?>">
              <?php echo form_error('ProductType') ?>
              <span class="text-danger error-msg" id="err_ProductType"></span>
            </div>
            <div style="display: none;" class="form-group">
              <label for="ProductId">ProductId <span class="required">*</span></label>
              <input type="text" class="form-control" name="ProductId" value="<?php echo set_value('ProductId',html_entity_decode($productInfo->ProductId)); ?>">
              <?php echo form_error('ProductId') ?>
              <span class="text-danger error-msg" id="err_ProductId"></span>
            </div>
            <div class="form-group">
              <label >Unit</label>
              <input type="text" class="form-control" name="Unit" value="<?php echo set_value('Unit',html_entity_decode($productInfo->Unit)); ?>">
              <?php echo form_error('Unit') ?>
              <span class="text-danger error-msg" id="err_Unit"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">RSKnummer0 <span class="required">*</span></label>
              <input type="text" class="form-control" name="RSKnummer0" value="<?php echo set_value('RSKnummer0',html_entity_decode($productInfo->RSKnummer0)); ?>">
              <?php echo form_error('RSKnummer0') ?>
              <span class="text-danger error-msg" id="err_RSKnummer0"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Tillverkarensartikelnummer0</label>
              <input type="text" class="form-control" name="Tillverkarensartikelnummer0" value="<?php echo set_value('Tillverkarensartikelnummer0',html_entity_decode($productInfo->Tillverkarensartikelnummer0)); ?>">
              <?php echo form_error('Tillverkarensartikelnummer0') ?>
              <span class="text-danger error-msg" id="err_Tillverkarensartikelnummer0"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">RSKnummer <span class="required">*</span></label>
              <input type="text" class="form-control" name="RSKnummer" value="<?php echo set_value('RSKnummer',html_entity_decode($productInfo->RSKnummer)); ?>">
              <?php echo form_error('RSKnummer') ?>
              <span class="text-danger error-msg" id="err_RSKnummer"></span>
            </div>
            <div class="form-group">
              <label for="exampleTextarea">Tillverkarensartikelnummer</label>
              <input class="form-control" rows="3" name="Tillverkarensartikelnummer" value="<?php echo set_value('Tillverkarensartikelnummer',html_entity_decode($productInfo->Tillverkarensartikelnummer)); ?>">
              <?php echo form_error('Tillverkarensartikelnummer') ?>
              <span class="text-danger error-msg" id="err_Tillverkarensartikelnummer"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">GTIN</label>
              <input type="text" class="form-control" name="GTIN" value="<?php echo set_value('GTIN',html_entity_decode($productInfo->GTIN)); ?>">
              <?php echo form_error('GTIN') ?>
              <span class="text-danger error-msg" id="err_GTIN"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Produkt</label>
              <input type="text" class="form-control" name="Produkt" value="<?php echo set_value('Produkt',html_entity_decode($productInfo->Produkt)); ?>">
              <?php echo form_error('Produkt') ?>
              <span class="text-danger error-msg" id="err_Produkt"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Produktnamn</label>
              <input type="text" class="form-control" name="Produktnamn" value="<?php echo set_value('Produktnamn',html_entity_decode($productInfo->Produktnamn)); ?>">
              <?php echo form_error('Produktnamn') ?>
              <span class="text-danger error-msg" id="err_Produktnamn"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Dimension</label>
              <input type="text" class="form-control" name="Dimension" value="<?php echo set_value('RSKDimensionnummer',html_entity_decode($productInfo->Dimension)); ?>">
              <?php echo form_error('Dimension') ?>
              <span class="text-danger error-msg" id="err_Dimension"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Storlek</label>
              <input type="text" class="form-control" name="Storlek" value="<?php echo set_value('Storlek',html_entity_decode($productInfo->Storlek)); ?>">
              <?php echo form_error('Storlek') ?>
              <span class="text-danger error-msg" id="err_Storlek"></span>
            </div>                                    
          </div>
          <div class="col-lg-6"> <?php // echo form_open(); ?>          	
            <div class="form-group">
              <label for="exampleInputPassword1">TryckFlodeTemp</label>
              <input type="text" class="form-control" name="TryckFlodeTemp" value="<?php echo set_value('TryckFlodeTemp',html_entity_decode($productInfo->TryckFlodeTemp)); ?>">
              <?php echo form_error('TryckFlodeTemp') ?>
              <span class="text-danger error-msg" id="err_TryckFlodeTemp"></span>
            </div><div class="form-group">
              <label for="exampleInputPassword1">EffektEldata</label>
              <input type="text" class="form-control" name="EffektEldata" value="<?php echo set_value('EffektEldata',html_entity_decode($productInfo->EffektEldata)); ?>">
              <?php echo form_error('EffektEldata') ?>
              <span class="text-danger error-msg" id="err_EffektEldata"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Funktion</label>
              <input type="text" class="form-control" name="Funktion" value="<?php echo set_value('Funktion',html_entity_decode($productInfo->Funktion)); ?>">
              <?php echo form_error('Funktion') ?>
              <span class="text-danger error-msg" id="err_Funktion"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Utforande</label>
              <input type="text" class="form-control" name="Utforande" value="<?php echo set_value('Utforande',html_entity_decode($productInfo->Utforande)); ?>">
              <?php echo form_error('Utforande') ?>
              <span class="text-danger error-msg" id="err_Utforande"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Farg</label>
              <input type="text" class="form-control" name="Farg" value="<?php echo set_value('Farg',html_entity_decode($productInfo->Farg)); ?>">
              <?php echo form_error('Farg') ?>
              <span class="text-danger error-msg" id="err_Farg"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Ytbehandling</label>
              <input type="text" class="form-control" name="Ytbehandling" value="<?php echo set_value('Ytbehandling',html_entity_decode($productInfo->Ytbehandling)); ?>">
              <?php echo form_error('Ytbehandling') ?>
              <span class="text-danger error-msg" id="err_Ytbehandling"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Material</label>
              <input type="text" class="form-control" name="Material" value="<?php echo set_value('Material',html_entity_decode($productInfo->Material)); ?>">
              <?php echo form_error('Material') ?>
              <span class="text-danger error-msg" id="err_Material"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Standard</label>
              <input type="text" class="form-control" name="Standard" value="<?php echo set_value('Standard',html_entity_decode($productInfo->Standard)); ?>">
              <?php echo form_error('Standard') ?>
              <span class="text-danger error-msg" id="err_Standard"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Ovriginfo</label>
              <input type="text" class="form-control" name="Ovriginfo" value="<?php echo set_value('Ovriginfo',html_entity_decode($productInfo->Ovriginfo)); ?>">
              <?php echo form_error('Ovriginfo') ?>
              <span class="text-danger error-msg" id="err_Ovriginfo"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">EgenbenamningSvensk</label>
              <input type="text" class="form-control" name="EgenbenamningSvensk" value="<?php echo set_value('EgenbenamningSvensk',html_entity_decode($productInfo->EgenbenamningSvensk)); ?>">
              <?php echo form_error('EgenbenamningSvensk') ?>
              <span class="text-danger error-msg" id="err_EgenbenamningSvensk"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Ersattav</label>
              <input type="text" class="form-control" name="Funktion" value="<?php echo set_value('Ersattav',html_entity_decode($productInfo->Ersattav)); ?>">
              <?php echo form_error('Ersattav') ?>
              <span class="text-danger error-msg" id="err_Ersattav"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Varumarke</label>
              <input type="text" class="form-control" name="Varumarke" value="<?php echo set_value('Varumarke',html_entity_decode($productInfo->Varumarke)); ?>">
              <?php echo form_error('Varumarke') ?>
              <span class="text-danger error-msg" id="err_Varumarke"></span>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Tillverkarensproduktsida</label>
              <input type="text" class="form-control" name="Tillverkarensproduktsida" value="<?php echo set_value('Tillverkarensproduktsida',$productInfo->Tillverkarensproduktsida); ?>">
              <?php echo form_error('Tillverkarensproduktsida') ?>
              <span class="text-danger error-msg" id="err_Tillverkarensproduktsida"></span>
            </div> 
              
              <div class="form-group">
                            <label for="exampleInputPassword1">Markera som populär produkt</label>
                            <div class="checkbox">

                                <input type="checkbox" value="1" name="markera_populer" <?php echo ($productInfo->markera_populer == 1)? "checked":""; ?> >Yes</label>
                            </div>
                            <?php echo form_error('markera_populer') ?>
                            <span class="text-danger error-msg" id="err_markera_populer"></span>
                        </div> 
          </div>
        </div>
        <?php echo form_close(); ?>
      </div>
      <!-- /.box-inner --> 
    </div>
    <!-- /.cards-wrapper --> 
    
    <!-- /.box --> 
  </div>
  <!-- /.container --> 
</div>
<!-- /.admin-content -->