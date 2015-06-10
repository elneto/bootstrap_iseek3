<?php
$og_node = node_load($og_id);

$menu_name = "";
$menu_display_name = "";
$query_menu_result = db_query(
        "SELECT menu_name FROM {og_menu} WHERE gid = :gid LIMIT 1",
        array(':gid' => $og_id)
);

if ($query_menu_result) {
        while ($row = $query_menu_result->fetchAssoc()) {
                $menu_name = $row['menu_name'];
                $menu_display_name = menu_load($menu_name)['title'];
        }
}

$divisions_menu_array = menu_navigation_links($menu_name);
?>