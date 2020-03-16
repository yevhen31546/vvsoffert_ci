<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <a class="breadcrumb-item" href="<?php echo site_url('admin/products'); ?>">Products</a> <span class="breadcrumb-item active"><?php // echo $productInfo->Name;  ?></span> </nav>

        <!-- /.stats --> 

        <!-- /.box -->
        <div class="box">
            <div class="box-inner">
                <?php echo form_open_multipart('', ['id' => 'product_add_form']); ?>
                <div class="box-title">
                    <h2>Product Add:</h2>
                    <div class="pull-right">
                        <label class="form-check-label">
                            <button type="submit" class="btn btn-success" name="submit" value="save">Save</button>
                        </label>
                    </div>
                </div>
                <!-- /.box-title -->
                <?php show_session_message(); ?>
                <div class="form-group">
                    <label>Product Image <span class="required">*</span></label>
                    <div class="thumbnail">            
                             <!--<a href="http://www.vvsoffert.se/scraper/<?php // echo $productInfo->ImageName;  ?>" target="new"><img src="http://www.vvsoffert.se/scraper/<?php // echo $productInfo->ImageName;  ?>" class="img-rounded" alt="<?php // echo $productInfo->Name;  ?>" style="max-width:100px"></a>-->

<!--<input type='file' name='ImageName' size='20' />-->
                        <input type='file' name='userfile' size='20' />
                    </div>
                    <span class="text-danger error-msg" id="err_userfile"></span>
                </div>   
                <div class="row">
                    <div class="col-lg-6">           	       	
                        <div class="form-group">
                            <label >Name <span class="required">*</span></label>
                            <input type="text" class="form-control" name="Name" value="">
                            <span class="text-danger error-msg" id="err_Name"></span>
                            <?php // echo form_error('Name') ?>
                        </div>
                        <div class="form-group">
                            <label >Group <span class="required">*</span></label>
                            <?php echo form_dropdown('groupName', $groups, set_value('groupName'), 'class="form-control"'); ?>
                            <span class="text-danger error-msg" id="err_groupName"></span>
                        </div>
                        <div class="form-group">
                            <label>Category ID <span class="required">*</span></label>
                            <?php echo form_dropdown('category_id', $mainCategory, set_value('category_id'), 'class="form-control" id="category_id"'); ?>
                            <span class="text-danger error-msg" id="err_category_id"></span>
                        </div>
                        <div class="form-group">
                            <label>Category1 <span class="required">*</span></label>
                            <?php echo form_dropdown('category1', $mainCategory, set_value('category1'), 'class="form-control" id="category1"'); ?>
                            <span class="text-danger error-msg" id="err_category1"></span>
                        </div>
                        <div class="form-group">
                            <label >Category2</label>
                            <?php echo form_dropdown('category2', $subCategory, set_value('category2'), 'class="form-control" id="category2"'); ?>
                            <span class="text-danger error-msg" id="err_category2"></span>
                        </div>
                        <div class="form-group">
                            <label >Category3</label>
                            <?php echo form_dropdown('category3', $subCategory2, set_value('category3'), 'class="form-control" id="category3"'); ?>
                            <span class="text-danger error-msg" id="err_category3"></span>
                        </div>
                        <div class="form-group">
                            <label >Manufacturer <span class="required">*</span></label>
                            <input type="text" class="form-control" name="Manufacturer" id="Manufacturer" value="<?php echo set_value('Manufacturer'); ?>">
                            <span class="text-danger error-msg" id="err_Manufacturer"></span>
                        </div>
                        <div class="form-group">
                            <label >ProductType <span class="required">*</span></label>
                            <input type="text" class="form-control" name="ProductType" id="ProductType" value="<?php echo set_value('ProductType'); ?>">
                            <span class="text-danger error-msg" id="err_ProductType"></span>
                        </div>
                        <div style="display: none;" class="form-group">
                            <label for="ProductId">ProductId <span class="required">*</span></label>
                            <input type="text" class="form-control" name="ProductId" value="000000">
                            <span class="text-danger error-msg" id="err_ProductId"></span>
                        </div>
                        <div class="form-group">
                            <label >Unit</label>
                            <input type="text" class="form-control" name="Unit" value="<?php echo set_value('Unit'); ?>">
                            <span class="text-danger error-msg" id="err_Unit"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">RSKnummer0 <span class="required">*</span></label>
                            <input type="text" class="form-control" name="RSKnummer0" value="<?php echo set_value('RSKnummer0'); ?>">
                            <span class="text-danger error-msg" id="err_RSKnummer0"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tillverkarensartikelnummer0</label>
                            <input type="text" class="form-control" name="Tillverkarensartikelnummer0" value="<?php echo set_value('Tillverkarensartikelnummer0'); ?>">
                            <span class="text-danger error-msg" id="err_Tillverkarensartikelnummer0"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">RSKnummer <span class="required">*</span></label>
                            <input type="text" class="form-control" name="RSKnummer" value="<?php echo set_value('RSKnummer'); ?>">
                            <span class="text-danger error-msg" id="err_RSKnummer"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleTextarea">Tillverkarensartikelnummer</label>
                            <input class="form-control" rows="3" name="Tillverkarensartikelnummer" value="<?php echo set_value('Tillverkarensartikelnummer'); ?>">
                            <span class="text-danger error-msg" id="err_Tillverkarensartikelnummer"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">GTIN</label>
                            <input type="text" class="form-control" name="GTIN" value="<?php echo set_value('GTIN'); ?>">
                            <span class="text-danger error-msg" id="err_GTIN"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Produkt</label>
                            <input type="text" class="form-control" name="Produkt" value="<?php echo set_value('Produkt'); ?>">
                            <span class="text-danger error-msg" id="err_Produkt"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Produktnamn</label>
                            <input type="text" class="form-control" name="Produktnamn" value="<?php echo set_value('Produktnamn'); ?>">
                            <span class="text-danger error-msg" id="err_Produktnamn"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Dimension</label>
                            <input type="text" class="form-control" name="Dimension" value="<?php echo set_value('RSKDimensionnummer'); ?>">
                            <span class="text-danger error-msg" id="err_Dimension"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Storlek</label>
                            <input type="text" class="form-control" name="Storlek" value="<?php echo set_value('Storlek'); ?>">
                            <span class="text-danger error-msg" id="err_Storlek"></span>
                        </div>                                    
                    </div>
                    <div class="col-lg-6"> <?php // echo form_open();  ?>          	
                        <div class="form-group">
                            <label for="exampleInputPassword1">TryckFlodeTemp</label>
                            <input type="text" class="form-control" name="TryckFlodeTemp" value="<?php echo set_value('TryckFlodeTemp'); ?>">
                            <span class="text-danger error-msg" id="err_TryckFlodeTemp"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">EffektEldata</label>
                            <input type="text" class="form-control" name="EffektEldata" value="<?php echo set_value('EffektEldata'); ?>">
                            <span class="text-danger error-msg" id="err_EffektEldata"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Funktion</label>
                            <input type="text" class="form-control" name="Funktion" value="<?php echo set_value('Funktion'); ?>">
                            <span class="text-danger error-msg" id="err_Funktion"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Utforande</label>
                            <input type="text" class="form-control" name="Utforande" value="<?php echo set_value('Utforande'); ?>">
                            <span class="text-danger error-msg" id="err_Utforande"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Farg</label>
                            <input type="text" class="form-control" name="Farg" value="<?php echo set_value('Farg'); ?>">
                            <span class="text-danger error-msg" id="err_Farg"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ytbehandling</label>
                            <input type="text" class="form-control" name="Ytbehandling" value="<?php echo set_value('Ytbehandling'); ?>">
                            <span class="text-danger error-msg" id="err_Ytbehandling"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Material</label>
                            <input type="text" class="form-control" name="Material" value="<?php echo set_value('Material'); ?>">
                            <span class="text-danger error-msg" id="err_Material"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Standard</label>
                            <input type="text" class="form-control" name="Standard" value="<?php echo set_value('Standard'); ?>">
                            <span class="text-danger error-msg" id="err_Standard"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ovriginfo</label>
                            <input type="text" class="form-control" name="Ovriginfo" value="<?php echo set_value('Ovriginfo'); ?>">
                            <span class="text-danger error-msg" id="err_Ovriginfo"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">EgenbenamningSvensk</label>
                            <input type="text" class="form-control" name="EgenbenamningSvensk" value="<?php echo set_value('EgenbenamningSvensk'); ?>">
                            <span class="text-danger error-msg" id="err_EgenbenamningSvensk"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Ersattav</label>
                            <input type="text" class="form-control" name="Funktion" value="<?php echo set_value('Ersattav'); ?>">
                            <span class="text-danger error-msg" id="err_Ersattav"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Varumarke</label>
                            <input type="text" class="form-control" name="Varumarke" value="<?php echo set_value('Varumarke'); ?>">
                            <span class="text-danger error-msg" id="err_Varumarke"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Tillverkarensproduktsida</label>
                            <input type="text" class="form-control" name="Tillverkarensproduktsida" value="<?php echo set_value('Tillverkarensproduktsida'); ?>">
                            <?php echo form_error('Tillverkarensproduktsida') ?>
                            <span class="text-danger error-msg" id="err_Tillverkarensproduktsida"></span>
                        </div>           
                        <div class="form-group">
                            <label for="exampleInputPassword1">Markera som populär produkt</label>
                            <div class="checkbox">

                                <input type="checkbox" value="1" name="markera_populer" <?php echo (set_value('markera_populer') == 1)? "checked":""; ?> >Yes</label>
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