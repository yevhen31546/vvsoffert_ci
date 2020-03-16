
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <a class="breadcrumb-item" href="<?php echo site_url('admin/users'); ?>">Users</a> <span class="breadcrumb-item active"><?php echo $userInfo->name; ?></span> </nav>

        <!-- /.stats --> 

        <!-- /.box -->
        <div class="box">
            <div class="box-inner">
                <?php echo form_open('', ['id' => 'user_update_form']); ?>
                <div class="box-title">
                    <h2>User Info : <?php echo $userInfo->name . " " . $userInfo->last_name; ?></h2>
                    <div class="pull-right">
                        <label class="form-check-label">
                            <button type="submit" class="btn btn-success" name="submit" value="save">Save</button>
                        </label>
                    </div>
                </div>
                <!-- /.box-title -->
                <?php show_session_message(); ?>

                <div class="row">
                    <div class="col-lg-6">           	       	
                        <div class="form-group">
                            <label >Förnamn <span class="required">*</span></label>
                            <input type="hidden" class="form-control" name="user_id" value="<?php echo set_value('user_id', html_entity_decode($userInfo->user_id)); ?>">
                            <input type="text" class="form-control" name="name" value="<?php echo set_value('name', html_entity_decode($userInfo->name)); ?>">
                            <?php echo form_error('name') ?>
                            <span class="text-danger error-msg" id="err_name"></span>
                        </div>
                        <div class="form-group">
                            <label >E-post <span class="required">*</span></label>
                            <input type="text" class="form-control" name="email" value="<?php echo set_value('email', html_entity_decode($userInfo->email)); ?>">
                            <?php echo form_error('email') ?>
                            <span class="text-danger error-msg" id="err_email"></span>
                        </div>
                        <div class="form-group">
                            <label>Kontakt <span class="required"></span></label>
                            <input type="text" class="form-control" name="contact" value="<?php echo set_value('contact', html_entity_decode($userInfo->contact)); ?>">
                            <?php echo form_error('contact') ?>
                            <span class="text-danger error-msg" id="err_contact"></span>
                        </div>
                        <div class="form-group">
                            <label >Företag <span class="required">*</span></label>
                            <input type="text" class="form-control" name="company_name" value="<?php echo set_value('company_name', html_entity_decode($userInfo->company_name)); ?>">
                            <?php echo form_error('company_name') ?>
                            <span class="text-danger error-msg" id="err_company_name"></span>
                        </div>                                  
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1">Efternamn <span class="required">*</span></label>
                            <input type="text" class="form-control" name="last_name" value="<?php echo set_value('last_name', html_entity_decode($userInfo->last_name)); ?>">
                            <?php echo form_error('last_name') ?>
                            <span class="text-danger error-msg" id="err_last_name"></span>
                        </div><div class="form-group">
                            <label for="exampleInputPassword1">Lösenord</label>
                            <input type="password" class="form-control" name="password">
                            <?php echo form_error('password') ?>
                            <span class="text-danger error-msg" id="err_password"></span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Org Nummer <span class="required">*</span></label>
                            <input type="text" class="form-control" name="org_no" value="<?php echo set_value('org_no', html_entity_decode($userInfo->org_no)); ?>">
                            <?php echo form_error('org_no') ?>
                            <span class="text-danger error-msg" id="err_org_no"></span>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">Kund Status<span class="required">*</span></label>
                            <div class="radio">
                                <?php if (($userInfo->status == 0)) : ?>
                                    <label><input type="radio" value="1" name="status" <?php echo ($userInfo->status == 1) ? "checked" : ""; ?>>Aktiv</label>
                                    <label><input type="radio" value="0" name="status" <?php echo ($userInfo->status == 0) ? "checked" : ""; ?>>Inte aktiv</label>
                                <?php else : ?>
                                    <label><input type="radio" value="1" name="status" <?php echo ($userInfo->status == 1) ? "checked" : ""; ?>>Aktiv</label>
                                    <label><input type="radio" value="2" name="status" <?php echo ($userInfo->status == 2) ? "checked" : ""; ?>>Blockera</label>
                                <?php endif; ?>
                            </div>
                            <?php echo form_error('org_no') ?>
                            <span class="text-danger error-msg" id="err_org_no"></span>
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