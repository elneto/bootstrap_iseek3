// Activate links for dropdown on open
/*
jQuery(function(){
  jQuery('li.open, li.dropdown-submenu')
    .find('.dropdown-toggle')
      .addClass('disabled')
    .end();
});
*/
/*
function doVariableSubmit() {
	var temp="";
	for (i=0; i<document.gs.whichsearch.length; i++) {
		if (document.gs.whichsearch[i].checked==true) {
			temp=document.gs.whichsearch[i].value;
		}
	}
	document.gs.action="http://search.un.org/search";
	if (temp=="iSeek") {
   		document.gs.action="/iseek-site-search";      
		document.gs.query.value="tax";
	} else {
		document.gs.action="http://search.un.org/search";
		document.gs.proxystylesheet.value="UN_ODS_test";
		document.gs.site.value="ods_un_org";
		document.gs.client.value="UN_ODS_test";
		document.gs.getfields.value="DocumentSymbol.Title.Size.PublicationDate";
	}
   	document.gs.submit();
}
*/

jQuery(document).ready(function(){
    jQuery('#btnG').click(function() {
        var selValue = jQuery('input[name=whichsearch]:checked').val(); 
		var query = jQuery('input[id=q]').val();
		if (selValue == 'ODS') {
			jQuery(location).attr('href', 'http://search.un.org/search?q=' + query + 'ie=utf8&oe=utf8&output=xml_no_dtd&proxystylesheet=UN_ODS_test&site=ods_un_org&getfields=DocumentSymbol.Title.Size.PublicationDate&filter=0&client=UN_ODS_test&ProxyReload=1');	
		} else if (selValue == 'iSeek') {
			jQuery(location).attr('href', '/iseek-site-search?query=' + query);
		}
    });
});




