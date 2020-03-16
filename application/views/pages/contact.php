<?php
$array = $this->session->flashdata('message');
if (!empty($array)) {
    ?>
    <div class="alert alert-success">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        <strong>Framgång!</strong> <?php echo $array['content']; ?>
    </div> 

    <?php
    $this->session->unset_userdata('message');
}
?>
<div class="signup_screen">
    <h2 class="screen_title">Kontakta oss</h2> 
    <div class="signup_form">
        
       <?php echo form_open(); ?>
            <div class="form-group col-xs-12 col-sm-6">
                <div class="icon-addon">
                    <input type="text" placeholder="Förnamn" class="form-control" value="<?php echo set_value('name'); ?>" id="name" name="name" autocomplete="off">
                    <label for="name" class="fa fa-user" rel="tooltip" title="Förnamn"></label>
                </div>
                <span class="text-danger error-msg" ><?php echo form_error('name') ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-6">
                <div class="icon-addon">
                    <input type="text" placeholder="Efternamn" class="form-control" value="<?php echo set_value('last_name'); ?>" id="last_name" name="last_name" autocomplete="off">
                    <label for="email" class="fa fa-user" rel="tooltip" title="Efternamn"></label>
                </div>
                <span class="text-danger error-msg" id="err_last_name"><?php echo form_error('last_name') ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="text" placeholder="Telefon" class="form-control" value="<?php echo set_value('contact'); ?>" id="contact" name="contact" autocomplete="off">
                    <label for="email" class="fa fa-phone" rel="tooltip" title="Telefon"></label>
                </div>
                <span class="text-danger error-msg" id="err_contact"><?php echo form_error('contact') ?></span>
            </div>
            <div class="form-group col-xs-12 col-sm-12">
                <div class="icon-addon">
                    <input type="text" placeholder="E-post" class="form-control" value="<?php echo set_value('email'); ?>" id="email" name="email" autocomplete="off">
                    <label for="email" class="fa fa-envelope" rel="tooltip" title="E-post"></label>
                </div>
                <span class="text-danger error-msg" id="err_email"><?php echo form_error('email') ?></span>
            </div>


            <div class="form-group col-xs-12 col-sm-12 ">
                <div class="icon-addon">
                    <textarea placeholder="Meddelande" rows="10" class="form-control" id="message" name="message" autocomplete="off"><?php echo set_value('message'); ?></textarea>
                    <label for="message" class="fa fa-industry" rel="tooltip" title="Företagsnamn"></label>
                </div>
                <span class="text-danger error-msg" id="err_message"><?php echo form_error('message') ?></span>
            </div>

            <div class="form-group text-center account_btn">
                <input type="submit" name="submit" id="sbmt" class="reg-btn" value="Skicka">
            </div>
            <div class="clearfix"></div>
        </form>
    </div>   	
</div>