<style type="text/css">
tbody > tr > td, thead > tr > th {
	font-size: small;
}

tbody > tr > td {
	white-space: nowrap;
}

.gcd_pagination {
	text-align: center;
}	
.dutyStationBtn {
	margin: 2px 4px;
	padding: 3px 6px;
	font-size: 13px;
}
h3.gcd_results {
	font-size: 18px;
}
.modal-header .input-group {
	margin-bottom: 10px;
}
.modal-title {
	font-size: 26px;
	margin-bottom: 10px;
}
.wildcard input#wildcard {
	position: relative;
	margin-left: 0;
	margin-right: 4px;
}
th {
	font-weight: normal;
}
thead tr {
	background-color: rgb(238, 244, 250);
}
.btn-default:hover, .btn-default:focus, .btn-default:active, .btn-default.active {

} 
.loading {
	opacity: 0.3;
}
.modal-body {
	padding-top: 0;
}

.modal-body table {
	word-wrap: break-word;
}

/* not fixed in less than 768 pixel width */
@media (max-width: 768px) {
}	
@media (min-width: 768px) {
	.table-responsive {
		width: 100%;
		margin-bottom: 15px;
		overflow-y: hidden;
		overflow-x: auto;
	}
}

#searchTriggerAdvanced {
	color: #003377;
	text-decoration: none;
}

#searchTriggerAdvancedInSimpleModal {
	color: #003377;
}

#searchTriggerAdvanced:hover, #searchTriggerAdvanced:focus, #searchTriggerAdvanced:active  {
	text-decoration: underline;
	cursor: pointer;
}
</style>


<?php
 
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
     'phoneDisplay1' => 'Phone');

$iseekAdvSearchFieldsHelpText = array(
     'lastName' => 'For names with accents, you may enter the letter with or without the accent',
     'firstName' => 'For names with accents, you may enter the letter with or without the accent',
     'phoneDisplay1' => 'The phone number must be entered exactly as it is in the directory. Some duty stations, such as Geneva, list only the extension number, while others, like New York, list the full number (212-963-1234)',
	 'dutyStation' => 'Duty stations are case-sensitive; for example, please enter "Santiago" instead of "santiago" or "SANTIAGO"'
);
	 
?>


<?php include('sites/iseek.un.org/themes/bootstrap_iseek3/js/gcd.js'); ?>

<!--
	<section id="block-block-136" class="block block-block clearfix">

		<h2>Find a Colleague</h2>
		
		<div class="content"<?php print $content_attributes; ?>>
			<div class="input-group">
				<input class="form-control" name="query" type="text" id="searchSimpleInput">
				<span class="input-group-btn">
					<button id="searchTriggerSimple" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Search</button> 
				</span>
			</div>
			<div id="searchTriggerAdvanced">Advanced search</div>
			<div><a class="redlink" href="/content/additional-phone-resources">Additional resources</a></div>
			<div><a href="/content/update-information-global-contact-directory">Update my information</a></div>
		</div>
	</section>  
-->

            <h3 class="top-side-box nohoverfx top-boxes-margin">&nbsp;<i class="fa fa-search"></i>&nbsp;&nbsp;Search</h3>
            <div id="search-box">
		<div id="search-form">
                <!-- <form id="search-form"> -->
                        <div class="row">
                                <div class="col-xs-12">
                                  <label for="input-find-colleague">Find a colleague<span class="hidden-xs">... by name, department and more</span></label> <!--placeholder="Find a colleague"!-->
                                </div>
                                <div class="col-lg-10 col-xs-9 search-rpad0">
                                  <!-- <input type="text" name="find-colleague" class="search-input" id="input-find-colleague"> -->
					<input class="search-input" name="query" type="text" id="searchSimpleInput">
                                </div>
                                <div class="col-lg-2 col-xs-3 search-lpad0">
					<button id="searchTriggerSimple" type="button" class="search-button" data-toggle="modal" data-target="#myModal">Search</button>
                                  	<!-- <button name="Search" class="search-button">Search</button> -->
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-xs-12">
                                        <label for="input-search-iseek">Search iSeek or ODS</label> <!-- placeholder="Search the UN Intranet or ODS"  !-->
                                </div>
                                <div class="col-lg-8 col-md-7 col-xs-6 search-rpad0">
                                        <input type="text" name="search-intranet" class="search-input" id="input-search-iseek">
                                </div>
                                <div class="col-lg-2 col-md-2 col-xs-3 search-lpad0 search-rpad0">
                                        <select id="select-search" class="search-input">
                                                <option>iSeek</option>
                                                <option>ODS</option>
                                        </select>
                                </div>
                                <div class="col-lg-2 col-md-3 col-xs-3 search-lpad0">
                                        <button id="searchIseekOrOds" name="Search" class="search-button">Search</button>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12">
                                        <div id="search-links">
                                                <a href="#">Update my Information</a>  |
                                                <a href="#">Advanced Search</a>  |
                                                <a href="#">Additional Resources</a>
                                        </div>
                                </div>  
                        </div> 
		</div> 
                <!-- </form> -->
            </div>





  <!-- Modal -- simple search -->
	<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalSimpleLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<i class="fa fa-search"></i> Search
		  </div>
		  <div class="modal-post-header">
			<button type="button" class="close" data-dismiss="modal">Close <span aria-hidden="true">&times;</span></button>
			<h2 class="modal-title" id="myModalLabel">United Nations Global Contact Directory</h2>
			<div class="row">
				<div class="col-sm-12" id="find_a_colleague_text">
					Find a colleague... by name, department and more
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-7"> 
					<div class="input-group">
						<input class="form-control" name="query" type="text" id="searchSimpleInputInModal">
						<span class="input-group-btn">
							<button id="searchTriggerSimpleInModal" type="button" class="btn btn-primary">Search</button> 
						</span>
					</div>
					<div class="wildcard checkbox"></div>
				</div>
				<div class="col-sm-5"> 
					<div id="searchTriggerAdvancedInSimple"><span id="searchTriggerAdvancedInSimpleModal">Advanced search</span> <i class="fa fa-info-circle"></i> <i class="fa fa-angle-double-right"></i></div>
				</div>
			</div>	
			<h5 class="narrow_by_duty_station_text"></h5>
			<div class="dutyStationButtons"></div>
		  </div>
		  <div class="modal-body">

			<h3 class="gcd_results"></h3>

			<div class="table-responsive">	
				<table class="table table-striped">
					<thead>
						<tr>
						</tr>
					</thead>
					<tbody>


					</tbody>
				</table>
			</div>
			
			<div class="gcd_pagination">
			</div>

		  </div>
		  <div class="modal-footer">
			<!-- <button type="button" class="btn btn-default" id="searchTriggerAdvancedInSimpleModal">Advanced search</button> -->
			<a href="/content/update-information-global-contact-directory">Update my information</a> 
			|
			<a href="/content/additional-phone-resources">Additional resources</a>
			<!-- <button type="button" class="btn btn-default"><a href="/content/update-information-global-contact-directory">Update my information</a></button>
			<button type="button" class="btn btn-default"><a href="/content/additional-phone-resources">Additional resources</a></button> -->
			<!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
		  </div>
		</div>
	  </div>
	</div>  
 
  <!-- Modal -- advanced search -->
	<div class="modal fade bs-example-modal-lg" id="myModalAdvanced" tabindex="-1" role="dialog" aria-labelledby="myModalAdvancedLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h2 class="modal-title" id="myModalLabel">United Nations Global Contact Directory</h2>

			<div class="form-horizontal">			
			
				<div class="form-group">
					<label class="col-sm-2 control-label">
						Last name
						<i class="fa fa-info-circle" rel="tooltip" title="<?php echo $iseekAdvSearchFieldsHelpText['lastName']; ?>"></i>
					</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" id="advFieldlastName" name="lastName"  placeholder="Last name" />
					</div>	
					<label class="col-sm-2 control-label">
						First name
						<i class="fa fa-info-circle" rel="tooltip" title="<?php echo $iseekAdvSearchFieldsHelpText['firstName']; ?>"></i>
					</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" id="advFieldfirstName" name="firstName"  placeholder="First name" />
					</div>	
					<div class="col-sm-2">
						<div class="wildcard checkbox"></div>
					</div>	
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">
						E-mail
					</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" id="advFieldemail" name="email"  placeholder="E-mail" />
					</div>	
					<label class="col-sm-2 control-label">
						Phone
						<i class="fa fa-info-circle" rel="tooltip" title="<?php echo $iseekAdvSearchFieldsHelpText['phoneDisplay1']; ?>"></i>
					</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" id="advFieldphoneDisplay1" name="phoneDisplay1"  placeholder="Phone" />
					</div>	
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">
						Org unit
					</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" id="advFieldorganizationalUnit" name="organizationalUnit"  placeholder="Org unit" />
					</div>	
					<label class="col-sm-2 control-label">
						Room
					</label>
					<div class="col-sm-3">
						<input class="form-control" type="text" id="advFieldroom" name="room"  placeholder="Room" />
					</div>	
					<div class="col-sm-2">
						<button id="searchTriggerAdvancedInModal" type="button" class="btn btn-primary">Go</button> 
					</div>	
				</div>
						
			</div>
<!--			
			<div class="row">
				<div class="col-sm-1 col-sm-offset-11 pull-right">
					<button id="searchTriggerAdvancedInModal" type="button" class="btn btn-primary">Go</button> 
				</div>	
			</div>
			<div class="wildcard checkbox"></div>
-->
			<h5 class="narrow_by_duty_station_text"></h5>
			<div class="dutyStationButtons"></div>
		  </div>
		  <div class="modal-body">

			<h3 class="gcd_results"></h3>

			<div class="table-responsive">	
				<table class="table table-striped">
					<thead>
						<tr>
						</tr>
					</thead>
					<tbody>


					</tbody>
				</table>
			</div>	
			
			<div class="gcd_pagination">
			</div>

		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default"><a href="/content/update-information-global-contact-directory">Update my information</a></button>
			<button type="button" class="btn btn-default"><a href="/content/additional-phone-resources">Additional resources</a></button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>  

