<?php
// echo "<br/>v1.15<br/>";
/*
$time_starting_solr = microtime(true);
echo "<br/>time_starting_solr: " . $time_starting_solr . "<br/>";
*/

/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 */

// echo "current_path: " . current_path();

$iseekFields = array(
	'title' => 'Title',
     'lastName' => 'Last name',
     'firstName' => 'First name',
     'email' => 'E-mail',
     'phoneDisplay1' => 'Phone',
     'dutyStation' => 'Duty station',
     'building' => 'Building',
     'room' => 'Room',
     'organizationalUnit' => 'Org unit');

$iseekAdvSearchFields = array(
     'lastName' => 'Last name',
     'firstName' => 'First name',
     'email' => 'E-mail',
     'phoneDisplay1' => 'Phone',
     'building' => 'Building',
     'room' => 'Room',
     'organizationalUnit' => 'Org unit');

$iseekAdvSearchFieldsHelpText = array(
     'lastName' => 'For names with accents, you may enter the letter with or without the accent',
     'firstName' => 'For names with accents, you may enter the letter with or without the accent',
     'phoneDisplay1' => 'The phone number must be entered exactly as it is in the directory. Some duty stations, such as Geneva, list only the extension number, while others, like New York, list the full number (212-963-1234)',
     'building' => 'The name of the building must be entered exactly as it appears in the data base. eg Main Building, IN, Palais des nations',
     'room' => 'Enter the room number only',
	 );


// echo ksd_solr_search_test_function("http://intra-srch.un.org/solr/iseek/select");


$results = ksd_solr_search_process_search (
	// "http://intra-srch.un.org/solr/iseek/spell",
	// "https://nyvm1482.stc.un.org:7984/solr/iseek/spell", 
	"https://iseek:d6jAXEchEfr6nuCh@nyvm1482.stc.un.org:7783/solr/iseek/spell", 
	30,
	0,
	"lastName",
	"asc",
	array("dutyStation"),
	$iseekAdvSearchFields,
	0,
	"",
	0,
	"",
	"",
	"",
	"",
	"",
	""
);



?>


<script type="text/javascript">

	jQuery(document).ready(function() {

		// Pad bottom footer block
		jQuery('.node-type-gcd').find('#footer-wrapper').addClass('col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2');

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
			<div class="col-sm-3 col-md-2 sidebar">

				<div class="panel-group" id="accordion2">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion2" href="#collapseSimple">
									Simple search
								</a>
							</h4>
						</div>
						<div id="collapseSimple" class="panel-collapse collapse <?php if ($results["searchtype"] == "simple") { echo "in"; } ?>">
							<div class="panel-body">
								<form class="search-form" id="search-form-simple" action="<?php echo $results["page_path"]; ?>">

								<div class="input-group">
							      <input type="text" class="form-control" name="query" value="<?php echo $results["query"]; ?>">
							      <span class="input-group-btn">
							        <button class="btn btn-primary" type="button" id="searchTriggerSimple" value="Go">Go</button>
							      </span>
							    </div><!-- /input-group -->

									<div class="muted">Refine by duty station</div>
									<div class="controls dutyStationFacetControls">
										<?php foreach($results["facets_nonzero_hash"]["dutyStation"] as $facets_nonzero_hash_item_key => $facets_nonzero_hash_item_value) { ?>
												<label>
													<input type="checkbox" name="dutyStationFacet" value="<?php echo $facets_nonzero_hash_item_key; ?>" <?php if (in_array($facets_nonzero_hash_item_key, $results["multivalue_facet_array"]["dutyStation"])) {  echo "checked"; }  ?> >
													<?php echo $facets_nonzero_hash_item_key; ?> (<?php echo $facets_nonzero_hash_item_value; ?>)
												</label>
										<?php } ?>
									</div>
									<?php if (count($results["multivalue_facet_array"]) > 0) { ?>
										<div>
        							<a class="reset" href="#" onClick="clearCheckboxesAndSubmitSimpleForm();">Clear</a>
      							</div>
									<?php } ?>
								</form>
							</div>
						</div>
						<!-- <hr class="primary clear-me"/> -->
					</div>
					<div class="panel panel-default">
                                                <div class="panel-heading">                                                        
							<h4 class="panel-title">
								<a data-toggle="collapse" data-parent="#accordion2" href="#collapseAdvanced">
									Advanced search
								</a>
							</h4>
						</div>
						<div id="collapseAdvanced" class="panel-collapse collapse <?php if ($results["searchtype"] == "advanced") { echo "in"; } ?> ">
							<div class="panel-body">
      								<form class="search-form" id="search-form-advanced" action="<?php echo $results["page_path"]; ?>">

									<?php
										foreach ($iseekAdvSearchFields as $header_key => $header_value) {
									?>
											<div class="form-group">
												<label><?php echo $header_value; ?></label>
												<?php
													if (isset($iseekAdvSearchFieldsHelpText[$header_key])) {
												?>
														<i class="fa fa-info-circle" data-toggle="tooltip" title="<?php echo $iseekAdvSearchFieldsHelpText[$header_key]; ?>"></i>
												<?php
												}
												?>
												<input class="form-control" type="text" name="<?php echo $header_key; ?>" value="<?php if (isset($results["iseekFieldsValues"][$header_key])) { echo $results["iseekFieldsValues"][$header_key]; } ?>" placeholder="<?php echo $header_value; ?>">
											</div>
									<?php
										}
									?>


						    		<div class="controls">
	  								<a class="reset" href="#" onclick="resetAdvancedForm();">Reset</a>
		 							</div>
	  							<div class="controls">
										<input type="submit" name="searchTrigger" id="searchTriggerAdvanced" value="Go" class="btn btn-primary">
	  							</div>

									<div class="muted">Refine by duty station</div>
										<div class="controls dutyStationFacetControls">
											<?php foreach($results["facets_nonzero_hash"]["dutyStation"] as $facets_nonzero_hash_item_key => $facets_nonzero_hash_item_value) { ?>
												<label>
													<input type="checkbox" name="dutyStationFacet" value="<?php echo $facets_nonzero_hash_item_key; ?>" <?php if (in_array($facets_nonzero_hash_item_key, $results["multivalue_facet_array"]["dutyStation"])) {  echo "checked"; }  ?> >
														<?php echo $facets_nonzero_hash_item_key; ?> (<?php echo $facets_nonzero_hash_item_value; ?>)
												</label>
												<?php } ?>
										</div>
										<?php if (count($results["multivalue_facet_array"]) > 0) { ?>
										<div>
												<a class="reset" href="#" onClick="clearCheckboxesAndSubmitAdvancedForm();">Clear</a>
										</div>
										<?php } ?>

      									<input type="hidden" name="searchtype" value="advanced">
								</form>
							</div>
						</div>
					</div>
					<div class="panel panel-default">
						<div class="panel-heading">
								<h4 class="panel-title">
										<a href="/content/additional-phone-resources">
												Additional resources
										</a>
								</h4>
						</div>
					</div>
				</div>

			</div>

			<div class="col-sm-9 col-md-10 main">

				<h2 id="branding_headline"><?php echo $title; ?></h2>

				<div id="resultsArea">

					<?php if ($results["resultsFound"] == 0) { ?>

					  <h3 class="gcd_results">Sorry, no results could be found for your search.</h3>

					  <?php if (count($results['suggestions']) > 0) { ?>

						<div class="alert alert-info" role="alert">				  
							<strong>Did you mean?</strong>
							<ul>		
								<?php foreach ($results['suggestions'] as $suggestion) { ?>
									<li>
										<a href="?query=<?php echo $suggestion->word; ?>"><?php echo $suggestion->word; ?></a>: <?php echo $suggestion->freq; ?> results
									</li>							
								<?php
									}
								?>
							</ul>		
						</div>	

					  <?php } ?>
					  
					  
					<?php } else { ?>

					  <h3 class="gcd_results">Results <?php echo $results["resultsStart"]; ?> - <?php echo $results["resultsEnd"]; ?> of <?php echo $results["resultsFound"]; ?></h3>

					  
					  <?php if (count($results['suggestions']) > 0) { ?>

						<div class="alert alert-info" role="alert">				  
							<strong>Did you mean?</strong>
							<ul>		
								<?php foreach ($results['suggestions'] as $suggestion) { ?>
									<li>
										<a href="?query=<?php echo $suggestion->word; ?>"><?php echo $suggestion->word; ?></a>: <?php echo $suggestion->freq; ?> results
									</li>							
								<?php
									}
								?>
							</ul>		
						</div>	

					  <?php } ?>

					  
					  <table class="table table-striped">
							<thead>
		      			<tr>
								<?php
								
									foreach ($iseekFields as $header_key => $header_value) {
								?>
									<th>
										<a href="<?php echo $results["page_path"]; ?>?<?php echo http_build_query($results["sort_link"]); ?>&sort=<?php echo $header_key; ?>&sort_dir=<?php echo ($results["sort"] == $header_key && $results["sort_dir"] == "asc") ? "desc" : "asc"; ?>&searchtype=<?php echo $results["searchtype"]; ?>&<?php echo http_build_query($results["iseekFieldsValues"]); ?>"><?php echo $header_value; ?></a>
										<?php if ($results["sort"] == $header_key && $results["sort_dir"] == 'asc') { ?>
											<!-- <i class="fa fa-caret-down"></i> -->
											<i class="glyphicon glyphicon-arrow-down"></i>
										<?php } elseif ($results["sort"] == $header_key && $results["sort_dir"] == 'desc') { ?>
											<!-- <i class="fa fa-caret-up"></i> -->
											<i class="glyphicon glyphicon-arrow-up"></i>
										<?php } ?>
									</th>
								<?php
									}
								?>
								</tr>
			    		</thead>
							<tbody>
								<?php
								
									$iter = 1 ;
									foreach($results["decoded_search_results"]->{'response'}->{'docs'} as $doc) {
								?>

								<tr>
									<?php
										foreach ($iseekFields as $field_key => $field_value) {
									?>
									<td>
										<?php echo $doc->{$field_key}; ?>
									</td>
									<?php
										}
									?>
								</tr>

								<?php
										$iter++;
									}

								?>
							</tbody>
					  </table>

					  <div id="pager-bottom">
							<?php echo $results["pagination"]; ?>
					  </div>

					<?php
					   } /* results == 0 */
					?>

				</div> <!-- resultsArea -->
    	</div> <!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
    </div> <!-- row -->
  </section>
</div>

<?php 
/*
$time_ending_solr = microtime(true);
echo "<br/>time_ending_solr: " . $time_ending_solr . "<br/>";

$script_execution_time = $time_ending_solr - $time_starting_solr ;
echo "<br/>script_execution_time: " . $script_execution_time . "<br/>";
*/
?>




