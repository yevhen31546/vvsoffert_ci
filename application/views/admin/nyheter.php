
<div class="admin-content">
  <div class="container">
    <nav class="breadcrumb"> <a class="breadcrumb-item" href="#">Admin</a> <span class="breadcrumb-item active">Nyheter</span> </nav>
    
    <!-- /.stats --> 
    
    <!-- /.box -->
    <div class="box">
      <div class="box-inner">
        <div class="box-title">
          <h2>Nyheter</h2>
        </div>
          <?php $array = $this->session->flashdata('message');
                        if(!empty($array)){ ?>
                           <div class="alert alert-success">
                               <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
  <?php echo $array['content']; ?>
</div> 
                            
                       <?php  $this->session->unset_userdata('message'); } ?>
        <!-- /.box-title -->
        <div class="row">
             
          <div class="col-lg-12"> <?php echo form_open(); ?>
             
            <div class="form-group">
              <label for="exampleTextarea">Content</label>
               <?php
              echo $this->ckeditor->editor("content",$cmsInfo->content);
              ?>
              <?php echo form_error('content') ?>
            </div>
            <div class="form-group">
              <label class="form-check-label">
                <button type="submit" class="btn btn-primary" name="submit" value="save">Submit</button>
              </label>
            </div>
            </form>
          </div>
        </div>
      </div>
      <!-- /.box-inner --> 
    </div>
    <!-- /.cards-wrapper --> 
    
    <!-- /.box --> 
  </div>
  <!-- /.container --> 
</div>
<!-- /.admin-content -->