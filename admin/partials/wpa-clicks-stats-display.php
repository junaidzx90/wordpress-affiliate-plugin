<style>
<?php
global $wpdb; 
if (isset($_GET['page']) == 'wpa-clicks-stats') {
    echo 'body {
    background: url(' . plugin_dir_url(__FILE__) . '../img/bg.png); color: #eee; background-color: #23282da8; font: 1em "PT Sans", sans-serif;font-family: helvetica; }#wpfooter { color: #ffffff; }';
}
?>
</style>

<div id="wpa_body" class="tabbed">
    <input type="radio" name="tabs" id="tab-navs-1" checked>
    <label for="tab-navs-1">PRODUCTS</label>
    <input type="radio" name="tabs" id="tab-navs-2">
    <label for="tab-navs-2">PRODUCT LINKS</label>
    <!-- <div class="header">
        <h1>Click stats</h1>
    </div> -->
    <div class="tab">
        <div class="stats_product_table">
        <input class="myInputs product_stats_s" type="text" placeholder="Search..">
                <table>
                    <thead>
                        <tr>
                            <th>SL | ID</th>
                            <th>Products</th>
                            <th>Session ID</th>
                            <th>Referring Page</th>
                            <th>Clicks</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody class="product_stats">
                        <?php 
                            global $wpdb; //Define wpdb global variable
                            $products = $wpdb->prefix . 'wpa_products'; //Define wpa_products table with wp prefix
                            $clicks_table = $wpdb->prefix . 'wpa_clicks'; //define wpa_clicks table with wp prefix

                            $product_clicks = $wpdb->get_results("SELECT c.*, p.*, COUNT(c.product_id) as totalclicks, MAX(c.timestamp) as time FROM $products p,  $clicks_table c  WHERE p.product_ID = c.product_id GROUP BY c.product_id ORDER BY c.timestamp DESC");
        
                            if($product_clicks){
                                $product_click = "";
                                $sl = 1;
                                foreach($product_clicks as $click){
                                    $product_click .= '<tr>';
                                    $product_click .= '<td>'.$sl.' | '.$click->product_id.'</td>';
                                    $product_click .= '<td>'.$click->product_name.'</td>';
                                    $product_click .= '<td>'.$click->session_id.'</td>';
                                    $product_click .= '<td>'.(($click->referring_page)?$click->referring_page:"No page found").'</td>';
                                    $product_click .= '<td>'.$click->totalclicks.'</td>';
                                    $product_click .= '<td>';
                                    $product_click .= date_format(date_create($click->time), 'h:i a - d/m/y');
                                    $product_click .= '</td>';
                                    $product_click .= '</tr>';
                                    $sl++;
                                }
                                echo $product_click;
                            }else{
                                echo '<td colspan="6" style="color: #ff4343; text-align: center;">No data found!</td>';
                            }
                        ?>
                    </tbody>
                </table>
        </div>
        <div class="stats_productlink_table">
        <input class="myInputs productlink_stats_s" type="text" placeholder="Search..">
                <table>
                    <thead>
                        <tr>
                            <th>SL | ID</th>
                            <th>Product Links</th>
                            <th>Session ID</th>
                            <th>Referring Page</th>
                            <th>Clicks</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody  class="productlink_stats">
                    <?php 
                            $product_links = $wpdb->prefix . 'wpa_product_links'; //define wpa_product_links table with wp prefix
                            $clicks_table = $wpdb->prefix . 'wpa_clicks'; //define wpa_clicks table with wp prefix

                            $productlink_clicks = $wpdb->get_results("SELECT c.*, l.affiliate_link,l.productLink_ID, COUNT(c.product_link_id) as totalclicks, MAX(c.timestamp) as time FROM $product_links l,  $clicks_table c  WHERE l.productLink_ID = c.product_link_id GROUP BY c.product_link_id ORDER BY c.timestamp DESC");
        
                            if($productlink_clicks){
                                $product_click = "";
                                $sl = 1;
                                foreach($productlink_clicks as $link_click){
                                    $product_click .= '<tr>';
                                    $product_click .= '<td>'.$sl.' | '. $link_click->productLink_ID.'</td>';
                                    $product_click .= '<td>';
                                    $product_click .= '<input disabled class="url" value="'.$link_click->affiliate_link.'"></td>';
                                    $product_click .= '<td>'.$link_click->session_id.'</td>';
                                    $product_click .= '<td>'.(($link_click->referring_page)?$link_click->referring_page:"No page found").'</td>';
                                    $product_click .= '<td>'.$link_click->totalclicks.'</td>';
                                    $product_click .= '<td>';
                                    $product_click .= date_format(date_create($link_click->time), 'h:i a - d/m/y');
                                    $product_click .= '</td>';
                                    $product_click .= '</tr>';
                                    $sl++;
                                }
                                echo $product_click;
                            }else{
                                echo '<td colspan="6" style="color: #ff4343; text-align: center;">No data found!</td>';
                            }
                        ?>
                    </tbody>
                </table>
        </div>
    </div>
</div>