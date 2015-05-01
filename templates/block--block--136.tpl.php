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
	margin-bottom: 18px;
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
     'phoneDisplay1' => 'The phone number must be entered exactly as it is in the directory. Some duty stations, such as Geneva, list only the extension number, while others, like New York, list the full number (212-963-1234)');
	 
?>


<?php include('sites/iseek.un.org/themes/bootstrap_iseek/js/gcd.js'); ?>

	<section id="block-block-136" class="block block-block clearfix">

		<h2>Find a Colleague</h2>
		
		<div class="content"<?php print $content_attributes; ?>>
			<div class="input-group">
				<input class="form-control" name="query" type="text" id="searchSimpleInput">
				<span class="input-group-btn">
					<button id="searchTriggerSimple" type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Go</button> 
				</span>
			</div>
			<div id="searchTriggerAdvanced">Advanced search</div>
			<div><a class="redlink" href="/content/additional-phone-resources">Additional resources</a></div>
			<div><a href="/content/update-information-global-contact-directory">Update my information</a></div>
		</div>
	</section>  

  <!-- Modal -- simple search -->
	<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalSimpleLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			<h2 class="modal-title" id="myModalLabel">United Nations Global Contact Directory</h2>
			<div class="row">
				<div class="col-sm-4"> 
					<div class="input-group">
						<input class="form-control" name="query" type="text" id="searchSimpleInputInModal">
						<span class="input-group-btn">
							<button id="searchTriggerSimpleInModal" type="button" class="btn btn-primary">Go</button> 
						</span>
					</div>
				</div>
				<div class="col-sm-8"> 
					<div class="wildcard checkbox"></div>
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
			<button type="button" class="btn btn-default" id="searchTriggerAdvancedInSimpleModal">Advanced search</button>
			<button type="button" class="btn btn-default"><a href="/content/update-information-global-contact-directory">Update my information</a></button>
			<button type="button" class="btn btn-default"><a href="/content/additional-phone-resources">Additional resources</a></button>
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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

