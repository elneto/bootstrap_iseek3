<?php
drupal_add_library('system', 'jquery');

print drupal_render_children($form);

?>
  <div id="bcard-preview" data-spy="affix" data-offset-top="0">
  	<div id="marker"></div>
  	<img src="<?php print base_path() . drupal_get_path('module', 'print_business_cards'); ?>/images/un-logo-bcards.png" id="un-logo" height="50" width="59.21">
  	<div id="left-group">
  		<div class="clearfix:after"></div>
  		<span id="txt-un" class="bcard-blue">United Nations</span>
  		<div id="p-left-address-group">
  			<span id="address1">Address line 1</span>
  			<div class="clearfix:after"></div>
  			<span id="address2">Address line 2</span>
  			<div class="clearfix:after"></div>
  			<span id="city">City</span><span id="state"></span><span style="clear:none">&nbsp;</span><span id="zip">Zip code</span>
  			<div class="clearfix:after"></div>
  			<span id="country">USA</span>
  		</div>
  	</div>
  	<div id="right-group">
  		<span id="txt-first" class="bcard-blue">First</span>
  		<div class="clearfix:after"></div>
  		<span id="txt-last" class="bcard-blue">Last</span>
  		<div id="bc-right-column">
	  		<div id="p-right-title-group">
	  			<span id="title1">Title 1</span>
	  			<div class="clearfix:after"></div>
	  			<span id="title2">Title 2</span>
	  			<div class="clearfix:after"></div>
	  			<span id="unit1">Unit/Division/Department</span>
	  			<div class="clearfix:after"></div>
	  			<span id="unit2">Unit/Division/Department</span>
	  		</div>
	  		<div id="p-right-office-group">
	  			<span id="office">Office:</span>
	  			<div class="clearfix:after"></div>
	  			<span id="mobile">Mobile:</span>
	  			<div class="clearfix:after"></div>
	  			<span id="email">Email</span>
	  			<div class="clearfix:after"></div>
	  			<span id="fax">Fax (or social media)</span>
	  			<div class="clearfix:after"></div>
	  			<span id="url">URL</span>
	  			<div class="clearfix:after"></div>
	  		</div>
	  	</div>
  	</div>
  </div>

  <div id="bcard-preview-back" data-spy="affix" data-offset-top="0">
  	<img src="<?php print base_path() . drupal_get_path('module', 'print_business_cards'); ?>/images/un-actions.png" id="un-actions" height="350" width="200">
  </div>

<script>
//Updates the text according to the input
jQuery(document).ready(function($) {
		
	//TODO: add event on lose focus?
	var buffer = 0;
	var mtop = 0;
	var arg2 = <? echo "'".arg(2)."'";?>;
	var lang = <? echo "'".$_GET['lang']."'";?>;

	//get val from select
	var pais = $("#edit-field-bc-address-und-0-country option:selected").text();
	if (pais == 'United States'){
		$("#country").text('USA');	
	} else if (pais == '- None -'){
		$("#country").text('');	
	} else {
		$("#country").text(pais);
	}
	//$("#country").text((pais=='United States')?'USA':pais);
	//$("#country").text((pais=='- None -')?'':pais);
	
	//this adds a one time event handler to the ajax changing country select object
	$( document ).on( "focus", "select.country",function() {
		$("#"+this.id).one("change", function(){
			var pais2 = $("#"+this.id+ " option:selected").text();
			/*$("#country").text((pais2=='United States')?'USA':pais2);
			$("#country").text((pais2=='- None -')?'':pais2);*/
			if (pais2 == 'United States'){
				$("#country").text('USA');	
			} else if (pais2 == '- None -'){
				$("#country").text('');	
			} else {
				$("#country").text(pais2);
			}
		});
	});
	
	var tbl = [
			{field:"#edit-field-bc-first-name-und-0-value",txt:"#txt-first"},
			{field:"#edit-field-bc-last-name-und-0-value",txt:"#txt-last"},
			{field:"#edit-field-bc-job-title-1-und-0-value",txt:"#title1"},
			{field:"#edit-field-bc-job-title-2-und-0-value",txt:"#title2"},
			{field:"#edit-field-bbc-unit-div-dep-1-und-0-value",txt:"#unit1"},
			{field:"#edit-field-bbc-unit-div-dep-2-und-0-value",txt:"#unit2"},
			{field:"#edit-field-bbc-office-und-0-value",txt:"#office"},
			{field:"#edit-field-bc-mobile-und-0-value",txt:"#mobile"},
			{field:"#edit-field-bc-e-mail-und-0-email",txt:"#email"},
			{field:"#edit-field-bc-fax-social-media-und-0-value",txt:"#fax"},
			{field:"#edit-field-bc-url-und-0-url",txt:"#url"}, //10
			{field:"#edit-field-bc-address-und-0-thoroughfare",txt:"#address1"}, //11
			{field:"#edit-field-bc-address-und-0-premise",txt:"#address2"}, //12
			{field:"#edit-field-bc-address-und-0-locality",txt:"#city"}, //13
			{field:"#edit-field-bc-address-und-0-administrative-area",txt:"#state"}, //14
			{field:"#edit-field-bc-address-und-0-postal-code",txt:"#zip"} //15
			]; 

	if (arg2.localeCompare('edit') == 0){ //we are editing the form
		updatePreview();
	} else { //business-cards is a new card
		//populate with existing placeholders
		$.each(tbl, function(i){
			$(tbl[i].txt).text($(tbl[i].field).attr('placeholder'));
		});	
	}

	//existing info to www.un.org for URL field
	$(tbl[10].txt).text('www.un.org');
	//add placeholder to URL field
	$(tbl[10].field).attr('placeholder', 'www.un.org');

	//this detects if there was a validation error
	if ($("div.alert-danger:contains('field is required')").length > 0 ||
		$("div.alert-danger:contains('est requis')").length > 0 || //for the validation error in french
		$("div.alert-danger:contains('is not a valid email address')").length > 0){
		updatePreview();
	}

	//if there is reload make vertical just in case
	if ($("#edit-field-bc-orientation-und-1").is(':checked')){ //vertical business card
		rotateVertical();
	}
	if ($("#edit-field-bc-back-image-und-1").is(':checked')){ //UN Actions
		$("#un-actions").animate({opacity:1});
	}

	//receive french
	if (lang=='fr')
	{
		$("#edit-language").val('fr');
		translateFrench();
	}

	//removes submit on enter
	$('input').keypress(function (event){ return event.keyCode == 13 ? false : true; });
	
	//attaching the keyup events so the preview updates when typing 
	$(tbl[0].field).keyup(function(){$(tbl[0].txt).text($(tbl[0].field).val());});
	$(tbl[1].field).keyup(function(){$(tbl[1].txt).text($(tbl[1].field).val());});
	$(tbl[2].field).keyup(function(){$(tbl[2].txt).text($(tbl[2].field).val());});
	$(tbl[3].field).keyup(function(){$(tbl[3].txt).text($(tbl[3].field).val());});
	$(tbl[4].field).keyup(function(){$(tbl[4].txt).text($(tbl[4].field).val());});
	$(tbl[5].field).keyup(function(){$(tbl[5].txt).text($(tbl[5].field).val());});
	$(tbl[6].field).keyup(function(){$(tbl[6].txt).text($(tbl[6].field).val());});
	$(tbl[7].field).keyup(function(){$(tbl[7].txt).text($(tbl[7].field).val());});
	$(tbl[8].field).keyup(function(){$(tbl[8].txt).text($(tbl[8].field).val());});
	$(tbl[9].field).keyup(function(){$(tbl[9].txt).text($(tbl[9].field).val());});
	$(tbl[10].field).keyup(function(){$(tbl[10].txt).text($(tbl[10].field).val());});
	$(tbl[11].field).keyup(function(){$(tbl[11].txt).text($(tbl[11].field).val());}); //the ajax updated ones
	$(tbl[12].field).keyup(function(){$(tbl[12].txt).text($(tbl[12].field).val());});
	$(tbl[13].field).keyup(function(){$(tbl[13].txt).text($(tbl[13].field).val());});
	$(tbl[14].field).keyup(function(){$(tbl[14].txt).text($(tbl[14].field).val());});
	$(tbl[15].field).keyup(function(){$(tbl[15].txt).text($(tbl[15].field).val());});

	//to autocomplete
	$(tbl[0].field).blur(function(){$(tbl[0].txt).text($(tbl[0].field).val());}); //first
	$(tbl[1].field).blur(function(){$(tbl[1].txt).text($(tbl[1].field).val());});
	$(tbl[2].field).blur(function(){$(tbl[2].txt).text($(tbl[2].field).val());});
	$(tbl[3].field).blur(function(){$(tbl[3].txt).text($(tbl[3].field).val());});
	$(tbl[4].field).blur(function(){$(tbl[4].txt).text($(tbl[4].field).val());});
	$(tbl[5].field).blur(function(){$(tbl[5].txt).text($(tbl[5].field).val());});
	$(tbl[6].field).blur(function(){$(tbl[6].txt).text($(tbl[6].field).val());});
	$(tbl[7].field).blur(function(){$(tbl[7].txt).text($(tbl[7].field).val());});
	$(tbl[8].field).blur(function(){$(tbl[8].txt).text($(tbl[8].field).val());});
	$(tbl[9].field).blur(function(){$(tbl[9].txt).text($(tbl[9].field).val());});
	$(tbl[10].field).blur(function(){$(tbl[10].txt).text($(tbl[10].field).val());});
	$(tbl[11].field).blur(function(){$(tbl[11].txt).text($(tbl[11].field).val());}); //the ajax updated ones
	$(tbl[12].field).blur(function(){$(tbl[12].txt).text($(tbl[12].field).val());});
	$(tbl[13].field).blur(function(){$(tbl[13].txt).text($(tbl[13].field).val());});
	//$(tbl[14].field).blur(function(){$(tbl[14].txt).text($(tbl[14].field).val());});
	$(tbl[15].field).blur(function(){$(tbl[15].txt).text($(tbl[15].field).val());});

	$( document ).on( "keyup", "input",function() {
		updateVspace();
	});

	//this adds an event handler to the ajax-changing country inputs
	$( document ).on( "focus", "input, select",function() {
		var strid = "#"+String(this.id);

		if (strid.indexOf(tbl[1].field)==0) clearPrevious(1);
		else if (strid.indexOf(tbl[2].field)==0) clearPrevious(2);
		else if (strid.indexOf(tbl[3].field)==0) clearPrevious(3);
		else if (strid.indexOf(tbl[4].field)==0) clearPrevious(4);
		else if (strid.indexOf(tbl[5].field)==0) clearPrevious(5);
		else if (strid.indexOf(tbl[6].field)==0) clearPrevious(6);
		else if (strid.indexOf(tbl[7].field)==0) clearPrevious(7);
		else if (strid.indexOf(tbl[8].field)==0) clearPrevious(8);
		else if (strid.indexOf(tbl[9].field)==0) clearPrevious(9);
		else if (strid.indexOf(tbl[10].field)==0) clearPrevious(10);
		else if (strid.indexOf(tbl[11].field)==0){
			clearPrevious(11);
			$("#"+this.id).on("keyup", function(){
				$(tbl[11].txt).text($("#"+this.id).val());
			});	
		} else if (strid.indexOf(tbl[12].field)==0){
			clearPrevious(12);
			$("#"+this.id).on("keyup", function(){
				$(tbl[12].txt).text($("#"+this.id).val());
			});	

		} else if (strid.indexOf(tbl[13].field)==0){ //city
			clearPrevious(13);
			$("#"+this.id).on("keyup", function(){
				$(tbl[13].txt).text($("#"+this.id).val());
			});	
		} else if (strid.indexOf(tbl[14].field)==0){ //state
			clearPrevious(14);
			$("#"+this.id).on("keyup change", function(){
				if ($(tbl[13].txt).text()) //if there is city add comma before
					$(tbl[14].txt).text(", "+$("#"+this.id).val());
				else
					$(tbl[14].txt).text($("#"+this.id).val());
			});	
		} else if (strid.indexOf(tbl[15].field)==0){
			clearPrevious(15);
			$("#"+this.id).on("keyup", function(){
				$(tbl[15].txt).text($("#"+this.id).val());
			});	
		} else if (strid.indexOf('#edit-language')==0){ //state
			$("#"+this.id).on("keyup change", function(){
				if ($("#"+this.id).val() == 'fr'){
					translateFrench();
				} 
				else {
					translateEnglish();
				}
				updateVspace();
					
			});	
		}
	});

	//vertical / horizontal layout
	$("#edit-field-bc-orientation-und-0").change(function(){ //horizontal
		rotateHorizontal();
	});

	$("#edit-field-bc-orientation-und-1").change(function(){ //vertical
		rotateVertical();
	});

	$("#edit-field-bc-back-image-und-0").change(function(){ //blank
		$("#un-actions").animate({opacity:0});
	});

	$("#edit-field-bc-back-image-und-1").change(function(){ //UN Actions
		$("#un-actions").animate({opacity:1});
	});

	function translateEnglish(){
		var unaction = $("#un-actions").attr("src");
		unaction = unaction.replace('actions-fr.png', 'actions.png');
		$("#un-actions").attr("src", unaction);

		$("label[for='edit-language']").text("Language"); //label
		$('select option:contains("Indépendant de la langue")').text('Language neutral');
		$('select option:contains("Anglais")').text('English');
		$('select option:contains("Français")').text('French');

		$("label[for='edit-field-bc-back-image-und']").text("Back Image"); //label
		$("label[for='edit-field-bc-back-image-und-0']").text("Blank"); //label
		$("label[for='edit-field-bc-back-image-und-1']").text("UN Actions"); //label

		//on the preview
		$("#txt-un").text("United Nations");
		if ($.trim($(tbl[0].field).val()) == "") $(tbl[0].txt).text("First Name"); //preview
		$("label[for='"+tbl[0].field.substring(1)+"']").text("First Name *"); //label
		$(tbl[0].field).attr('placeholder', "First Name"); //placeholder
		if ($.trim($(tbl[1].field).val()) == "") $(tbl[1].txt).text("Last Name");
		$("label[for='"+tbl[1].field.substring(1)+"']").text("Last Name"); //label
		$(tbl[1].field).attr('placeholder', "Last Name"); //placeholder

		if ($.trim($(tbl[2].field).val()) == "") $(tbl[2].txt).text("Job Title / Unit / Division / Department");
		$("label[for='"+tbl[2].field.substring(1)+"']").text("Job Title / Unit / Division / Department"); //label
		$(tbl[2].field).attr('placeholder', "Job Title / Unit / Division / Department"); //placeholder
		if ($.trim($(tbl[3].field).val()) == "") $(tbl[3].txt).text("Job Title / Unit / Division / Department"); //Preview
		//$("label[for='"+tbl[3].field.substring(1)+"']").text("Title 2"); //label
		$(tbl[3].field).attr('placeholder', "Job Title / Unit / Division / Department"); //placeholder

		if ($.trim($(tbl[4].field).val()) == "") $(tbl[4].txt).text("Job Title / Unit / Division / Department"); //preview
		//$("label[for='"+tbl[4].field.substring(1)+"']").text("Unit/Division/Department"); //label
		$(tbl[4].field).attr('placeholder', "Job Title / Unit / Division / Department"); //placeholder
		if ($.trim($(tbl[5].field).val()) == "") $(tbl[5].txt).text("Job Title / Unit / Division / Department");
		//$("label[for='"+tbl[5].field.substring(1)+"']").text("Unit/Division/Department"); //label
		$(tbl[5].field).attr('placeholder', "Job Title / Unit / Division / Department"); //placeholder

		if ($.trim($(tbl[6].field).val()) == "") $(tbl[6].txt).text("Office: +1 555 555 5555"); //preview
		$("label[for='"+tbl[6].field.substring(1)+"']").text("Office / Mobile"); //label
		$(tbl[6].field).attr('placeholder', "Office: +1 555 555 5555"); //placeholder

		if ($.trim($(tbl[7].field).val()) == "") $(tbl[7].txt).text("Mobile: +1 444 444 4444"); //preview
		//$("label[for='"+tbl[7].field.substring(1)+"']").text("Mobile:"); //label
		$(tbl[7].field).attr('placeholder', "Mobile: +1 444 444 4444"); //placeholder

		$("label[for='edit-field-bc-e-mail-und-0-email']").text("Email"); //label
		
		if ($.trim($(tbl[9].field).val()) == "") $(tbl[9].txt).text("Fax (or social media)");
		$("label[for='"+tbl[9].field.substring(1)+"']").text("Fax (or social media)"); //label
		$(tbl[9].field).attr('placeholder', "Fax (or social media)"); //placeholder

		$("label[for='edit-field-bc-address-und-0-country']").text("Country"); //label

		if ($.trim($(tbl[11].field).val()) == "") $(tbl[11].txt).text("Address line 1");
		$("label[for='"+tbl[11].field.substring(1)+"']").text("Address line 1"); //label
		$(tbl[11].field).attr('placeholder', "Address line 1"); //placeholder
		if ($.trim($(tbl[12].field).val()) == "") $(tbl[12].txt).text("Address line 2");
		$("label[for='"+tbl[12].field.substring(1)+"']").text("Address line 2"); //label
		$(tbl[12].field).attr('placeholder', "Address line 2"); //placeholder
		if ($.trim($(tbl[13].field).val()) == "") $(tbl[13].txt).text("City");
		$("label[for='"+tbl[13].field.substring(1)+"']").text("City"); //label
		$(tbl[13].field).attr('placeholder', "City"); //placeholder

		$("label[for='edit-field-bc-address-und-0-administrative-area']").text("State *"); //label

		if ($.trim($(tbl[15].field).val()) == "") $(tbl[15].txt).text("Zip code");
		$("label[for='"+tbl[15].field.substring(1)+"']").text("Zip code"); //label
		$(tbl[15].field).attr('placeholder', "Zip code"); //placeholder

		$("label[for='edit-field-bc-paper-size-und']").text("Paper Size *"); //label
		$("label[for='edit-field-bc-paper-size-und-0']").text("Letter (US)"); //label

		//shows the help
		$(".help-block").show(300);
	}

	function translateFrench(){
		var unaction = $("#un-actions").attr("src");
		unaction = unaction.replace('actions.png', 'actions-fr.png');
		$("#un-actions").attr("src", unaction);

		$("label[for='edit-language']").text("Langue"); //label
		$('select option:contains("Language neutral")').text('Indépendant de la langue');
		$('select option:contains("English")').text('Anglais');
		$('select option:contains("French")').text('Français');

		$("label[for='edit-field-bc-back-image-und']").text("Image pour le verso"); //label
		$("label[for='edit-field-bc-back-image-und-0']").text("Vide"); //label
		$("label[for='edit-field-bc-back-image-und-1']").text("L'ONU en action"); //label

		//on the preview
		$("#txt-un").text("Nations Unies");
		if ($.trim($(tbl[0].field).val()) == "") $(tbl[0].txt).text("Prénom"); //preview
		$("label[for='"+tbl[0].field.substring(1)+"']").text("Prénom *"); //label
		$(tbl[0].field).attr('placeholder', "Prénom"); //placeholder
		if ($.trim($(tbl[1].field).val()) == "") $(tbl[1].txt).text("Nom de famille");
		$("label[for='"+tbl[1].field.substring(1)+"']").text("Nom de famille"); //label
		$(tbl[1].field).attr('placeholder', "Nom de famille"); //placeholder

		if ($.trim($(tbl[2].field).val()) == "") $(tbl[2].txt).text("Titre / Unité / Division / Département"); //preview
		$("label[for='"+tbl[2].field.substring(1)+"']").text("Titre / Unité / Division / Département"); //label
		$(tbl[2].field).attr('placeholder', "Titre / Unité / Division / Département"); //placeholder

		if ($.trim($(tbl[3].field).val()) == "") $(tbl[3].txt).text("Titre / Unité / Division / Département"); //preview
		//$("label[for='"+tbl[3].field.substring(1)+"']").text("Titre 2"); //label
		$(tbl[3].field).attr('placeholder', "Titre / Unité / Division / Département"); //placeholder

		if ($.trim($(tbl[4].field).val()) == "") $(tbl[4].txt).text("Titre / Unité / Division / Département");
		//$("label[for='"+tbl[4].field.substring(1)+"']").text("Unité/Division/Département"); //label
		$(tbl[4].field).attr('placeholder', "Titre / Unité / Division / Département"); //placeholder

		if ($.trim($(tbl[5].field).val()) == "") $(tbl[5].txt).text("Titre / Unité / Division / Département");
		//$("label[for='"+tbl[5].field.substring(1)+"']").text("Unité/Division/Département"); //label
		$(tbl[5].field).attr('placeholder', "Titre / Unité / Division / Département"); //placeholder

		if ($.trim($(tbl[6].field).val()) == "") $(tbl[6].txt).text("Tel: +1 555 555 5555");
		$("label[for='"+tbl[6].field.substring(1)+"']").text("Tel / Cellulaire"); //label
		$(tbl[6].field).attr('placeholder', "Tel: +1 555 555 5555"); //placeholder

		if ($.trim($(tbl[7].field).val()) == "") $(tbl[7].txt).text("Cellulaire: +1 444 444 4444");
		//$("label[for='"+tbl[7].field.substring(1)+"']").text("Cellulaire"); //label
		$(tbl[7].field).attr('placeholder', "Cellulaire: +1 444 444 4444"); //placeholder

		$("label[for='edit-field-bc-e-mail-und-0-email']").text("Courriel"); //label
		
		if ($.trim($(tbl[9].field).val()) == "") $(tbl[9].txt).text("Facsimile (ou media sociaux)");
		$("label[for='"+tbl[9].field.substring(1)+"']").text("Facsimile (ou media sociaux)"); //label
		$(tbl[9].field).attr('placeholder', "Facsimile (ou media sociaux)"); //placeholder

		$("label[for='edit-field-bc-address-und-0-country']").text("Pays"); //label

		if ($.trim($(tbl[11].field).val()) == "") $(tbl[11].txt).text("Addresse 1");
		$("label[for='"+tbl[11].field.substring(1)+"']").text("Addresse 1"); //label
		$(tbl[11].field).attr('placeholder', "Addresse 1"); //placeholder
		if ($.trim($(tbl[12].field).val()) == "") $(tbl[12].txt).text("Addresse 2");
		$("label[for='"+tbl[12].field.substring(1)+"']").text("Addresse 2"); //label
		$(tbl[12].field).attr('placeholder', "Addresse 2"); //placeholder
		if ($.trim($(tbl[13].field).val()) == "") $(tbl[13].txt).text("Ville");
		$("label[for='"+tbl[13].field.substring(1)+"']").text("Ville"); //label
		$(tbl[13].field).attr('placeholder', "Ville"); //placeholder

		$("label[for='edit-field-bc-address-und-0-administrative-area']").text("État *"); //label

		if ($.trim($(tbl[15].field).val()) == "") $(tbl[15].txt).text("Code Postal");
		$("label[for='"+tbl[15].field.substring(1)+"']").text("Code Postal"); //label
		$(tbl[15].field).attr('placeholder', "Code Postal"); //placeholder

		$("label[for='edit-field-bc-paper-size-und']").text("Taille du papier *"); //label
		$("label[for='edit-field-bc-paper-size-und-0']").text("Lettre (US)"); //label

		//hides the help
		$(".help-block").hide(300);

	}

	//takes values from inputs and updates the preview
	function updatePreview(){
		//populate with existing info
		$.each(tbl, function(i){
			$(tbl[i].txt).text($(tbl[i].field).val());
		});

		if ($("#edit-language").val() == 'fr'){
			$("#txt-un").text("Nations Unies");
			translateFrench();
		}

		if ($("#edit-field-bc-orientation-und-1").is(':checked')){
			rotateVertical();
		}

		if ($("#edit-field-bc-back-image-und-1").is(':checked')){//UN Actions
			$("#un-actions").animate({opacity:1});
		}
	}

	//receives an index argument and if the previous indexes of the array are empty it will delete them from the preview
	//called in focus() 
	function clearPrevious(index){
		for (i=index-1; i>=0; i--){
			if ($.trim($(tbl[i].field).val()) == "") $(tbl[i].txt).text("");
		}
		updateVspace();
	}

	function rotateHorizontal(){
		$("#bcard-preview").css({width:"200px",height:"350px"}).animate({width:"350px",height:"200px", right:"3em"});
		$("#un-logo").animate({left:"19.22px",top:"18px"});
		$("#right-group").animate({left:"143.2px",top:"30.5px"});
		$("#txt-un").animate({left:"19.22px",top:"80.97px"});
		$("#left-group").animate({"margin-left":"19.22px","margin-top":"0"});

		$("#bcard-preview-back").css({width:"200px",height:"350px"}).animate({width:"350px",height:"200px", top:"30em"});
		$("#un-actions").css({"transform": "rotate(-90deg)", "margin-top":"200px"});
	}

	function rotateVertical(){
		$("#bcard-preview").animate({width:"200px",height:"350px",right:"19em"});
		$("#un-logo").animate({left:"18px",top:"17px"});
		$("#right-group").animate({left:"18px",top:"80px"});
		updateVspace();

		$("#bcard-preview-back").animate({width:"200px",height:"350px", top:"13em"});
		$("#un-actions").css({"transform": "rotate(0)", "margin-top":"0"});
	}

	function updateVspace(){
		//compensate for blank fields in unit or address:
		buffer = 0;
		for (i=2; i<=10; i++)
		{
			if ($.trim($(tbl[i].txt).text()) == "")
				buffer += 12;
		}

		if ($("#edit-field-bc-orientation-und-1").is(':checked'))
		{
			if ($.trim($(tbl[1].txt).text()) == ""){ //if last name is empty
				$("#bc-right-column").animate({top:"33px"}); //pull everything up
				buffer += 20; //move 20 up
			} else {
				$("#bc-right-column").animate({top:"53px"}); //leave it down
			} 

			mtop = 251 - buffer;
			$("#txt-un").animate({left:"18px",top:mtop+"px"});
			mtop = 165 - buffer;
			$("#left-group").animate({"margin-left":"18px","margin-top":mtop+"px"});
		}
	}

});
</script>
 <?php

