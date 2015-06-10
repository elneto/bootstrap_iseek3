<div class="row">
	<div class="col-sm-12">



                    <div class="departmental_page_breadcrumb">

                    <?php

                            $taxonomy_term_array = taxonomy_get_term_by_name($og_node->title, "departments");

                            $taxonomy_id = key($taxonomy_term_array);

                            $taxonomy_parents_array = taxonomy_get_parents_all(key($taxonomy_term_array));

                            // reverse sort for display purposes
                            krsort($taxonomy_parents_array);

                            $i = 1;

                            foreach ($taxonomy_parents_array as $parent) {
                                    //$parent->tid

                                    // get path based on name

                                    $query = new EntityFieldQuery();
                                    $breadcrumb_entities = $query->entityCondition('entity_type', 'node')
                                            ->propertyCondition('type', 'department')
                                            ->propertyCondition('title', $parent->name)
                                            ->propertyCondition('status', 1)
                                            ->range(0,1)
                                            ->execute();

                                    if (!empty($breadcrumb_entities['node'])) {
                                            $breadcrumb_node = node_load(array_shift(array_keys($breadcrumb_entities['node'])));
                                    ?>

                                            <a href="<?php print url("node/" . $breadcrumb_node->nid) ?>"><?php print $parent->name; ?></a>
                                    <?php

                                    } else {

                                            print $parent->name ;

                                    }

                                    if ($i < count($taxonomy_parents_array)) {
                                            print " &gt; ";
                                    }

                                    $i++;
                            }
                    ?>

                    </div>

	</div>
</div>
