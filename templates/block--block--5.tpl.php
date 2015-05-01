<style type="text/css">
.contentTypeBtn {
	margin: 2px 4px;
}
.siteSearch_pagination {
	text-align: center;
}
#mySiteSearchModal .panel-body {
	padding: 5px;
}
 
<!--
tbody > tr > td {
	font-size: small;
}
.modal-header .input-group, .modal-title {
	margin-bottom: 10px;
}
.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active {

} 
.loading {
	opacity: 0.3;
}
.modal-body table {
	table-layout: fixed;
	word-wrap: break-word;
}
-->
</style>

<?php

/**
 * @file
 * Default theme implementation to display a block.
 *
 * Available variables:
 * - $block->subject: Block title.
 * - $content: Block content.
 * - $block->module: Module that generated the block.
 * - $block->delta: An ID for the block, unique within each module.
 * - $block->region: The block region embedding the current block.
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - block: The current template type, i.e., "theming hook".
 *   - block-[module]: The module generating the block. For example, the user
 *     module is responsible for handling the default user navigation block. In
 *     that case the class would be 'block-user'.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Helper variables:
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $block_zebra: Outputs 'odd' and 'even' dependent on each block region.
 * - $zebra: Same output as $block_zebra but independent of any block region.
 * - $block_id: Counter dependent on each block region.
 * - $id: Same output as $block_id but independent of any block region.
 * - $is_front: Flags true when presented in the front page.
 * - $logged_in: Flags true when the current user is a logged-in member.
 * - $is_admin: Flags true when the current user is an administrator.
 * - $block_html_id: A valid HTML ID and guaranteed unique.
 *
 * @see template_preprocess()
 * @see template_preprocess_block()
 * @see template_process()
 *
 * @ingroup themeable
 */
 
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
 
?>

<script type="text/javascript">

	// var solrUrl = "http://intra-srch.un.org/solr/iseek/spell";
	// var solrUrl = "https://iseek:d6jAXEchEfr6nuCh@nyvm1482.stc.un.org:7984/solr/iseek/spell";

	var solrSiteUrl = "/solr-sitesearch-output";

	
	
	jQuery(document).ready(function() {
	
		// submitSearch();

/*		
		jQuery("a").click(function(e){
			 e.preventDefault(); 
		 });
*/
		jQuery('#siteSearchSimpleInput').keypress(function (e) {
	
		  if (e.which == 13) {
  		    console.log('siteSearchSimpleInput keypress enter 3aa');

			submitSiteSearch(jQuery("#siteSearchSimpleInput").val(), 0, "", "", "", 0);

  		    console.log('siteSearchSimpleInput keypress enter 3bb');

			jQuery("#siteSearchSimpleInputInModal").val(jQuery("#siteSearchSimpleInput").val());

			jQuery('#mySiteSearchModal').modal('toggle');
			
			return false;

		  }
		});
		 
		 
		
		jQuery('#siteSearchSimpleInputInModal').keypress(function (e) {
	
		  if (e.which == 13) {
  		    console.log('siteSearchSimpleInputInModal keypress enter 3aa');

			submitSiteSearch(jQuery("#siteSearchSimpleInputInModal").val(), 0, "", "", "", 0);

  		    console.log('siteSearchSimpleInputInModal keypress enter 3bb');

			return false;

		  }
		});



		// from the iSeek main page
		jQuery( "#siteSearchTriggerSimple" ).click(function() {
			submitSiteSearch(jQuery("#siteSearchSimpleInput").val(), 0, "", "", "", 0);
			jQuery("#siteSearchSimpleInputInModal").val(jQuery("#siteSearchSimpleInput").val());
		});

		// from the modal	
		jQuery( "#siteSearchTriggerSimpleInModal" ).click(function() {
			submitSiteSearch(jQuery("#siteSearchSimpleInputInModal").val(), 0, "", "", "", 0);
		});
		
	});		

	function submitSiteSearch(q, start, fq, sort, sort_dir, exact) {

		jQuery(".modal-body").addClass("loading");	

		console.log('submit siteSearch: ' + q);

		var checkedSort = "relevance";	
		var checkedSort_dir = "asc";	

		if (sort.length > 0 && sort_dir.length > 0) {
			checkedSort = sort;
			checkedSort_dir = sort_dir;	
		}

		var checkedQ = q;	

		console.log('submit siteSearch exact: ' + exact);

/*		
		if (exact == 0) {
			checkedQ = checkedQ + "*";
		}
*/		
		console.log(solrSiteUrl + "/" + checkedQ + "/" + start + "/" + checkedSort + "/" + checkedSort_dir + "?fq=" + fq);


		jQuery.ajax({
			url: solrSiteUrl + "/" + checkedQ + "/" + start + "/" + checkedSort + "/" + checkedSort_dir + "?fq=" + fq,
			type: 'GET',
			// data: {'wt':'json', 'q':q },
			// data: {'q':q },
			dataType: 'json',
			// jsonp : 'json.wrf',			
			success: loadSiteSearchData,

			error: function(data) {
              // console.dir(data);			
			  // alert('Error1234'); 
			}
		});
	}

	function loadSiteSearchData(data) {

		console.log("in loadSiteSearchData 1a");
	
		// console.dir(data);
		
		// header
		
		jQuery( "#mySiteSearchModal .siteSearch_results" ).empty();
		jQuery( "#mySiteSearchModal .contentTypeButtons" ).empty();
		jQuery( "#mySiteSearchModal .panel .panel-body .links.inline" ).empty();
		jQuery( "thead > tr" ).empty();
		jQuery( ".wildcard" ).empty();

		// set up variables
		// var start = 0;
		var start = data.response.start;
		var rows_per_page = 10;
		
		// number of results	
		var resultsStart = data.response.start + 1;
		var resultsEnd = rows_per_page;
		var resultsFound = data.response.numFound;
		
		if (resultsFound < rows_per_page) {
			resultsEnd = resultsFound;
		} else if (resultsFound < (resultsStart + rows_per_page - 1)) {
			resultsEnd = resultsFound;
		} else {
			resultsEnd = resultsStart + rows_per_page - 1;
		}

		// pagination
		var total_pages = Math.floor(resultsFound / rows_per_page) ;
		var current_page = start / rows_per_page;
		// var current_page = data.response.start / rows_per_page;

		
		jQuery( "#mySiteSearchModal .siteSearch_results" ).append("Results " + resultsStart + "-" + resultsEnd + " of " + resultsFound);	

		console.log("in loadSiteSearchData 1b");
		
		// facets	

		// console.log(data.facet_counts.facet_fields.dutyStation);
		
		jQuery( "#mySiteSearchModal .siteSearch_results" ).append("<br/>");	

		jQuery.each(data.facet_counts.facet_fields.bundle_name,function(index,value){

			var buttonClass = "btn btn-default contentTypeBtn";	

			if (typeof data.responseHeader.params.fq !== 'undefined') {
				if (data.responseHeader.params.fq.indexOf(index) > -1) {
					buttonClass = "btn btn-primary contentTypeBtn active";
				}
			}	
		
			console.log("" + index + ": " + value);
			
			jQuery( "#mySiteSearchModal .contentTypeButtons" ).append("<button type=\"button\" value=\"" + index + "\" class=\"" + buttonClass  + "\">" +  index + "</button>");
		
		});

		// sort
		
		jQuery( ".panel .panel-body .links.inline" ).append("<li>Sort by: </li>");
		jQuery( ".panel .panel-body .links.inline" ).append("<li><a class=\"sort_link\" id=\"sort_link_ds_created_desc\" href=\"ds_created_desc\">Date descending</a></li>");
		jQuery( ".panel .panel-body .links.inline" ).append("<li><a class=\"sort_link\" id=\"sort_link_ds_created_asc\" href=\"ds_created_asc\">Date ascending</a></li>");
		jQuery( ".panel .panel-body .links.inline" ).append("<li><a class=\"sort_link\" id=\"sort_link_relevance\" href=\"relevance\">Relevance</a></li>");

		if (typeof data.responseHeader.params.sort !== 'undefined') {
			var sort_from_solr = data.responseHeader.params.sort.split(" ");
			if (sort_from_solr[1] == "desc") {			
				jQuery( "#sort_link_ds_created_desc" ).append("<i class=\"glyphicon glyphicon-arrow-down\"></i>");				
			} else {
				jQuery( "#sort_link_ds_created_asc" ).append("<i class=\"glyphicon glyphicon-arrow-up\"></i>");				
			}
		} else {
			jQuery( "#sort_link_relevance" ).append("<i class=\"glyphicon glyphicon-arrow-down\"></i>");
		}		

/*		
		var sort_from_solr = data.responseHeader.params.sort.split(" ");

		if (sort_from_solr[1] == "asc") {
			jQuery( "#sort_link_" + sort_from_solr[0] ).append("<i class=\"glyphicon glyphicon-arrow-down\"></i>");
		} else {
			jQuery( "#sort_link_" + sort_from_solr[0] ).append("<i class=\"glyphicon glyphicon-arrow-up\"></i>");
		}
*/		
		
/*
		// set sort in table header
		jQuery( "thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_title\" href=\"title\">Title</a></th>");	
		jQuery( "thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_lastName\" href=\"lastName\">Last name</a></th>");	
		jQuery( "thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_firstName\" href=\"firstName\">First name</a></th>");	
		jQuery( "thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_email\" href=\"email\">E-mail</a></th>");	
		jQuery( "thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_phoneDisplay1\" href=\"phoneDisplay1\">Phone</a></th>");	
		jQuery( "thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_dutyStation\" href=\"dutyStation\">Duty station</a></th>");	
		jQuery( "thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_building\" href=\"building\">Building</a></th>");	
		jQuery( "thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_room\" href=\"room\">Room</a></th>");	
		jQuery( "thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_organizationalUnit\" href=\"organizationalUnit\">Org unit</a></th>");	

		// remove existing sorts
		jQuery( ".glyphicon-arrow-down" ).remove();
		jQuery( ".glyphicon-arrow-up" ).remove();

		// 	

		var sort_from_solr = data.responseHeader.params.sort.split(" ");

		if (sort_from_solr[1] == "asc") {
			jQuery( "#sort_link_" + sort_from_solr[0] ).append("<i class=\"glyphicon glyphicon-arrow-down\"></i>");
		} else {
			jQuery( "#sort_link_" + sort_from_solr[0] ).append("<i class=\"glyphicon glyphicon-arrow-up\"></i>");
		}
		// <i class="glyphicon glyphicon-arrow-up"></i>
*/		
		// populate table

		console.log("in loadSiteSearchData 1c");
		
		jQuery( "#mySiteSearchModal tbody" ).empty();

		jQuery.each(data.response.docs,function(i,doc){
			var label = doc.label != undefined ? doc.label : "";
			var ss_language = doc.ss_language != undefined ? doc.ss_language : "";
			var path_alias = doc.path_alias != undefined ? doc.path_alias : "";
			var teaser = doc.teaser != undefined ? doc.teaser : "";
			var email = doc.email != undefined ? doc.email : "";
			var bundle_name = doc.bundle_name != undefined ? doc.bundle_name : "";
			var ds_created = doc.ds_created != undefined ? doc.ds_created : "";

			if (ss_language == 'fr') {
				path_alias = "fr/" + path_alias;
			}
	
			if (ds_created.length >= 10) {
				ds_created = ds_created.substring(0,10);
			}
	
			jQuery( "#mySiteSearchModal tbody" ).append( "<tr><td><h4 class=\"title\"><a href=\"/" + path_alias + "\" target=\"_blank\">" + label + "</a></h4><div class=\"search-snippet-info\"><p class=\"search-snippet\">" + teaser + "</p><p class=\"slug\">" + bundle_name + " - " + ds_created + "</p></div></td></tr>" );
			
			// jQuery( "#mySiteSearchModal tbody" ).append( "<tr><td>HELLOW!</td></tr>" );
			
		});

		console.log("in loadSiteSearchData 1d");
		
		
		// pagination

		jQuery( "#mySiteSearchModal .siteSearch_pagination" ).empty();
		
		// only show n links around the current_page
		var lower_page_limit = 0;
		var upper_page_limit = total_pages;
		var page_links_to_show = 10;


		if ((current_page < (page_links_to_show / 2)) && (total_pages > page_links_to_show)) {
			lower_page_limit = 0;
			upper_page_limit = page_links_to_show;
		} else if ((current_page <= (page_links_to_show / 2)) && (total_pages <= page_links_to_show)) {
			lower_page_limit = 0;
			upper_page_limit = total_pages;
		} else if ((current_page + page_links_to_show) > total_pages) {
			lower_page_limit = total_pages - page_links_to_show;
			upper_page_limit = total_pages;
		} else {
			lower_page_limit = current_page - (page_links_to_show / 2);
			upper_page_limit = current_page + (page_links_to_show / 2);
		}


		// create pagination
		
		var pagination = "<nav><ul class=\"pagination\">";

		pagination += "<li><a class=\"pagination_link\" href=\"0\">« first</a></li>";

		if (start > 0) {
			pagination += "<li><a class=\"pagination_link\" href=\"" + ((current_page - 1) * rows_per_page) + "\">‹ previous</a></li>";
		}
		for (var pager_i = lower_page_limit; pager_i <= upper_page_limit; pager_i++ ) {
			if (current_page == pager_i) {
				pagination += "<li class=\"active pagination_link\"><a href=\"" + (pager_i * rows_per_page) + "\">" + (pager_i + 1) + "</a></li>";
			} else {
				pagination += "<li><a class=\"pagination_link\" href=\"" + (pager_i * rows_per_page) + "\">" + (pager_i + 1) + "</a></li>";
			}
		}
		if (resultsFound - (current_page * rows_per_page) > rows_per_page) {
			pagination += "<li><a class=\"pagination_link\" href=\"" + ((current_page + 1) * rows_per_page)  + "\">next ›</a></li>";
		}
		
		pagination += "<li><a class=\"pagination_link\" href=\"" + (total_pages * rows_per_page) + "\">last »</a></li>";

		pagination += "</ul></nav>";	

		jQuery( "#mySiteSearchModal .siteSearch_pagination" ).append(pagination);

		// restore modal
		
		jQuery("#mySiteSearchModal .modal-body").removeClass("loading");	

		// add event listeners for clicks from dynamically created content
	
		// pagination from the modal -- must be added here	
		jQuery("#mySiteSearchModal .pagination_link").click(function(event){

			console.log("in siteSearch pagination_link 1a");
		
			event.preventDefault();

			console.log("in siteSearch pagination_link 1b");

			event.stopPropagation();

			console.log("in siteSearch pagination_link 1c");

			submitSiteSearch(jQuery("#siteSearchSimpleInputInModal").val(), jQuery(this).attr("href"), returnSelectedContentTypeButtons(), "", "", 0);
			// jQuery("#searchSimpleInputInModal").val(jQuery("#searchSimpleInput").val());

			console.log("in pagination_link 1d");
			
			return false; //for good measure
		});



		jQuery("#mySiteSearchModal .contentTypeBtn").click(function(){ 
		
			// front end
		
			console.log(jQuery(this).attr("value"));
			if (jQuery(this).hasClass("active")) {
				jQuery(this).removeClass("active");
			} else {
				jQuery(this).addClass("active");
			}			
			if (jQuery(this).hasClass("btn-default")) {
				jQuery(this).removeClass("btn-default");
			} else {
				jQuery(this).addClass("btn-default");
			}			
			if (jQuery(this).hasClass("btn-primary")) {
				jQuery(this).removeClass("btn-primary");
			} else {
				jQuery(this).addClass("btn-primary");
			}			

			submitSiteSearch(jQuery("#siteSearchSimpleInputInModal").val(), 0, returnSelectedContentTypeButtons(), "", "", 0);
			
		});
		
		// pagination from the modal -- must be added here	
		jQuery("#mySiteSearchModal a.sort_link").click(function(event){

			event.preventDefault();

			event.stopPropagation();

			console.log("in siteSearch sort_link 7a");
/*
			var sort_click_dir = "asc" ;

			// only override if the link already has a down arrow.
			// otherwise, arrow should be always down ("asc"). 		
			if (jQuery(this).find("i.glyphicon-arrow-down").length) {
				sort_click_dir = "desc";
			} 
*/
/*			
			var sort_click_dir = "asc";

			if (returnSelectedSort() == jQuery(this).attr("href")) {
				sort_click_dir = returnSelectedSortDir();
			}
*/			
	
			var sort_click = "relevance";
			var sort_click_dir = "asc";

			if (jQuery(this).attr("href") == "ds_created_asc") {
				sort_click = "ds_created";			
			} else if (jQuery(this).attr("href") == "ds_created_desc") {
				sort_click = "ds_created";			
				sort_click_dir = "desc";
			}
			
			submitSiteSearch(jQuery("#siteSearchSimpleInputInModal").val(), 0, returnSelectedContentTypeButtons(), sort_click, sort_click_dir, 0);

			console.log("in siteSearch sort_link 7b");
			
			return false; //for good measure
		});
		
	}

	function returnSelectedContentTypeButtons() {

		// iterate over active buttons
		var multivalue_facet_queryphrase_local = "";

		jQuery(".contentTypeBtn.btn-primary").each(function(){
			console.log("btn-primary contentTypes: " + jQuery(this).attr("value"));
			// use quotes to escape spaces
			if (multivalue_facet_queryphrase_local.length > 0) {
				multivalue_facet_queryphrase_local += " OR \"" + jQuery(this).attr("value") + "\"";
			} else {
				multivalue_facet_queryphrase_local += "\"" + jQuery(this).attr("value") + "\"" ;
			}
			});	

		console.log("multivalue_facet_queryphrase_local: " + multivalue_facet_queryphrase_local);

		return multivalue_facet_queryphrase_local;

	}		
	
	
/*	
	
	function returnSelectedSort() {

		var selectedSort = "";
	
		jQuery("a.sort_link").each(function(){
		
			if (jQuery(this).find("i.glyphicon").length) {
			
				selectedSort = jQuery(this).attr("href");
				
			}
		});
		
		return selectedSort;
	
	}

	// the only instance in which we want to change direction is if the 
	// user clicks a header that already has a glyphicon. Otherwise, it should stay the same. 
	
	function returnSelectedSortDir() {

		var selectedSortDir = "asc";
	
		jQuery("a.sort_link").each(function(){
		
			if (jQuery(this).find("i.glyphicon-arrow-down").length) {

				selectedSortDir = "asc";
				
			} else if (jQuery(this).find("i.glyphicon-arrow-up").length) {

				selectedSortDir = "desc";
				
			}
		});
		
		return selectedSortDir;
	
	}
	
	
	function returnSelectedDutyStationButtons() {

		// iterate over active buttons
		var multivalue_facet_queryphrase_local = "";

		jQuery(".dutyStationBtn.btn-primary").each(function(){
			console.log("btn-primary dutyStations: " + jQuery(this).attr("value"));
			// use quotes to escape spaces
			if (multivalue_facet_queryphrase_local.length > 0) {
				multivalue_facet_queryphrase_local += " OR \"" + jQuery(this).attr("value") + "\"";
				// multivalue_facet_queryphrase_local += " OR " + jQuery(this).attr("value") ;
			} else {
				multivalue_facet_queryphrase_local += "\"" + jQuery(this).attr("value") + "\"" ;
				// multivalue_facet_queryphrase_local += jQuery(this).attr("value")  ;

			}
			});	

		console.log("multivalue_facet_queryphrase_local: " + multivalue_facet_queryphrase_local);

		return multivalue_facet_queryphrase_local;

	}		
*/
	
</script>




<section id="<?php print $block_html_id; ?>" class="block clearfix">

	<h2>Search</h2>

	<div class="content"<?php print $content_attributes; ?>>

		<div class="input-group">
			<input class="form-control" name="query" type="text" id="siteSearchSimpleInput"><span class="input-group-btn"><button id="siteSearchTriggerSimple" type="button" class="btn btn-primary" data-toggle="modal" data-target="#mySiteSearchModal">iSeek</button> 
			</span>
		</div>
		
		<form action="http://unitesearch.un.org" class="form-horizontal" role="form" style="margin-top: 10px;">
			<div class="input-group">
				<input class="form-control" name="query" type="text"/><span class="input-group-btn"><button class="btn btn-primary" style="padding-left: 16px; padding-right: 15px;" type="submit">ODS</button> </span>
				<input name="tpl" type="hidden" value="ods"/>
			</div>
		</form>
		
		<div>v 1.44</div>
		
	</div>

</section>
  

  <!-- Modal -->
	<div class="modal fade bs-example-modal-lg" id="mySiteSearchModal" tabindex="-1" role="dialog" aria-labelledby="mySiteSearchModal" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h2 class="modal-title" id="myModalLabel">iSeek Site Search</h2>
			<div class="input-group">
				<input class="form-control" name="query" type="text" id="siteSearchSimpleInputInModal">
				<span class="input-group-btn">
					<button id="siteSearchTriggerSimpleInModal" type="button" class="btn btn-primary">Go</button> 
				</span>
			</div>
			<h5>Narrow by content type:</h5>
			<div class="contentTypeButtons"></div>
		  </div>
		  <div class="modal-body">

			<h3 class="siteSearch_results"></h3>

			<div class="link-wrapper panel panel-default">
				<div class="panel-body">
					<ul class="links inline">

					</ul>
				</div>	
			</div>
					
			<table class="table table-striped">
				<thead>
					<tr>
					</tr>
				</thead>
				<tbody>


				</tbody>
			</table>
			
			<div class="siteSearch_pagination">

			</div>

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>  
 