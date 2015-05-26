<?php
// echo "<br/>v1.14<br/>";

/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 */

// echo "current_path: " . current_path();

$languageLookup = array(
	'en' => 'English',
     'fr' => 'Français',
     'und' => 'No language specified'
	);


$iseekFields = array(
	'entity_id' => 'entity_id',
     'bundle_name' => 'bundle_name',
     'url' => 'url',
     'label' => 'label',
     'ds_created' => 'ds_created',
     'ds_changed' => 'ds_changed',
     'content' => 'content',
     'teaser' => 'teaser'
	);

$iseekAdvSearchFields = array(
	'title' => 'title',
     'lastName' => 'last name',
     'firstName' => 'first name',
     'email' => 'e-mail',
     'phoneDisplay1' => 'phone',
     'building' => 'building',
     'room' => 'room',
     'organizationalUnit' => 'org unit');
	 
$iseekFacetLookup = array(
     'Announcements' => 'Local announcements',
     'Basic page' => 'About iSeek',
	);
	 

// echo ksd_solr_search_test_function("http://intra-srch.un.org/solr/iseek/select");

// function ksd_solr_search_process_search($solr_path, $rows_per_page, $wildcard, $default_sort, $default_sort_dir, $multivalue_facets, $iseekAdvSearchFields, $highlight, $highlight_field, $highlight_snippets, $defType, $qf, $stopwords, $lowercaseOperators) {

// echo "test v1.1<br/>";

$results = ksd_solr_search_process_search (
	// "http://intra-srch.un.org:8983/solr/iseekdrupal_shard1_replica2/select",
	// "http://intra-srch.un.org/solr/iseekdrupal_shard1_replica2/select",
	"https://iseekd:F4Setruc8rUspenU@nyvm1482.stc.un.org:7783/solr/iseek_drupal/select", 
	10,
	0,
	"",
	"",
	array("bundle_name"),
	$iseekFields,
	1,
	"content",
	3,
	"edismax",
	array("label", "content"),
	1,
	1
);

/* 
$solr_path, 
$rows_per_page, 
$wildcard, 
$default_sort, 
$default_sort_dir, 
$multivalue_facets, 
$iseekAdvSearchFields, 
$highlight, 
$highlight_field, 
$highlight_snippets, 
$defType, 
$qf, 
$stopwords, 
$lowercaseOperators
*/
/*
$results = ksd_solr_search_process_search (
	"http://intra-srch.un.org/solr/iseekdrupal_shard1_replica2/select",
	30,
	1,
	"lastName",
	"asc",
	array("dutyStation"),
	$iseekAdvSearchFields,
	0,
	"",
	0
);
*/







// print_r($results);

?>

<script type="text/javascript">

	jQuery(document).ready(function() {

		// clear all duty stations when user clicks go button
		jQuery( "#searchTriggerSimple" ).click(function() {
			showLoadingMessage();
			clearCheckboxes();
			submitSimpleForm();
		});

		jQuery('#search-form-simple input:checkbox').change(function() {
			showLoadingMessage();
			submitSimpleForm();
		});

		jQuery( "#searchTriggerAdvanced" ).click(function() {
				showLoadingMessage();
				clearCheckboxes();
				submitSimpleForm();
		});

		jQuery('#search-form-advanced input:checkbox').change(function() {
				showLoadingMessage();
				submitAdvancedForm();
		});

		jQuery(document).ready(function(){
    			jQuery("[data-toggle=tooltip]").tooltip({ placement: 'right'});
		});

	});

	function clearCheckboxesAndSubmitSimpleForm() {
		showLoadingMessage();
		clearCheckboxes();
		submitSimpleForm();
	}

	function clearCheckboxesAndSubmitAdvancedForm() {
                showLoadingMessage();
                clearCheckboxes();
                submitAdvancedForm();
	}

	function clearCheckboxes() {
			jQuery("input:checkbox").prop("checked", false);
	}

	function submitSimpleForm() {
		jQuery("#search-form-simple").submit();
	}

	function submitAdvancedForm() {
			jQuery("#search-form-advanced").submit();
	}

	function resetAdvancedForm() {
		jQuery("input:text").val("");
	}

	function showLoadingMessage() {
		jQuery("#resultsArea").html("<p style=\"text-align: center\">Loading...</p>");
	}

</script>



<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

   <section id="search-main" class="clearfix container-fluid">

	<div class="row">

		<div class="col-sm-4 col-md-3 sidebar">
		
			<div class="panel-group">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							iSeek site search
						</h4>
					</div>
					<div class="panel-body">
			
		
		

						<form class="search-form" id="search-form-simple" action="<?php echo $results["page_path"]; ?>">

			<?php
			/*							
							<div class="controls">
								<input type="text" class="input-small" name="query" value="<?php echo $results["query"]; ?>">
							</div>
							<div class="controls">
									<input type="submit" class="btn" id="searchTriggerSimple" value="Go">
							</div>
			*/
			?>
							<div class="input-group">
								<input type="text" class="form-control" name="query" value="<?php echo $results["query"]; ?>">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="button" id="searchTriggerSimple" value="Go">Go</button>
								</span>
							</div>

							<?php if ($results["resultsFound"] > 0) { ?>
							
								<div class="muted">Refine by content type</div>
								<div class="controls dutyStationFacetControls">
									<?php foreach($results["facets_nonzero_hash"]["bundle_name"] as $facets_nonzero_hash_item_key => $facets_nonzero_hash_item_value) { ?>
											<label>
												<input type="checkbox" name="bundle_nameFacet" value="<?php echo $facets_nonzero_hash_item_key; ?>" <?php if (in_array($facets_nonzero_hash_item_key, $results["multivalue_facet_array"]["bundle_name"])) {  echo "checked"; }  ?> >
												<?php 
													if (array_key_exists($facets_nonzero_hash_item_key, $iseekFacetLookup)) {
														echo $iseekFacetLookup[$facets_nonzero_hash_item_key];
													} else {
														echo $facets_nonzero_hash_item_key; 
													}	
												?> (<?php echo $facets_nonzero_hash_item_value; ?>)
											</label>
									<?php } ?>
								</div>
								<?php if (count($results["multivalue_facet_array"]) > 0) { ?>
									<div>
												<a class="reset" href="#" onClick="clearCheckboxesAndSubmitSimpleForm();">Clear</a>
										</div>
								<?php } ?>
								
							<?php } ?>

			<?php
			/*				
							<div class="muted">Refine by language</div>
							<div class="controls dutyStationFacetControls">
								<?php foreach($results["facets_nonzero_hash"]["ss_language"] as $facets_nonzero_hash_item_key => $facets_nonzero_hash_item_value) { ?>
										<label>
											<input type="checkbox" name="ss_languageFacet" value="<?php echo $facets_nonzero_hash_item_key; ?>" <?php if (in_array($facets_nonzero_hash_item_key, $results["multivalue_facet_array"]["ss_language"])) {  echo "checked"; }  ?> >
											<?php echo $languageLookup[$facets_nonzero_hash_item_key]; ?> (<?php echo $facets_nonzero_hash_item_value; ?>)
										</label>
								<?php } ?>
							</div>
							<?php if (count($results["multivalue_facet_array"]) > 0) { ?>
								<div>
											<a class="reset" href="#" onClick="clearCheckboxesAndSubmitSimpleForm();">Clear</a>
									</div>
							<?php } ?>
			*/
			?>
						</form>
					</div>
				</div>
			</div>	
		</div>

		<div class="col-sm-8 col-md-9 main">

			<!-- <h2 id="branding_headline"><?php echo $title; ?></h1> -->

			<div id="resultsArea">
			
				<?php if ($results["resultsFound"] == 0) { ?>

				   <h3 class="gcd_results">Sorry, no results could be found for your search.</h2>

						<?php if (count($results["suggestions"]) > 0) { ?> 

							<div class="alert alert-info" role="alert">
								Did you mean: <a href="?query=<?php print($results["suggestions"][0]); ?>"><?php print($results["suggestions"][0]); ?></a>
							</div>
				   
						<?php } ?> 
				   
				<?php } else { ?>

				   <h3 class="gcd_results">Results <?php echo $results["resultsStart"]; ?> - <?php echo $results["resultsEnd"]; ?> of <?php echo $results["resultsFound"]; ?></h2>

					
					<div class="link-wrapper panel panel-default">
						<div class="panel-body">
							<ul class="links inline">
								<li>
										Sort by: 
								</li>
								<li>
									<?php if ($results["sort"] == 'ds_created' && $results["sort_dir"] == 'desc') { ?>
										Date descending <i class="glyphicon glyphicon-arrow-down"></i>
									<?php } else { ?>
										<a href="<?php echo $results["page_path"]; ?>?<?php echo http_build_query($results["sort_link"]); ?>&sort=ds_created&sort_dir=desc">Date descending</a>
									<?php } ?>
									</li>
								<li>
									<?php if ($results["sort"] == 'ds_created' && $results["sort_dir"] == 'asc') { ?>
										Date ascending <i class="glyphicon glyphicon-arrow-up"></i>
									<?php } else { ?>
										<a href="<?php echo $results["page_path"]; ?>?<?php echo http_build_query($results["sort_link"]); ?>&sort=ds_created&sort_dir=asc">Date ascending</a>
									<?php } ?>
								</li>
								<li>
									<?php if ($results["sort"] == '') { ?>
										Relevance <i class="glyphicon glyphicon-arrow-down"></i>
									<?php } else { ?>
										<a href="<?php echo $results["page_path"]; ?>?<?php echo http_build_query($results["sort_link"]); ?>">Relevance</a>
									<?php } ?>						
								</li>
							</ul>
						</div>	
					</div>	
				   
					<ul class="search-results apachesolr_search-results">
				   
					<?php 
						foreach ($results["decoded_search_results"]->response->docs as $result_doc) {
					?>

					
							<li class="search-result">
								<h4 class="title">
									<?php 
										$result_path = "/" . $result_doc->path_alias;
										if ($result_doc->ss_language == 'fr') {
											$result_path = "/" . $result_doc->ss_language . $result_path;
										}
									?>	
									<a href="<?php echo $result_path; ?>"><?php echo $result_doc->label; ?></a>
								</h4>
								<div class="search-snippet-info">
									<p class="search-snippet">
										<?php 
											$result_doc_id = $result_doc->id ;
											foreach ($results["decoded_search_results"]->highlighting->$result_doc_id->content as $snippets) {
										?>	
												<?php echo $snippets; ?> ... 
										<?php 
											}
										?>	
									</p>
									<p class="slug">
										<?php 
											if (array_key_exists($result_doc->bundle_name, $iseekFacetLookup)) {
												echo $iseekFacetLookup[$result_doc->bundle_name];
											} else {
												echo $result_doc->bundle_name; 
											}	
										?>
										-
										<?php 
											
											$ds_changed_date = strtotime($result_doc->ds_changed);
											
											echo date('j F Y', $ds_changed_date);
										
										?>		
									</p>
								</div>
							</li>
					<?php
						}
					 ?>  
					 
					</ol>	

				   <nav id="pager-bottom">
					 <div class="pagination pagination-large">

						<?php echo $results["pagination"]; ?>

					 </div>
				   </nav>

				<?php
				   } /* results == 0 */
				?>

			</div> <!-- resultsArea -->
			</div> <!-- span10 -->
      </div> <!-- row-fluid -->
   </section>
</div>

