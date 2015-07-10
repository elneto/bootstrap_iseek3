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
                        <i class="fa fa-search"></i> Advanced Search
                  </div>
                  <div class="modal-post-header">
			<button type="button" class="close" data-dismiss="modal">Close <span aria-hidden="true">&times;</span></button>
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
						<button id="searchTriggerAdvancedInModal" type="button" class="btn btn-primary">Search </button> 
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
                        <a href="/content/update-information-global-contact-directory">Update my information</a>
                        |
                        <a href="/content/additional-phone-resources">Additional resources</a>
		  </div>
		</div>
	  </div>
	</div>  

