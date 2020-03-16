<div class="admin-content">
  <div class="container">
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="<?= site_url('admin/dashboard'); ?>">Admin</a> <span class="breadcrumb-item active">Plumbing Cost Calculator</span>
    </nav>
    
    <!-- /.stats --> 
    <?php show_session_message(); ?>
    <!-- /.box -->
    <div class="box">
      <div class="box-inner">
        <div class="box-title">
          <h2>Plumbing Services</h2>
          <div class="pull-right">
            <a class="btn btn-default" href="<?php echo site_url('admin/calculator/add_service'); ?>"><i class="fa fa-plus"></i>New Service</a>
          </div>
        </div>
        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>                    
                        <th class="min-width center">#</th>
                        <th>SERVICE TITLE</th>
                        <th class="center" width="30"></th>                  
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $slno = 1;
                    foreach ($all_plumbing_services as $ps) {
                        ?>
                        <tr>                    
                            <td class="min-width center id"><?php echo $slno++; ?></td>
                            <td> 
                                <?= $ps['title']; ?>
                            </td>  
                            <td class="">
                                <a class="" href="<?php echo site_url('admin/calculator/edit_service/' . $ps['id']); ?>" title="Edit Service"><i class="fa fa-edit"></i></a>

                                <a class="" href="<?php echo site_url('admin/calculator/delete_service/' . $ps['id']); ?>" title="Delete Service"><i class="fa fa-trash-o"></i></a>
                            </td>               
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
      </div>
    </div>

    <div class="box">
      <div class="box-inner">
        <div class="box-title">
          <h2>Plumbing Service Prices</h2>
          <div class="pull-right">
            <a class="btn btn-default" href="<?php echo site_url('admin/calculator/add_price'); ?>"><i class="fa fa-plus"></i>New Service Price</a>
          </div>
        </div>
        <div class="table-wrapper">
            <table class="table table-bordered">
                <thead>
                    <tr>                    
                        <th class="min-width center">#</th>
                        <th>SERVICE</th>
                        <th>RSK NUMBER</th>
                        <th>JOB TITLE</th>
                        <th>JOB DESCRIPTION</th>
                        <th>TIME</th>
                        <th>PRICE</th>
                        <th class="center" width="30"></th>                  
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $slno = 1;
                    foreach ($all_plumbing_service_prices as $psp) {
                        ?>
                        <tr>                    
                            <td class="min-width center id"><?php echo $slno++; ?></td>
                            <td>
                                <?= $psp['serviceTitle']; ?>
                            </td>
                            <td>
                                <?= $psp['rskNumber']; ?>
                            </td>
                            <td>
                                <?= $psp['jobTitle']; ?>
                            </td>
                            <td>
                                <?= $psp['jobDescription']; ?>
                            </td>
                            <td>
                                <?= $psp['time']; ?>
                            </td>
                            <td>
                                <?= $psp['price']; ?>
                            </td>
                            <td class="">
                                <a class="" href="<?php echo site_url('admin/calculator/edit_price/' . $psp['id']); ?>" title="Edit Price"><i class="fa fa-edit"></i></a>

                                <a class="" href="<?php echo site_url('admin/calculator/delete_price/' . $psp['id']); ?>" title="Delete Price"><i class="fa fa-trash-o"></i></a>
                            </td>               
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
      </div>
    </div>

  </div>
</div>