 
<div class="admin-content">
    <div class="container">
        <nav class="breadcrumb"> 
            <a class="breadcrumb-item" href="#">Admin</a> <span class="breadcrumb-item active">Kunder</span>
            <div class="pull-right">
<!--                <a href="<?php // echo site_url('admin/products/add'); ?>" class="btn btn-default btn-info" target="new">Add New User</a>-->
            </div>
        </nav>
        <div class="table-header clearfix">
            <form id="user_search_form" method="post" action="">
                <div class="search-content">
                    <div class="row">
                        <input type="hidden" name="_page_no" id="_page_no" value="1"/>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <input type="text" name="s_key" id="user_s_key" value="" class="form-control" placeholder="Sök efter namn"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <select name="s_sort_by" id="user_s_sort_by" class="form-control" onchange="$('#user_search_form').submit();">
                                        <option value="">Sortera på</option>
                                        <option value="t.name">Sortera på namn</option>
                                        <option value="t.created">Sortera på datum</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 form-group">
                                    <select name="s_order_by" id="user_s_order_by" class="form-control" onchange="$('#user_search_form').submit();">
                                        <option value="ASC">Order By</option>
                                        <option value="ASC">Order By Accending</option>
                                        <option value="DESC">Order By Decending</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="" id="searchUserResult">
            <div class="table-header clearfix">
                <div class="table-header-count">
                    <strong><?php echo $total_users; ?></strong> results
                </div>
                <!-- /.table-header-count -->
                <div class="table-header-actions hide">
                    <a href="#" class="btn btn-primary"><i class="fa fa-filter"></i> Apply filters</a>
                    <a href="#" class="btn"><i class="fa fa-download"></i> Export All</a>
                </div>
                <div class="table-header-actions">
                    <ul class="pagination cust-pagination pull-right">
                        <?php if ($totalPages > 1) : ?>
                            <li class="page-item"><a href="javascript:;" onclick="getUserPaginationData(this)" data-pageNumber="1" id="pagination_li_first_1" class="page-link">First</a></li>
                            <li class="page-item"><a href="javascript:;" onclick="getUserPaginationData(this)" data-pageNumber="<?= ($crntPage > 1) ? $crntPage - 1 : 1 ?>" id="pagination_li_previous_<?= $crntPage - 1 ?>" class="page-link">Previous</a></li>
                            <?php for ($count = 1; $totalPages >= $count; $count++) : ?>
                                <?php if ($count >= $crntPage - 3 && $count <= $crntPage + 3) : ?>
                                    <?php if ($count == $crntPage) : ?>
                                        <li class="page-item active"><a href="javascript:;" onclick="getUserPaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                                    <?php else : ?>
                                        <li class="page-item"><a href="javascript:;" onclick="getUserPaginationData(this)" data-pageNumber="<?= $count ?>" id="pagination_li_<?= $count ?>" class="page-link"><?= $count ?></a></li>
                                    <?php endif; ?>
                                <?php endif; ?>
                            <?php endfor; ?>
                            <li class="page-item"><a href="javascript:;" onclick="getUserPaginationData(this)" data-pageNumber="<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" id="pagination_li_next_<?= ($crntPage < $totalPages) ? $crntPage + 1 : $totalPages ?>" class="page-link">Next</a></li>
                            <li class="page-item"><a href="javascript:;" onclick="getUserPaginationData(this)" data-pageNumber="<?= $totalPages ?>" id="pagination_li_last_<?= $totalPages ?>" class="page-link">Last</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- /.table-header-actions -->
            </div>
            <?php show_session_message(); ?>
            <div class="table-wrapper">
                <?php // echo $this->pagination->create_links(); ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>                   
                            <!--<th class="min-width center">ID</th>-->
                            <th class="min-width center">Namn</th>
                            <th class="min-width center">E-post</th>
                             <th class="min-width center">Företag</th>
                            <th class="min-width center">Org No.</th>
                            <th class="min-width center">Telefon</th>  
                            <th class="min-width center">Registrerings datum</th>  
                            <th class="min-width center">Status</th>  
                            <th class="center" width="30">Redigera</th>                                        
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($userData as $user) {
                           
                            
                            ?>
                            <tr>                   
                                <!--<td class="min-width center id">#<?php // echo $slno++; ?></td>-->
                                <td>
                                   <?php echo !empty($user['name']) ? $user['name']." ".$user['last_name'] : 'Not Given'; ?>
                                </td>
                                <td class="min-width no-wrap center">
                                   <?php echo !empty($user['email']) ? $user['email'] : 'Not Given'; ?>
                                </td>                    
                               
                                <td class="min-width center">
                                    <?php echo !empty($user['company_name']) ? $user['company_name'] : 'Not Given'; ?>
                                    <!-- /.status -->
                                </td>
                                 <td class="min-width center">
                                   <?php echo !empty($user['org_no']) ? $user['org_no'] : 'Not Given'; ?>
                                    <!-- /.status -->
                                </td>
                                <td class="min-width center">
                                     <?php echo !empty($user['contact']) ? $user['contact'] : 'Not Given'; ?>
                                </td>
                                <td class="min-width center">
                                     <?php echo !empty($user['created']) ? date("d-m-Y", strtotime($user['created'])) : 'Not Given'; ?>
                                </td>
                                <td class="min-width center">
                                     <?php  if($user['status'] == 1 ){ ?>
                                       <div class="bg-success text-white">Aktiv</div>
                                     <?php }else{ ?>
                                     <div class="bg-danger text-white">Inte aktiv</div>
                                     <?php } ?>
                                </td>
                                <td class="">      
                                    <a class="" href="<?php echo site_url('admin/users/edit/' . $user['user_id']); ?>" title="edit User"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;                                               
                                    <a class="" href="javascript:;" onclick="deleteUser('<?= $user['user_id'] ?>');" title="delete User"><i class="fa fa-trash"></i></a>&nbsp;&nbsp;    
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
                <?php // echo $this->pagination->create_links(); ?>
            </div>
        </div>
        <!-- /.box -->        
    </div>
    <!-- /.container --> 
</div>
<!-- /.admin-content -->