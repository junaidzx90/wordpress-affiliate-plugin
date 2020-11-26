<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       demo@gmail.com/about-me
 * @since      1.0.0
 *
 * @package    Wordpress_Affiliate_Plugin
 * @subpackage Wordpress_Affiliate_Plugin/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<?php
    if (isset($_GET['page']) == 'wordpress-affiliate-plugin') {
        echo '<style>body {
        background: url(' . plugin_dir_url(__FILE__) . '../img/bg.png); color: #eee; background-color: #23282da8; font: 1em "PT Sans", sans-serif;font-family: helvetica; }#wpfooter { color: #ffffff; }.select2-container--default { color: black; }</style>';
    }
?>

<!-- START SECTION -->
<div id="wpa_body" class="tabbed">
    <input type="radio" name="tabs" id="tab-nav-1" checked>
    <label for="tab-nav-1">PRODUCTS</label>
    <input type="radio" name="tabs" id="tab-nav-2">
    <label class="productLink" for="tab-nav-2">PRODUCT LINKS</label>
    <input type="radio" name="tabs" id="tab-nav-3">
    <label class="proViders" for="tab-nav-3">PROVIDERS</label>
    <!-- START TABS -->

    <div class="tabs">
        <div class="" id="add_product">
            <div class="row p-0 m-0">
                <div class="add_form col-sm-4 p-0">
                    <label class="add_product-label" for="add_products">Product Name</label>
                    <div class="form_data">
                        <input type="text" placeholder="Enter product name" name="add_product-label" class="add_products" required>
                        <div class="btns">
                            <button class="add_product_btn add_btn">ADD</button>
                            <button class="close_product_btn close_btn">CLOSE</button>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-4 p-0"></div> -->
                <div class="p_table col-sm-9 p-0">
                    <button class="open_product_form">+</button>
                    <div class="product_data show_product">
                        <!-- All products showing here -->
                    </div>
                </div>
            </div>
            <!---#product_page end--->
        </div>
        <!--end product_page-->

        <!-- start product_links_page -->
        <div id="product_links_page">
            <div class="row p-0 m-0">
                <div class="add_link_form col-sm-9 p-0 mb-2">
                    <span class="add_supplier-label">Add provider</span>
                    <div class="link_form_data row m-0">
                        <!-- Products -->
                        <div class="select col-sm-4  p-0 m-0">
                            <label for="product_id">Product</label><br>
                            <select id="product_id" class="js-example-basic-single" style="width: 100%;color:black;">
                                <!-- All products option goes here -->
                            </select>
                        </div>
                        <!-- Providers -->
                        <div class="select col-sm-4 m-0">
                            <label for="provider_id">Provider</label><br>
                            <select id="provider_id" class="js-example-basic-single" style="width: 100%color:black;">
                                <!-- Provider option goes here -->
                            </select>
                        </div>
                        <!-- Price input -->
                        <div class="priceBOX col-sm-4 m-0">
                            <label for="prce">Price</label><br>
                            <input id="price" name="prce" type="number" value="" placeholder="Product Price">
                        </div>
                        <!-- Link input -->
                        <label for="add_supplier">Affiliate</label>
                        <input type="text" placeholder="Enter affiliate link" name="add_supplier-label" class="links" required>
                        <!-- Buttons -->
                        <div class="btns">
                            <button class="add_link_btn">ADD</button>
                            <button class="close_link_btn">CLOSE</button>
                        </div>
                    </div>
                </div>

                <!-- Link data show from here -->
                <div class="link_table col-sm-9 p-0">
                    <button class="open_link_form">+</button>
                    <div class="links_data">
                        <!-- Link goes here -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end product_links_page -->


        <div id="providers">
            <div class="row p-0 m-0">
                <div class="provider_add_form col-sm-4 p-0">
                    <label class="add_supplier-label" for="supplier">Add provider</label>
                    <div class="form_data">
                        <input type="text" placeholder="Enter provider name" name="add_supplier-label" class="providers" required>
                        <div class="btns">
                            <button class="add_supplier_btn">ADD</button>
                            <button class="close_supplier_btn">CLOSE</button>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-sm-4 p-0"></div> -->
                <div class="provider_table col-sm-6 p-0">
                    <button class="open_provider_form">+</button>
                    <div class="provider_data">
                        <!-- Supplier data showing here -->
                    </div>
                </div>
            </div>
        </div>
    </div><!-- //START SECTION -->
</div><!-- //START SECTION -->