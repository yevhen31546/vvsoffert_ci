<div class="dashbaord container">
    <div>
        <style type="text/css">
            

            .dashbaord .dashbaord_nav ul li.select>a{
                font-size: 20px;
                box-shadow: 0px 1px 3px darkgrey;
                border-left: 6px solid #2ca01c;
            }

            .dashbaord .dashbaord_nav ul ul{
                padding:0px;
                background: #ebebeb;
            }
            .dashbaord .dashbaord_nav ul li ul li{
                display:none;
            }
            .dashbaord .dashbaord_nav ul li.select ul li{
                font-size:20px; padding-left:20px;
                display:block;
            }


            .dashbaord .dashbaord_nav ul ul li {
                background: #ebebeb;
                border-left:none;
            }
            .dashbaord .dashbaord_nav ul ul li a:hover {
                background: #CCEBFF;
                border-left:none;
            }
            .dashbaord .dashbaord_nav ul ul li a.select {
                background: #0974b3;
                border-left:none;
            }
        </style>

        <script type="text/javascript">
            $(document).ready(function(){
                $(".dashbaord .dashbaord_nav ul li a").on('click',function(){
                   jQuery(this.parentElement.parentElement).children('li').removeClass('select'); 
                   jQuery(this.parentElement).toggleClass("select"); 
                });
            });
        </script>
<?php //echo $this->router->fetch_method();exit;?>
        <div class="col-xs-12 col-sm-3 col-xl-2 dashbaord_nav no-gutter">
            <ul class="list-unstyled">
                
                <li class="<?= ($this->router->fetch_class() == 'dashboard' && $this->router->fetch_method() == 'index') ? 'select' : '' ?>"><a href="<?php echo site_url('kontrollpanel'); ?>">Startsida </a></li>
                
                <li class="<?= ($this->router->fetch_class() == 'user' && ($this->router->fetch_method() == 'useraccount_details') || $this->router->fetch_method() == 'change_password' || $this->router->fetch_method() == 'company_settings' || $this->router->fetch_method() == 'invoice_settings') ? 'select' : '' ?>">
                    <a>Inställningar</a>
                    <ul class= "nav list" style="">
                        <li class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'useraccount_details') ? 'select' : '' ?>"><a  href="<?php echo site_url('anvandarprofil'); ?>">Anvandarprofil</a>
                        <li class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'change_password') ? 'select' : '' ?>"><a  href="<?php echo site_url('andra-losenord');?>" >Ändra lösenord </a></li>
                        <li class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'company_settings') ? 'select' : '' ?>" ><a href="<?php echo site_url('company-settings'); ?>">  Företagsinställningar</a></li>
                        <li class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'invoice_settings') ? 'select' : '' ?>" ><a href="<?php echo site_url('invoice-settings'); ?>">  Fakturainställningar</a></li>
                    </ul>
                </li>
                
                
                <li class="<?= ($this->router->fetch_class() == 'user' && ($this->router->fetch_method() == 'import_product_rsk_excel' || $this->router->fetch_method() == 'import_product_rsk_price_excel')) ? 'select' : '' ?>" >
                    <a>Import</a>
                    <ul class= "nav list" style="">
                        <li class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'import_product_rsk_excel') ? 'select' : '' ?>" ><a href="<?php echo site_url('import-product-rsk-quantity'); ?>" >Importera Produkter</a></li>
                        <li class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'import_product_rsk_price_excel') ? 'select' : '' ?>" ><a href="<?php echo site_url('import-product-rsk-estore'); ?>">Importera egen prislista</a></li>
                    </ul>
                </li>

                <li class="<?= ($this->router->fetch_class() == 'user' && ($this->router->fetch_method() == 'new_add_list' || $this->router->fetch_method() == 'add_list' || $this->router->fetch_method() == 'customer'  || $this->router->fetch_method() == 'list_sale_history')) ? 'select' : '' ?>">
                    <a>Försäljning</a>
                    <ul class= "nav list" style="">
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'list_sale_history' && $_GET['type'] == 1) ? 'select' : '' ?>" href="<?php echo site_url('list-sale-history') . '?&type=1'; ?>">Offerter</a></li>
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'list_sale_history' && $_GET['type'] == 2) ? 'select' : '' ?>" href="<?php echo site_url('list-sale-history') . '?&type=2'; ?>">Order</a></li>
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'list_sale_history' && $_GET['type'] == 3) ? 'select' : '' ?>" href="<?php echo site_url('list-sale-history') . '?&type=3'; ?>">Kundfakturor</a></li>
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'customer') ? 'select' : '' ?>" href="<?php echo site_url('kund'); ?>">Kunder</a></li>
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'new_add_list') ? 'select' : '' ?>" href="<?php echo site_url('newarticle'); ?>">Artiklar</a></li>
                        <li><a class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'add_list') ? 'select' : '' ?>" href="<?php echo site_url('article'); ?>">Listor</a></li>
                    </ul>
                </li>
            
                <li class="<?= ($this->router->fetch_class() == 'user' && $this->router->fetch_method() == 'cost_caclulator') ? 'select' : '' ?>" ><a href="<?php echo site_url('snabb-kalkyl'); ?>">Kalkyl</a></li>
                
                
            </ul>
        </div>