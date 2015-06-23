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
