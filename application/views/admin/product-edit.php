
<div class="admin-content">
  <div class="container">
    <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <a class="breadcrumb-item" href="<?php echo site_url('admin/products'); ?>">Products</a> <span class="breadcrumb-item active"><?php echo $productInfo->Name; ?></span> </nav>
    
    <!-- /.stats --> 
    
    <!-- /.box -->
    <div class="box">
      <div class="box-inner">
      <?php echo form_open(); ?>
        <div class="box-title">
          <h2>Product Info : <?php echo $productInfo->Name; ?></h2>
          <div class="pull-right">
              <label class="form-check-label">
                <button type="submit" class="btn btn-success" name="submit" value="save">Save</button>
                <button type="submit" class="btn btn-primary" name="delete" id="deleteProduct" value="delete">Delete</button>
                <a href="<?php echo site_url('admin/products/new'); ?>" class="btn btn-default" target="new"> Add New Product</a>
                <a href="<?php echo site_url('product?pname='.url_title($productInfo->Name).'&no='.$productInfo->id); ?>" class="btn btn-default" target="new"> View In Website</a>
              </label>
            </div>
        </div>
        <!-- /.box-title -->
        <?php show_session_message(); ?>
        <div class="form-group">
              <label>Product Image</label>
              	<div class="thumbnail">            
            		 <a href="http://www.vvsoffert.se/scraper/<?php echo $productInfo->ImageName; ?>" target="new"><img src="http://www.vvsoffert.se/scraper/<?php echo $productInfo->ImageName; ?>" class="img-rounded" alt="<?php echo $productInfo->Name; ?>" style="max-width:100px"></a>
             </div>
              <?php echo form_error('Name') ?>
            </div>   
        <div class="row">
          <div class="col-lg-6">           	       	
            <div class="form-group">
              <label >Name</label>
              <input type="text" class="form-control" name="Name" value="<?php echo set_value('Name',html_entity_decode($productInfo->Name)); ?>">
              <?php echo form_error('Name') ?>
            </div>
            <div class="form-group">
              <label >Group</label>
              <?php echo form_dropdown('groupName', $groups, set_value('groupName',html_entity_decode($productInfo->groupName)),'class="form-control"'); ?>
              <?php echo form_error('groupName') ?>
            </div>
            <div class="form-group">
              <label >Category1</label>
              <?php echo form_dropdown('category1', $mainCategory, set_value('category1',html_entity_decode($productInfo->category1)),'class="form-control" id="category1"'); ?>
              <?php echo form_error('category1') ?>
            </div>
            <div class="form-group">
              <label >Category2</label>
              <?php echo form_dropdown('category2', $subCategory, set_value('category2',html_entity_decode($productInfo->category2)),'class="form-control" id="category2"'); ?>
              <?php echo form_error('category2') ?>
            </div>
            <div class="form-group">
              <label >Category3</label>
              <?php echo form_dropdown('category3', $subCategory2, set_value('category3',html_entity_decode($productInfo->category3)),'class="form-control" id="category3"'); ?>
              <?php echo form_error('category3') ?>
            </div>
            <div class="form-group">
              <label >Manufacturer</label>
              <input type="text" class="form-control" name="Manufacturer" id="Manufacturer" value="<?php echo set_value('Manufacturer',html_entity_decode($ManufacturerInfo->name)); ?>">
              <?php echo form_error('Manufacturer') ?>
            </div>
            <div class="form-group">
              <label >ProductType</label>
              <input type="text" class="form-control" name="ProductType" id="ProductType" value="<?php echo set_value('ProductType',html_entity_decode($productTypeInfo->name)); ?>">
              <?php echo form_error('ProductType') ?>
            </div>
            <div class="form-group">
              <label for="ProductId">ProductId</label>
              <input type="text" class="form-control" name="ProductId" value="<?php echo set_value('ProductId',html_entity_decode($productInfo->ProductId)); ?>">
              <?php echo form_error('ProductId') ?>
            </div>
            <div class="form-group">
              <label >Unit</label>
              <input type="text" class="form-control" name="Unit" value="<?php echo set_value('Unit',html_entity_decode($productInfo->Unit)); ?>">
              <?php echo form_error('Unit') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">RSKnummer0</label>
              <input type="text" class="form-control" name="RSKnummer0" value="<?php echo set_value('RSKnummer0',html_entity_decode($productInfo->RSKnummer0)); ?>">
              <?php echo form_error('RSKnummer0') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Tillverkarensartikelnummer0</label>
              <input type="text" class="form-control" name="Tillverkarensartikelnummer0" value="<?php echo set_value('Tillverkarensartikelnummer0',html_entity_decode($productInfo->Tillverkarensartikelnummer0)); ?>">
              <?php echo form_error('Tillverkarensartikelnummer0') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">RSKnummer</label>
              <input type="text" class="form-control" name="RSKnummer" value="<?php echo set_value('RSKnummer',html_entity_decode($productInfo->RSKnummer)); ?>">
              <?php echo form_error('RSKnummer') ?>
            </div>
            <div class="form-group">
              <label for="exampleTextarea">Tillverkarensartikelnummer</label>
              <input class="form-control" rows="3" name="Tillverkarensartikelnummer" value="<?php echo set_value('Tillverkarensartikelnummer',html_entity_decode($productInfo->Tillverkarensartikelnummer)); ?>">
              <?php echo form_error('Tillverkarensartikelnummer') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">GTIN</label>
              <input type="text" class="form-control" name="GTIN" value="<?php echo set_value('GTIN',html_entity_decode($productInfo->GTIN)); ?>">
              <?php echo form_error('GTIN') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Produkt</label>
              <input type="text" class="form-control" name="Produkt" value="<?php echo set_value('Produkt',html_entity_decode($productInfo->Produkt)); ?>">
              <?php echo form_error('Produkt') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Produktnamn</label>
              <input type="text" class="form-control" name="Produktnamn" value="<?php echo set_value('Produktnamn',html_entity_decode($productInfo->Produktnamn)); ?>">
              <?php echo form_error('Produktnamn') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Dimension</label>
              <input type="text" class="form-control" name="Dimension" value="<?php echo set_value('RSKDimensionnummer',html_entity_decode($productInfo->Dimension)); ?>">
              <?php echo form_error('Dimension') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Storlek</label>
              <input type="text" class="form-control" name="Storlek" value="<?php echo set_value('Storlek',html_entity_decode($productInfo->Storlek)); ?>">
              <?php echo form_error('Storlek') ?>
            </div>                                    
          </div>
          <div class="col-lg-6"> <?php echo form_open(); ?>          	
            <div class="form-group">
              <label for="exampleInputPassword1">TryckFlodeTemp</label>
              <input type="text" class="form-control" name="TryckFlodeTemp" value="<?php echo set_value('TryckFlodeTemp',html_entity_decode($productInfo->TryckFlodeTemp)); ?>">
              <?php echo form_error('TryckFlodeTemp') ?>
            </div><div class="form-group">
              <label for="exampleInputPassword1">EffektEldata</label>
              <input type="text" class="form-control" name="EffektEldata" value="<?php echo set_value('EffektEldata',html_entity_decode($productInfo->EffektEldata)); ?>">
              <?php echo form_error('EffektEldata') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Funktion</label>
              <input type="text" class="form-control" name="Funktion" value="<?php echo set_value('Funktion',html_entity_decode($productInfo->Funktion)); ?>">
              <?php echo form_error('Funktion') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Utforande</label>
              <input type="text" class="form-control" name="Utforande" value="<?php echo set_value('Utforande',html_entity_decode($productInfo->Utforande)); ?>">
              <?php echo form_error('Utforande') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Farg</label>
              <input type="text" class="form-control" name="Farg" value="<?php echo set_value('Farg',html_entity_decode($productInfo->Farg)); ?>">
              <?php echo form_error('Farg') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Ytbehandling</label>
              <input type="text" class="form-control" name="Ytbehandling" value="<?php echo set_value('Ytbehandling',html_entity_decode($productInfo->Ytbehandling)); ?>">
              <?php echo form_error('Ytbehandling') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Material</label>
              <input type="text" class="form-control" name="Material" value="<?php echo set_value('Material',html_entity_decode($productInfo->Material)); ?>">
              <?php echo form_error('Material') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Standard</label>
              <input type="text" class="form-control" name="Standard" value="<?php echo set_value('Standard',html_entity_decode($productInfo->Standard)); ?>">
              <?php echo form_error('Standard') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Ovriginfo</label>
              <input type="text" class="form-control" name="Ovriginfo" value="<?php echo set_value('Ovriginfo',html_entity_decode($productInfo->Ovriginfo)); ?>">
              <?php echo form_error('Ovriginfo') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">EgenbenamningSvensk</label>
              <input type="text" class="form-control" name="EgenbenamningSvensk" value="<?php echo set_value('EgenbenamningSvensk',html_entity_decode($productInfo->EgenbenamningSvensk)); ?>">
              <?php echo form_error('EgenbenamningSvensk') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Ersattav</label>
              <input type="text" class="form-control" name="Funktion" value="<?php echo set_value('Ersattav',html_entity_decode($productInfo->Ersattav)); ?>">
              <?php echo form_error('Ersattav') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Varumarke</label>
              <input type="text" class="form-control" name="Varumarke" value="<?php echo set_value('Varumarke',html_entity_decode($productInfo->Varumarke)); ?>">
              <?php echo form_error('Varumarke') ?>
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Tillverkarensproduktsida</label>
              <input type="text" class="form-control" name="Tillverkarensproduktsida" value="<?php echo set_value('Tillverkarensproduktsida',$productInfo->Tillverkarensproduktsida); ?>">
              <?php echo form_error('Tillverkarensproduktsida') ?>
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