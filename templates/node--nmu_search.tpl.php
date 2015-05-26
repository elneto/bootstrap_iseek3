<?php
/**
 * @file
 * Bartik's theme implementation to display a node.
 *
 */

// print_r($results);

?>


<script type="text/javascript">
	var solrNmuUrl = "/solr-nmu-output";
	var searchType = "#myModal";

	jQuery(document).ready(function() {


		jQuery('#searchQuery').keypress(function (e) {
		  if (e.which == 13) {

			// need to clear out date field - searchDateInput
			jQuery("#searchDateInputFrom").val("");
			jQuery("#searchDateInputTo").val("");

			submitSearch(jQuery("#searchQuery").val(), 0, "", "", "", 0);
			return false;
		  }
		});
		
		jQuery("#searchTrigger").click(function(){ 

			// need to clear out date field - searchDateInput
			jQuery("#searchDateInputFrom").val("");
			jQuery("#searchDateInputTo").val("");

			submitSearch(jQuery("#searchQuery").val(), 0, "", "", "", 0);
		});	

		jQuery('.input-group.date').datepicker({
			format: "yyyy-mm-dd",
			endDate: "today",
			autoclose: true,
			todayHighlight: true})

			// Listen for the change
			// 24 March -- don't listen for change - make user submit form
			.on('changeDate', dateChangedOn);

		function dateChangedOn(ev) {
// console.log("changeDateOn: on event called: " + jQuery("#searchDateInput").val());
			submitSearch(jQuery("#searchQuery").val(), 0, returnSelectedFacetCheckboxes(), "", "", 0);
		}			
		
		submitSearch("", 0, "", "", "", 0);
		
	});

	function submitSearch(q, start, fq, sort, sort_dir, exact) {

		jQuery("#resultsArea").addClass("loading");
		jQuery("#nmu-search-form").addClass("loading");
		
		var checkedSort = "relevance";
		var checkedSort_dir = "asc";
		if (sort.length > 0 && sort_dir.length > 0) {
			checkedSort = sort;
			checkedSort_dir = sort_dir;
		}
		var checkedQ = q;
/*		if (exact == 0) {
			checkedQ = checkedQ + "*";
		}
*/
/*
		var checkedFq = "";
		if (fq.length > 0) {
			checkedFq = "fq:" + fq;
		}
*/
		var solrQueryUrl = solrNmuUrl + "/" + checkedQ + "/" + start + "/" + checkedSort + "/" + checkedSort_dir + "?fq=" + fq;

 // console.log("solrQueryUrl:" + solrQueryUrl);
		
		jQuery.ajax({
			url: solrQueryUrl,
			type: 'GET',
			dataType: 'json',
			success: loadData,
			error: function(data) {
			}
		});
	}

	function loadData(data) {
	
		jQuery( "#nmu-search-form-facets" ).empty();
		jQuery( "#resultsArea" ).empty();
		
		var start = data.response.start;
		var rows_per_page = 10;
		var resultsStart = data.response.start + 1;
		var resultsEnd = rows_per_page;
		var resultsFound = data.response.numFound;
		
		
		jQuery("#resultsArea").removeClass("loading");
		jQuery("#nmu-search-form").removeClass("loading");
		
		
		if (resultsFound == 0) {

			jQuery('#searchQuery').keypress(function (e) {
			  if (e.which == 13) {
				submitSearch(jQuery("#searchQuery").val(), 0, "", "", "", 0);
				return false;
			  }
			});

			jQuery("#searchTrigger").click(function(){ 
				submitSearch(jQuery("#searchQuery").val(), 0, "", "", "", 0);
			});

			jQuery(searchType + " .nmu-pagination" ).empty();

			jQuery("#resultsArea").append("<p>Sorry, no results could be found.</p>");
		
		} else {
		
			if (resultsFound < rows_per_page) {
				resultsEnd = resultsFound;
			} else if (resultsFound < (resultsStart + rows_per_page - 1)) {
				resultsEnd = resultsFound;
			} else {
				resultsEnd = resultsStart + rows_per_page - 1;
			}
			var total_pages = Math.floor(resultsFound / rows_per_page) ;
			var current_page = start / rows_per_page;

			
			// facets
// console.log("data.responseHeader.params.fq:" + data.responseHeader.params.fq)			

			var typeFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_field_type,function(index,value){
				typeFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_field_typeFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + "name=\"sm_field_typeFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>";

			});

			if (typeFacetCheckboxes.length) {	
			
				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by type</div><div class=\"controls facetControls\">" + typeFacetCheckboxes + "</div>");
			
			}

			
			var regionsFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_vid_NMU_Regions,function(index,value){
			
				regionsFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_vid_NMU_RegionsFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + " name=\"sm_vid_NMU_RegionsFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>"
			
			});

			if (regionsFacetCheckboxes.length) {
			
				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by region</div><div class=\"controls facetControls\">" + regionsFacetCheckboxes + "</div>");
			
			}
			
			var bulletin_IssuesFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_vid_NMU_Bulletin_Issues,function(index,value){
				bulletin_IssuesFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_vid_NMU_Bulletin_IssuesFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + " name=\"sm_vid_NMU_Bulletin_IssuesFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>";
			});

			if (bulletin_IssuesFacetCheckboxes.length) {
			
				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by bulletin issues</div><div class=\"controls facetControls\">" + bulletin_IssuesFacetCheckboxes + "</div>");
			
			}
			
			var sourceFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_vid_NMU_Source,function(index,value){
				sourceFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_vid_NMU_SourceFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + " name=\"sm_vid_NMU_SourceFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>";
			});

			if (sourceFacetCheckboxes.length) {
			
				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by source</div><div class=\"controls facetControls\">" + sourceFacetCheckboxes + "</div>");
			
			}
			
			var clipping_IssuesFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_vid_NMU_Clipping_Issues,function(index,value){
				clipping_IssuesFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_vid_NMU_Clipping_IssuesFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + " name=\"sm_vid_NMU_Clipping_IssuesFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>";
			});

			if (clipping_IssuesFacetCheckboxes.length) {
			
				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by clipping issue</div><div class=\"controls facetControls\">" + clipping_IssuesFacetCheckboxes + "</div>");
			
			}

			var authorFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_vid_NMU_Author,function(index,value){
				authorFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_vid_NMU_AuthorFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + " name=\"sm_vid_NMU_AuthorFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>";
			});
			
			if (authorFacetCheckboxes.length) {

				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by author</div><div class=\"controls facetControls\">" + authorFacetCheckboxes + "</div>");
			
			}
			
			var country_of_SourceFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_vid_NMU_Country_of_Source,function(index,value){
				country_of_SourceFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_vid_NMU_Country_of_SourceFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + " name=\"sm_vid_NMU_Country_of_SourceFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>";
			});

			if (country_of_SourceFacetCheckboxes.length) {
			
				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by source country</div><div class=\"controls facetControls\">" + country_of_SourceFacetCheckboxes + "</div>");
			
			}

			var type_of_SourceFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_vid_NMU_Type_of_Source,function(index,value){
				type_of_SourceFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_vid_NMU_Type_of_SourceFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + " name=\"sm_vid_NMU_Type_of_SourceFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>";
			});

			if (type_of_SourceFacetCheckboxes.length) {
			
				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by source type</div><div class=\"controls facetControls\">" + type_of_SourceFacetCheckboxes + "</div>");
				
			}	

			var type_of_ArticleFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_vid_NMU_Type_of_Article,function(index,value){
				type_of_ArticleFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_vid_NMU_Type_of_ArticleFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + " name=\"sm_vid_NMU_Type_of_ArticleFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>";
			});

			if (type_of_ArticleFacetCheckboxes.length) {
			
				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by article type</div><div class=\"controls facetControls\">" + type_of_ArticleFacetCheckboxes + "</div>");

			}	
				
			var un_mentionFacetCheckboxes = "";

			jQuery.each(data.facet_counts.facet_fields.sm_field_un_mention,function(index,value){
				un_mentionFacetCheckboxes += "<label><input class=\"nmuFacetCheckbox sm_field_un_mentionFacet\" type=\"checkbox\"" + returnChecked(index, data.responseHeader.params.fq) + " name=\"sm_field_un_mentionFacet\" value=\"" + index + "\">" + index + "(" + value + ")</input></label>";
			});

			if (un_mentionFacetCheckboxes.length) {
			
				jQuery("#nmu-search-form-facets").append("<div class=\"muted\">Refine by UN mention</div><div class=\"controls facetControls\">" + un_mentionFacetCheckboxes + "</div>");
			
			}
			
			// ADD DATE RANGE!!!	

			jQuery(".nmuFacetCheckbox").click(function(){ 
				submitSearch(jQuery("#searchQuery").val(), 0, returnSelectedFacetCheckboxes(), "", "", 0);
			});


			jQuery("#resultsArea").append("<p>Results " + resultsStart + "-" + resultsEnd + " of " + resultsFound + "</p>");


			jQuery("#resultsArea").append("<ul class=\"search-results apachesolr_search-results\">");

			jQuery.each(data.response.docs,function(i,doc){
				var label = doc.label != undefined ? doc.label : "";
				var path_alias = doc.path_alias != undefined ? doc.path_alias : "";
				var dm_field_published_date = doc.dm_field_published_date != undefined ? doc.dm_field_published_date : "";

				jQuery("#resultsArea").append("<li class=\"search-result\"><h4 class=\"title\"><a href=\"/" + path_alias + "\">" + label + "</a></h4><div>" + dm_field_published_date + "</div></li>");		

			});

			jQuery("#resultsArea").append("</ul>");

			jQuery(".nmu-pagination").empty();
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

			if (lower_page_limit < 0) {
				lower_page_limit = 0;
			}


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
			jQuery(".nmu-pagination").append(pagination);

		}	
	}


	function returnSelectedFacetCheckboxes() {
		var multivalue_facet_queryphrase_local = "";
		var multivalue_facet_sm_field_type = "";
		var multivalue_facet_sm_vid_NMU_Regions = "";
		var multivalue_facet_sm_vid_NMU_Bulletin_Issues = "";
		var multivalue_facet_sm_vid_NMU_Source = "";
		var multivalue_facet_sm_vid_NMU_Clipping_Issues = "";
		var multivalue_facet_sm_vid_NMU_Author = "";
		var multivalue_facet_sm_vid_NMU_Country_of_Source = "";
		var multivalue_facet_sm_vid_NMU_Type_of_Source = "";
		var multivalue_facet_sm_vid_NMU_Type_of_Article = "";
		var multivalue_facet_sm_field_un_mention = "";
		var multivalue_facet_searchDateInputFrom = "";
		var multivalue_facet_searchDateInputTo = "";
		

		// sm_field_typeFacet
		jQuery(".nmuFacetCheckbox.sm_field_typeFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_field_type.length > 0) {	
					multivalue_facet_sm_field_type += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_field_type = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_field_type.length > 0) {
			multivalue_facet_queryphrase_local += "sm_field_type:(" + multivalue_facet_sm_field_type + ")";
		}	

		// sm_vid_NMU_Regions
		jQuery(".nmuFacetCheckbox.sm_vid_NMU_RegionsFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_vid_NMU_Regions.length > 0) {	
					multivalue_facet_sm_vid_NMU_Regions += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_vid_NMU_Regions = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_vid_NMU_Regions.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND sm_vid_NMU_Regions:(" + multivalue_facet_sm_vid_NMU_Regions + ")";
			} else {
				multivalue_facet_queryphrase_local += "sm_vid_NMU_Regions:(" + multivalue_facet_sm_vid_NMU_Regions + ")";
			}		
		}	

		// sm_vid_NMU_Bulletin_Issues
		jQuery(".nmuFacetCheckbox.sm_vid_NMU_Bulletin_IssuesFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_vid_NMU_Bulletin_Issues.length > 0) {	
					multivalue_facet_sm_vid_NMU_Bulletin_Issues += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_vid_NMU_Bulletin_Issues = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_vid_NMU_Bulletin_Issues.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND sm_vid_NMU_Bulletin_Issues:(" + multivalue_facet_sm_vid_NMU_Bulletin_Issues + ")";
			} else {
				multivalue_facet_queryphrase_local += "sm_vid_NMU_Bulletin_Issues:(" + multivalue_facet_sm_vid_NMU_Bulletin_Issues + ")";
			}		
		}	
		
		// multivalue_facet_sm_vid_NMU_Source
		jQuery(".nmuFacetCheckbox.sm_vid_NMU_SourceFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_vid_NMU_Source.length > 0) {	
					multivalue_facet_sm_vid_NMU_Source += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_vid_NMU_Source = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_vid_NMU_Source.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND sm_vid_NMU_Source:(" + multivalue_facet_sm_vid_NMU_Source + ")";
			} else {
				multivalue_facet_queryphrase_local += "sm_vid_NMU_Source:(" + multivalue_facet_sm_vid_NMU_Source + ")";
			}		
		}			

		// multivalue_facet_sm_vid_NMU_Clipping_Issues
		jQuery(".nmuFacetCheckbox.sm_vid_NMU_Clipping_IssuesFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_vid_NMU_Clipping_Issues.length > 0) {	
					multivalue_facet_sm_vid_NMU_Clipping_Issues += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_vid_NMU_Clipping_Issues = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_vid_NMU_Clipping_Issues.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND sm_vid_NMU_Clipping_Issues:(" + multivalue_facet_sm_vid_NMU_Clipping_Issues + ")";
			} else {
				multivalue_facet_queryphrase_local += "sm_vid_NMU_Clipping_Issues:(" + multivalue_facet_sm_vid_NMU_Clipping_Issues + ")";
			}		
		}			

		// multivalue_facet_sm_vid_NMU_Author
		jQuery(".nmuFacetCheckbox.sm_vid_NMU_AuthorFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_vid_NMU_Author.length > 0) {	
					multivalue_facet_sm_vid_NMU_Author += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_vid_NMU_Author = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_vid_NMU_Author.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND sm_vid_NMU_Author:(" + multivalue_facet_sm_vid_NMU_Author + ")";
			} else {
				multivalue_facet_queryphrase_local += "sm_vid_NMU_Author:(" + multivalue_facet_sm_vid_NMU_Author + ")";
			}		
		}			

		// multivalue_facet_sm_vid_NMU_Country_of_Source
		jQuery(".nmuFacetCheckbox.sm_vid_NMU_Country_of_SourceFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_vid_NMU_Country_of_Source.length > 0) {	
					multivalue_facet_sm_vid_NMU_Country_of_Source += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_vid_NMU_Country_of_Source = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_vid_NMU_Country_of_Source.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND sm_vid_NMU_Country_of_Source:(" + multivalue_facet_sm_vid_NMU_Country_of_Source + ")";
			} else {
				multivalue_facet_queryphrase_local += "sm_vid_NMU_Country_of_Source:(" + multivalue_facet_sm_vid_NMU_Country_of_Source + ")";
			}		
		}				

		// multivalue_facet_sm_vid_NMU_Type_of_Source
		jQuery(".nmuFacetCheckbox.sm_vid_NMU_Type_of_SourceFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_vid_NMU_Type_of_Source.length > 0) {	
					multivalue_facet_sm_vid_NMU_Type_of_Source += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_vid_NMU_Type_of_Source = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_vid_NMU_Type_of_Source.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND sm_vid_NMU_Type_of_Source:(" + multivalue_facet_sm_vid_NMU_Type_of_Source + ")";
			} else {
				multivalue_facet_queryphrase_local += "sm_vid_NMU_Type_of_Source:(" + multivalue_facet_sm_vid_NMU_Type_of_Source + ")";
			}		
		}		

		// multivalue_facet_sm_vid_NMU_Type_of_Article
		jQuery(".nmuFacetCheckbox.sm_vid_NMU_Type_of_ArticleFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_vid_NMU_Type_of_Article.length > 0) {	
					multivalue_facet_sm_vid_NMU_Type_of_Article += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_vid_NMU_Type_of_Article = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_vid_NMU_Type_of_Article.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND sm_vid_NMU_Type_of_Article:(" + multivalue_facet_sm_vid_NMU_Type_of_Article + ")";
			} else {
				multivalue_facet_queryphrase_local += "sm_vid_NMU_Type_of_Article:(" + multivalue_facet_sm_vid_NMU_Type_of_Article + ")";
			}		
		}		

		// multivalue_facet_sm_field_un_mention
		jQuery(".nmuFacetCheckbox.sm_field_un_mentionFacet").each(function(){
			if (jQuery(this).prop("checked")) {
				if (multivalue_facet_sm_field_un_mention.length > 0) {	
					multivalue_facet_sm_field_un_mention += " OR \"" + jQuery(this).attr("value") + "\"";
				} else {
					multivalue_facet_sm_field_un_mention = "\"" + jQuery(this).attr("value") + "\"" ;
				}		
			}
		});

		if (multivalue_facet_sm_field_un_mention.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND sm_field_un_mention:(" + multivalue_facet_sm_field_un_mention + ")";
			} else {
				multivalue_facet_queryphrase_local += "sm_field_un_mention:(" + multivalue_facet_sm_field_un_mention + ")";
			}		
		}		

		
		// multivalue_facet_searchDateInputFrom
/*
		multivalue_facet_searchDateInput = jQuery("#searchDateInput").val();	
		
		if (multivalue_facet_searchDateInput.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND dm_field_nmu_published_date:[" + multivalue_facet_searchDateInput + "T00:00:00Z TO " + multivalue_facet_searchDateInput + "T23:59:59Z]";
			} else {
				multivalue_facet_queryphrase_local += "dm_field_nmu_published_date:[" + multivalue_facet_searchDateInput + "T00:00:00Z TO " + multivalue_facet_searchDateInput + "T23:59:59Z]";
			}		
		}	
*/		
		// multivalue_facet_searchDateInputFrom

		multivalue_facet_searchDateInputFrom = jQuery("#searchDateInputFrom").val();	
		multivalue_facet_searchDateInputTo = jQuery("#searchDateInputTo").val();	
		
		if (multivalue_facet_searchDateInputFrom.length > 0 && multivalue_facet_searchDateInputTo.length > 0) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND dm_field_nmu_published_date:[" + multivalue_facet_searchDateInputFrom + "T00:00:00Z TO " + multivalue_facet_searchDateInputTo + "T23:59:59Z]";
			} else {
				multivalue_facet_queryphrase_local += "dm_field_nmu_published_date:[" + multivalue_facet_searchDateInputFrom + "T00:00:00Z TO " + multivalue_facet_searchDateInputTo + "T23:59:59Z]";
			}		
		} else if (multivalue_facet_searchDateInputFrom.length > 0 ) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND dm_field_nmu_published_date:[" + multivalue_facet_searchDateInputFrom + "T00:00:00Z TO " + multivalue_facet_searchDateInputFrom + "T23:59:59Z]";
			} else {
				multivalue_facet_queryphrase_local += "dm_field_nmu_published_date:[" + multivalue_facet_searchDateInputFrom + "T00:00:00Z TO " + multivalue_facet_searchDateInputFrom + "T23:59:59Z]";
			}			
		} else if (multivalue_facet_searchDateInputTo.length > 0 ) {
			if (multivalue_facet_queryphrase_local.length > 0) { 			
				multivalue_facet_queryphrase_local += " AND dm_field_nmu_published_date:[" + multivalue_facet_searchDateInputTo + "T00:00:00Z TO " + multivalue_facet_searchDateInputTo + "T23:59:59Z]";
			} else {
				multivalue_facet_queryphrase_local += "dm_field_nmu_published_date:[" + multivalue_facet_searchDateInputTo + "T00:00:00Z TO " + multivalue_facet_searchDateInputTo + "T23:59:59Z]";
			}			
		}	

		return multivalue_facet_queryphrase_local;
	}

	function returnChecked(incomingIndex, incomingFq) {
// console.log("2 incomingIndex: " + incomingIndex + " in incomingFq: " + incomingFq );
		var patt = new RegExp(incomingIndex);
		// console.log(patt.test(incomingFq));	
		var facetChecked = " ";
		if (patt.test(incomingFq)) {
			facetChecked = " checked ";
		}
		return facetChecked;
	}


</script>

<style type="text/css">
.loading {
	opacity: 0.3;
}
#nmu-search-form label {
	display: block;
}
</style>


<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

   <section id="search-main" class="clearfix container-fluid">

	<div class="row">

		<div class="col-sm-4 col-md-3 sidebar">
		
			<div class="panel-group">
				<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							News Monitoring Unit search
						</h4>
					</div>
					<div class="panel-body">

						<form class="search-form" id="nmu-search-form" action="#">

							<div class="input-group">
								<input type="text" class="form-control" id="searchQuery" name="query">
								<span class="input-group-btn">
									<button class="btn btn-primary" type="button" id="searchTrigger" value="Go">Go</button>
								</span>
							</div>

							<div class="muted">From date 2:51</div>

							<div class="input-group date">
								<input type="text" class="form-control" id="searchDateInputFrom">
								<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
							</div>

							<div class="muted">To date</div>

							<div class="input-group date">
								<input type="text" class="form-control" id="searchDateInputTo">
								<span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
							</div>
							
							<div id="nmu-search-form-facets">
							
							
							
							</div>

						</form>
					</div>
				</div>
			</div>	
		</div>

		<div class="col-sm-8 col-md-9 main">


			<div id="resultsArea">
			


				<nav id="pager-bottom">
				 <div class="pagination pagination-large nmu-pagination">

					

				 </div>
				</nav>

			</div> <!-- resultsArea -->

			</div> <!-- span10 -->
      </div> <!-- row-fluid -->
   </section>
</div>

