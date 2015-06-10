<div>
<?php

$taxonomy_term_array = taxonomy_get_term_by_name($og_node->title, "departments");

$taxonomy_id = key($taxonomy_term_array);

// get the parents

$full_parent_taxonomy_array = taxonomy_get_parents_all($taxonomy_id);

$depts_vid = 22;

$dept_site_map_array = array();
$ultimate_parent_name = "";

if ($full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->name == 'Secretariat') {
        $dept_site_map_array = taxonomy_get_tree($full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 2]->vid, $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 2]->tid);
        $ultimate_parent_name = $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 2]->name;
} else {
        $dept_site_map_array = taxonomy_get_tree($full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->vid, $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->tid);
        $ultimate_parent_name = $full_parent_taxonomy_array[count($full_parent_taxonomy_array) - 1]->name;
}
?>


<div class="modal fade" id="deptSiteMapModal" tabindex="-1" role="dialog" aria-labelledby="deptSiteMapModal" aria-hidden="true">
 <div class="modal-dialog">
  <div class="modal-content">
   <div class="modal-header">
        Site map
   </div>
   <div class="modal-post-header">
        <button type="button" class="close" data-dismiss="modal">Close <span aria-hidden="true">×</span></button>
   </div>
   <div class="modal-body">

        <ul class="dept_site_map">

        <?php
        // first add the parent
                $ultimate_parent_query = new EntityFieldQuery();
                $ultimate_parent_entities = $ultimate_parent_query->entityCondition('entity_type', 'node')
                ->propertyCondition('type', 'department')
                ->propertyCondition('title', $ultimate_parent_name)
                ->propertyCondition('status', 1)
                ->range(0,1)
                ->execute();

                    $strong_start = "";
                    $strong_end = "";
                    if ($og_node->title == $ultimate_parent_name) {
                            $strong_start = "<strong>";
                            $strong_end = "</strong>";
                    }


                if (!empty($ultimate_parent_entities['node'])) {
                        $child_node = node_load(array_shift(array_keys($ultimate_parent_entities['node'])));
        ?>
                                <li class="depth0"><a href="<?php print url("node/" . $child_node->nid) ?>"><?php echo $strong_start; ?><?php print $ultimate_parent_name; ?><?php echo $strong_end; ?></a></li>
                <?php
                } else {
                ?>
                                <li class="depth0"><?php print $ultimate_parent_name; ?></li>
                <?php
                }

        ?>

        <?php
        foreach ($dept_site_map_array as $dept_site_map_array_item) {
        ?>
                <li class="depth<?php echo ($dept_site_map_array_item->depth + 1); ?>">

                <?php
                        $dept_site_map_query = new EntityFieldQuery();
                        $dept_site_map_entities = $dept_site_map_query->entityCondition('entity_type', 'node')
                        ->propertyCondition('type', 'department')
                        ->propertyCondition('title', $dept_site_map_array_item->name)
                        ->propertyCondition('status', 1)
                        ->range(0,1)
                        ->execute();

                        $strong_start = "";
                        $strong_end = "";
                        if ($node->title == $dept_site_map_array_item->name) {
                                $strong_start = "<strong>";
                                $strong_end = "</strong>";
                        }


                        if (!empty($dept_site_map_entities['node'])) {
                                $child_node = node_load(array_shift(array_keys($dept_site_map_entities['node'])));


                ?>
                                        <a href="<?php print url("node/" . $child_node->nid) ?>"><?php echo $strong_start; ?><?php print $dept_site_map_array_item->name; ?><?php echo $strong_end; ?></a>
                        <?php
                        } else {
                        ?>
                                        <?php echo $strong_start; ?><?php print $dept_site_map_array_item->name; ?><?php echo $strong_end; ?>
                        <?php
                        }
                        ?>

                </li>
        <?php
        }
        ?>
          </ul>
        </div>
        <div class="modal-footer">

        </div>
  </div>
 </div>
</div>
