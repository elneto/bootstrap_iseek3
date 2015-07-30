<script type="text/javascript">
        jQuery(document).ready(function() {
                jQuery('.input-group.date').datepicker({
                        format: "yyyy-mm-dd",
                        endDate: "today",
                        autoclose: true,
                        todayHighlight: true})
        });
</script>

<div class="row departmentalSubmenu">
        <div class="col-lg-12">
                <ul class="departmentalSubmenu-nav">
                        <li class="first expanded dropdown">
                                <span title="" data-target="#" class="dropdown-toggle nolink" data-toggle="dropdown"><i class="fa fa-link"></i> Quicklinks <span class="caret"></span></span>
                                <?php print views_embed_view('departmental_page_in_og', 'block', $og_id); ?>
                        </li>
                        <li><span data-toggle="modal" data-target="#deptSiteMapModal"><i class="fa fa-list-alt"></i> Site map</span></li>
                        <li><a href="/nmu-bulletin-email-fullday">Bulletins</a></li>
                        <li><a href="/nmu-clipping-email-fullday">Clippings</a></li>
                        <li><a href="/user">Subscribe</a></li>
                        <?php
                                if ($menu_display_name) {
                        ?>

                                        <li class="expanded dropdown">
                                                <span title="" data-target="#" class="dropdown-toggle nolink" data-toggle="dropdown"><?php echo $menu_display_name ?> <span class="caret"></span></span>
                                                <ul class="dropdown-menu">
                                                        <?php
                                                                foreach ($divisions_menu_array as $divisions_menu_array_item) {
                                                                        echo "<li class=\"leaf\"><a href=\"/" . drupal_get_path_alias($divisions_menu_array_item['href']) . "\">" . $divisions_menu_array_item['title'] . "</a></li>";
                                                                }
                                                        ?>
                                                </ul>
                                        </li>
                        <?php   } ?>

                        <?php print views_embed_view('departmental_faq_in_og', 'block', $og_id); ?>
                        <?php
                                if (count($og_node->field_departmental_contact_us)) {
                        ?>
                                        <li><a href="<?php echo $og_node->field_departmental_contact_us['und'][0]['safe_value'] ?>"><i class="fa fa-envelope-o"></i> Contact us</a></li>
                        <?php
                                }
                        ?>
                </ul>
        </div>
</div>
