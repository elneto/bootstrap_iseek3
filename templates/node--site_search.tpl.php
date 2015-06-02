<?php
// echo "<br/>v1.14<br/>";

/*
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
*/

// include('sites/iseek.un.org/themes/bootstrap_iseek/js/sitesearch.js'); 

// print_r($results);

?>

<script type="text/javascript">

	jQuery(document).ready(function() {
		var qs_href_query = jQuery.urlParam('query');
		jQuery("#sitesearchInput").val(qs_href_query);
		submitSitesearch(qs_href_query, 0, "", "", "" );	
 		console.log("ready!");
	});


	jQuery.urlParam = function(name){
		var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
		if (!results) { return 0; }
		return results[1] || 0;
	}
</script>


<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

   <section id="search-main" class="clearfix container-fluid">

	<div class="row">

        	<div class="col-lg-12">
          		<div class="toolkit large-text" id="toolkit-anchor">&nbsp;<i class="fa fa-search"></i>Search</div>

			<h2>The UN Intranet - iSeek site search results</h2>

        	</div>

	</div>


	<div class="row">
		<div class="col-sm-7"> 
			<div class="input-group">
				<input class="form-control" name="query" type="text" id="sitesearchInput">
				<span class="input-group-btn">
					<button id="sitesearchTrigger" type="button" class="btn btn-primary">Search</button> 
				</span>
			</div>
		</div>
	</div>

       	<div class="row">
       	        <div class="col-sm-12 bundleNameButtons">
       	        </div>
       	</div>

	<div class="sitesearch_results_area">
		<div class="row">
			<div class="col-sm-12">
				<h3 class="sitesearch_results">
				</h3>
			</div>
		</div>

        	<div class="row">
        	        <div class="col-sm-12">
				<ul class="search-results apachesolr_search-results">
				</ul>
        	        </div>
        	</div>	

		<div class="row">
        	        <div class="col-sm-12">
				<div class="sitesearch_pagination">
				</div>
			</div>
		</div>
	</div>


<?php 
/*

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

						</form>
					</div>
				</div>
			</div>	
		</div>

		<div class="col-sm-8 col-md-9 main">

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
				   }
				?>
	
			</div> <!-- resultsArea -->
			</div> <!-- span10 -->
      </div> <!-- row-fluid -->
*/
?>

   </section>
</div>

