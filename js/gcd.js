<script type="text/javascript">
	var solrGcdUrl = "/solr-gcd-output";
	var searchType = "#myModal";

	jQuery(document).ready(function() {

                jQuery( "#searchIseekOrOds" ).click(function() {

			var searchApp = jQuery('#select-search :selected').text();
			var searchQuery = jQuery('#input-search-iseek').val();

			if (searchApp == "ODS") {
				window.location.href = "http://unitesearch.un.org/?query=" + searchQuery + "&tpl=ods";
			} else {
				window.location.href = "/iseek-site-search?query=" + searchQuery;
			}
                });
		

		jQuery('#searchSimpleInput').keypress(function (e) {
		  if (e.which == 13) {
			searchType = "#myModal";
			submitSearch(jQuery("#searchSimpleInput").val(), 0, "", "", "", 0);
			jQuery("#searchSimpleInputInModal").val(jQuery("#searchSimpleInput").val());
			jQuery('#myModal').modal('toggle');
			return false;
		  }
		});
		jQuery('#searchSimpleInputInModal').keypress(function (e) {
		  if (e.which == 13) {
			searchType = "#myModal";
			submitSearch(jQuery("#searchSimpleInputInModal").val(), 0, "", "", "", returnExact());
			return false;
		  }
		});
		jQuery( "#searchTriggerSimple" ).click(function() {
			searchType = "#myModal";
			submitSearch(jQuery("#searchSimpleInput").val(), 0, "", "", "", 0);
			jQuery("#searchSimpleInputInModal").val(jQuery("#searchSimpleInput").val());
		});
		jQuery( "#searchTriggerSimpleInModal" ).click(function() {
			searchType = "#myModal";
			submitSearch(jQuery("#searchSimpleInputInModal").val(), 0, "", "", "", returnExact());
		});
		jQuery( "#searchTriggerAdvanced" ).click(function() {
			searchType = "#myModalAdvanced";
			jQuery('#myModalAdvanced').modal('toggle');
		});	
		jQuery( "#searchTriggerAdvancedInSimpleModal" ).click(function() {
			searchType = "#myModalAdvanced";
			jQuery('#myModal').modal('hide');
			jQuery('#myModalAdvanced').modal('toggle');
		});	
		jQuery( "#searchTriggerAdvancedInModal" ).click(function() {
			searchType = "#myModalAdvanced";
			submitSearch(returnAdvancedSearchQuery(), 0, "", "", "", returnExact());
		});

		jQuery('#advFieldlastName').keypress(function (e) {
		  if (e.which == 13) {
			submitSearch(returnAdvancedSearchQuery(), 0, "", "", "", returnExact());
			return false;
		  }
		});		
		jQuery('#advFieldfirstName').keypress(function (e) {
		  if (e.which == 13) {
			submitSearch(returnAdvancedSearchQuery(), 0, "", "", "", returnExact());
			return false;
		  }
		});		
		jQuery('#advFieldemail').keypress(function (e) {
		  if (e.which == 13) {
			submitSearch(returnAdvancedSearchQuery(), 0, "", "", "", returnExact());
			return false;
		  }
		});		
		jQuery('#advFieldphoneDisplay1').keypress(function (e) {
		  if (e.which == 13) {
			submitSearch(returnAdvancedSearchQuery(), 0, "", "", "", returnExact());
			return false;
		  }
		});		
		jQuery('#advFieldorganizationalUnit').keypress(function (e) {
		  if (e.which == 13) {
			submitSearch(returnAdvancedSearchQuery(), 0, "", "", "", returnExact());
			return false;
		  }
		});		
		jQuery('#advFieldroom').keypress(function (e) {
		  if (e.which == 13) {
			submitSearch(returnAdvancedSearchQuery(), 0, "", "", "", returnExact());
			return false;
		  }
		});		

		jQuery("[rel=tooltip]").tooltip({ placement: 'right'});
		
	});

	function submitSearch(q, start, fq, sort, sort_dir, exact) {
		jQuery(searchType + " .modal-body").addClass("loading");
		jQuery(searchType + " #wildcard").addClass("loading");
		var checkedSort = "lastName";
		var checkedSort_dir = "asc";
		if (sort.length > 0 && sort_dir.length > 0) {
			checkedSort = sort;
			checkedSort_dir = sort_dir;
		}
		var checkedQ = q;
		checkedQ = checkedQ.replace(/\//g, ' ');
		if (exact == 0) {
			checkedQ = checkedQ + "*";
		}
		var solrQueryUrl = solrGcdUrl + "/" + checkedQ + "/" + start + "/" + checkedSort + "/" + checkedSort_dir + "?fq=" + fq;
	
console.log("solrQueryUrl: " + solrQueryUrl);
	
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
	
		jQuery( searchType + " .gcd_results" ).empty();
		jQuery( searchType + " .dutyStationButtons" ).empty();
		jQuery( searchType + " thead > tr" ).empty();
		jQuery( searchType + " .wildcard" ).empty();
		jQuery( searchType + " .narrow_by_duty_station_text" ).empty();

		// <h5 id="">Narrow by duty station (You can select multiple duty stations or click again to deselect):</h5>
		
		var start = data.response.start;
		var rows_per_page = 10;
		var resultsStart = data.response.start + 1;
		var resultsEnd = rows_per_page;
		var resultsFound = data.response.numFound;
		
		if (resultsFound == 0) {

			jQuery(searchType + " tbody" ).empty();
			jQuery(searchType + " .gcd_pagination" ).empty();
			jQuery(searchType + " .modal-body").removeClass("loading");
			jQuery(searchType + " .gcd_results").append("Sorry, no results could be found.");
		
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
			jQuery( searchType + " .narrow_by_duty_station_text" ).append("Filter search results by duty station (You can select multiple duty stations or click again to deselect):");

			jQuery( searchType + " .gcd_results" ).append("Results " + resultsStart + "-" + resultsEnd + " of " + resultsFound);
			var wildcardChecked = "";
			if (data.responseHeader.params.q.charAt(data.responseHeader.params.q.length - 1) === '*') {
			} else {
				wildcardChecked = "checked";
			}

			// jQuery( searchType + " .wildcard" ).append("<label><input type=\"checkbox\" name=\"wildcard\" id=\"wildcard\" " + wildcardChecked + "/>Exact search?</label>");
			jQuery( searchType + " .wildcard" ).append("<input type=\"checkbox\" name=\"wildcard\" id=\"wildcard\" " + wildcardChecked + "/>Exact search");
			
			jQuery( searchType + " .gcd_results" ).append("<br/>");
			jQuery.each(data.facet_counts.facet_fields.dutyStation,function(index,value){
				var buttonClass = "btn btn-default dutyStationBtn";
				if (typeof data.responseHeader.params.fq !== 'undefined') {
					if (data.responseHeader.params.fq.indexOf(index) > -1) {
						buttonClass = "btn btn-primary dutyStationBtn active";
					}
				}
				jQuery( searchType + " .dutyStationButtons" ).append("<button type=\"button\" value=\"" + index + "\" class=\"" + buttonClass  + "\">" +  index + "</button>");
			});
			jQuery( searchType + " thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_title\" href=\"title\">Title</a></th>");
			jQuery( searchType + " thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_lastName\" href=\"lastName\">Last name</a></th>");
			jQuery( searchType + " thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_firstName\" href=\"firstName\">First name</a></th>");
			jQuery( searchType + " thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_email\" href=\"email\">E-mail</a></th>");
			jQuery( searchType + " thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_phoneDisplay1\" href=\"phoneDisplay1\">Phone</a></th>");
			jQuery( searchType + " thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_dutyStation\" href=\"dutyStation\">Duty station</a></th>");
			jQuery( searchType + " thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_building\" href=\"building\">Building</a></th>");
			jQuery( searchType + " thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_room\" href=\"room\">Room</a></th>");
			jQuery( searchType + " thead > tr" ).append("<th><a class=\"sort_link\" id=\"sort_link_organizationalUnit\" href=\"organizationalUnit\">Org unit</a></th>");
			jQuery( searchType + " .glyphicon-arrow-down" ).remove();
			jQuery( searchType + " .glyphicon-arrow-up" ).remove();
			var sort_from_solr = data.responseHeader.params.sort.split(" ");
			if (sort_from_solr[1] == "asc") {
				jQuery( searchType + " #sort_link_" + sort_from_solr[0] ).append("<i class=\"glyphicon glyphicon-arrow-down\"></i>");
			} else {
				jQuery( searchType + " #sort_link_" + sort_from_solr[0] ).append("<i class=\"glyphicon glyphicon-arrow-up\"></i>");
			}
			jQuery( searchType + " tbody" ).empty();
			jQuery.each(data.response.docs,function(i,doc){
				var title = doc.title != undefined ? doc.title : "";
				var lastName = doc.lastName != undefined ? doc.lastName : "";
				var firstName = doc.firstName != undefined ? doc.firstName : "";
				var email = doc.email != undefined ? "<a href=\"mailto:" + doc.email + "\">" + doc.email + "</a>" : "";
				var phoneDisplay1 = doc.phoneDisplay1 != undefined ? "<a href=\"tel:" + doc.phoneDisplay1 + "\">" + doc.phoneDisplay1 + "</a>" : "";
				var dutyStation = doc.dutyStation != undefined ? doc.dutyStation : "";
				var building = doc.building != undefined ? doc.building : "";
				var room = doc.room != undefined ? doc.room : "";
				var organizationalUnit = doc.organizationalUnit != undefined ? doc.organizationalUnit : "";
				jQuery( searchType + " tbody" ).append( "<tr><td>" + title + "</td><td>" + lastName + "</td><td>" + firstName + "</td><td>" + email + "</td><td>" + phoneDisplay1 + "</td><td>" + dutyStation + "</td><td>" + building + "</td><td>" + room + "</td><td>" + organizationalUnit + "</td></tr>" );
			});
			jQuery( searchType + " .gcd_pagination" ).empty();
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
			jQuery( searchType + " .gcd_pagination" ).append(pagination);
			jQuery(searchType + " .modal-body").removeClass("loading");
			jQuery(searchType + " #wildcard").removeClass("loading");
			
			// here shift if advanced
			jQuery(searchType + " .pagination_link").click(function(event){
				event.preventDefault();
				event.stopPropagation();
				if (searchType == "#myModalAdvanced") {
					submitSearch(returnAdvancedSearchQuery(), jQuery(this).attr("href"), returnSelectedDutyStationButtons(), returnSelectedSort(), returnSelectedSortDir(), returnExact());
				} else {
					submitSearch(jQuery("#searchSimpleInputInModal").val(), jQuery(this).attr("href"), returnSelectedDutyStationButtons(), returnSelectedSort(), returnSelectedSortDir(), returnExact());
				}		
				return false; 
			});
			// /here shift if advanced
			
			jQuery(searchType + " .dutyStationBtn").click(function(){ 
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

				if (searchType == "#myModalAdvanced") {
					submitSearch(returnAdvancedSearchQuery(), 0, returnSelectedDutyStationButtons(), "", "", returnExact());
				} else {
					submitSearch(jQuery(searchType + " #searchSimpleInputInModal").val(), 0, returnSelectedDutyStationButtons(), "", "", returnExact());
				}		

				// submitSearch(jQuery(searchType + " #searchSimpleInputInModal").val(), 0, returnSelectedDutyStationButtons(), "", "", returnExact());
			});
			jQuery(searchType + " a.sort_link").click(function(event){
				event.preventDefault();
				event.stopPropagation();
				var sort_click_dir = "asc" ;
				if (jQuery(this).find("i.glyphicon-arrow-down").length) {
					sort_click_dir = "desc";
				} 

				if (searchType == "#myModalAdvanced") {
					submitSearch(returnAdvancedSearchQuery(), 0, returnSelectedDutyStationButtons(), jQuery(this).attr("href"), sort_click_dir, 1);
				} else {
					submitSearch(jQuery(searchType + " #searchSimpleInputInModal").val(), 0, returnSelectedDutyStationButtons(), jQuery(this).attr("href"), sort_click_dir, returnExact());
				}		
				
				// submitSearch(jQuery(searchType + " #searchSimpleInputInModal").val(), 0, returnSelectedDutyStationButtons(), jQuery(this).attr("href"), sort_click_dir, returnExact());
				return false; 
			});
			jQuery(searchType + " #wildcard").click(function(event){
				event.preventDefault();
				event.stopPropagation();
				var sort_click_dir = "asc";

				if (searchType == "#myModalAdvanced") {
					submitSearch(returnAdvancedSearchQuery(), 0, returnSelectedDutyStationButtons(), returnSelectedSort(), returnSelectedSortDir(), returnExact());
				} else {
					submitSearch(jQuery(searchType + " #searchSimpleInputInModal").val(), 0, returnSelectedDutyStationButtons(), returnSelectedSort(), returnSelectedSortDir(), returnExact());
				}	
				return false; 
			});
		}	
	}
	function returnExact() {
		var selectedExact = 0;
		if (jQuery(searchType + " #wildcard").prop("checked")) {
			selectedExact = 1;
		} 
		return selectedExact;
	}
	function returnSelectedSort() {
		var selectedSort = "";
		jQuery(searchType + " a.sort_link").each(function(){
			if (jQuery(this).find("i.glyphicon").length) {
				selectedSort = jQuery(this).attr("href");
			}
		});
		return selectedSort;
	}
	function returnSelectedSortDir() {
		var selectedSortDir = "asc";
		jQuery(searchType + " a.sort_link").each(function(){
			if (jQuery(this).find("i.glyphicon-arrow-down").length) {
				selectedSortDir = "asc";
			} else if (jQuery(this).find("i.glyphicon-arrow-up").length) {
				selectedSortDir = "desc";
			}
		});
		return selectedSortDir;
	}
	function returnSelectedDutyStationButtons() {
		var multivalue_facet_queryphrase_local = "";
		jQuery(searchType + " .dutyStationBtn.btn-primary").each(function(){
			if (multivalue_facet_queryphrase_local.length > 0) {
				multivalue_facet_queryphrase_local += " OR \"" + jQuery(this).attr("value") + "\"";
			} else {
				multivalue_facet_queryphrase_local += "\"" + jQuery(this).attr("value") + "\"" ;
			}
		});
		return multivalue_facet_queryphrase_local;
	}
	
	function returnAdvancedSearchQuery() {
		// determine fq
		
		var exact = "";
		if (returnExact() == 0) {
			exact = "*";
		}
		
		var advQ = "";
		if (jQuery("#advFieldlastName").val()) {
			advQ = "lastName:" + jQuery("#advFieldlastName").val() + exact;
		}
		if (jQuery("#advFieldfirstName").val()) {
			if (advQ.length > 0) {
				advQ += " AND firstName:" + jQuery("#advFieldfirstName").val() + exact;
			} else {
				advQ = "firstName:" + jQuery("#advFieldfirstName").val() + exact;
			}
		}
		if (jQuery("#advFieldemail").val()) {
			if (advQ.length > 0) {
				advQ += " AND email:" + jQuery("#advFieldemail").val() + exact;
			} else {
				advQ += "email:" + jQuery("#advFieldemail").val() + exact;
			}
		}
		if (jQuery("#advFieldphoneDisplay1").val()) {
			if (advQ.length > 0) {
				advQ += " AND phoneDisplay1:" + exact + jQuery("#advFieldphoneDisplay1").val() + exact;
			} else {
				advQ += "phoneDisplay1:" + exact + jQuery("#advFieldphoneDisplay1").val() + exact;
			}
		}
		if (jQuery("#advFieldorganizationalUnit").val()) {
			if (advQ.length > 0) {
				advQ += " AND organizationalUnit:" + exact + jQuery("#advFieldorganizationalUnit").val() + exact;
			} else {
				advQ += "organizationalUnit:" + exact + jQuery("#advFieldorganizationalUnit").val() + exact;
			}
		}
		if (jQuery("#advFieldroom").val()) {
			if (advQ.length > 0) {
				advQ += " AND room:" + exact + jQuery("#advFieldroom").val() + exact;
			} else {
				advQ += "room:" + exact + jQuery("#advFieldroom").val() + exact;
			}
		}
		return advQ;
	}
</script>
