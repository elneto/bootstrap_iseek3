version 6.14

<?php

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



?>

<!--
<script src="http://visitdev.un.org/misc/jquery.js?v=1.4.4"></script>
-->

<script type="text/javascript">

	// var solrUrl = "http://intra-srch.un.org/solr/iseek/spell";
	var solrUrl = "https://10.250.35.88:7984/solr/iseek/spell";

	// https://10.250.35.88:7984/solr/iseek/select?q=*%3A*&wt=json&indent=true iseek: d6jAXEchEfr6nuCh

	
	jQuery(document).ready(function() {
	
		// submitSearch();
		
		jQuery( "#searchTriggerSimple" ).click(function() {
			// alert('searchTriggerSimple');
			submitSearch(jQuery("#searchSimpleInput").val());
		});
		
	});		

	function submitSearch(q) {
		// alert('submit search: ' + q);
		jQuery.ajax({
			url: solrUrl,
			type: 'GET',
			data: {'wt':'json', 'q':q },
			dataType: 'jsonp',
			jsonp : 'json.wrf',			
			success: loadData,

			error: function(data) { 
				alert('Error123'); 
			}
		});
	}

	function loadData(data) {
		// alert('loadData 123');

		jQuery( ".gcd_resultsResults" ).empty();

		jQuery( ".gcd_resultsResults" ).append(data.response.start + "-" + (data.response.start + 10) + " of " + data.response.numFound);	

		jQuery( "tbody" ).empty();

		jQuery.each(data.response.docs,function(i,doc){
			// alert(doc.firstName + ' ' + doc.lastName);
			jQuery( "tbody" ).append( "<tr><td>" + doc.title + "</td><td>" + doc.lastName + "</td><td>" + doc.firstName + "</td><td>" + doc.email + "</td><td>" + doc.phoneDisplay1 + "</td><td>" + doc.dutyStation + "</td><td>" + doc.building + "</td><td>" + doc.room + "</td><td>" + doc.organizationalUnit + "</td></tr>" );
		});

	}


/*	
function GetURLParameter(sParam) {
    var sPageURL = window.location.search.substring(1);
    var sURLVariables = sPageURL.split('&');
    for (var i = 0; i < sURLVariables.length; i++) {
        var sParameterName = sURLVariables[i].split('=');
        if (sParameterName[0] == sParam) {
            return sParameterName[1];
        }
    }
}​
*/


	
</script>



<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
  <section id="search-main" class="clearfix container-fluid">
    <div class="row">
			<div class="span2">
				<form class="search-form" id="search-form-simple" >
					<input type="text" id="searchSimpleInput" class="input-small" name="query" value="">
					<button class="btn btn-primary" type="button" id="searchTriggerSimple" value="Go" >Go</button>
				</form>	
			</div>

			<div class="span4">

				<div id="resultsArea">
				
					<h3 class="gcd_results"></h3>
				
					<table class="table table-striped">
						<thead>
							<tr>
								<?php
									foreach ($iseekFields as $header_key => $header_value) {
								?>
										<th>
											<?php echo $header_value; ?>
										</th>
								<?php
									}
								?>
							</tr>
			    		</thead>
						<tbody>


						</tbody>
					</table>

				</div> <!-- resultsArea -->
    	</div> <!-- col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main -->
    </div> <!-- row -->
  </section>
</div>
