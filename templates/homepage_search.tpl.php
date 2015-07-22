            <h3 class="top-side-box nohoverfx top-boxes-margin">&nbsp;<i class="fa fa-search"></i>&nbsp;&nbsp;<?php print t('Search');?>
            <a data-toggle="collapse" data-target="#search-box" aria-expanded="true" aria-controls="search-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>
            </h3>
            <div id="search-box" class="collapse in">
		<div id="search-form">
                <!-- <form id="search-form"> -->
                        <div class="row">
                                <div class="col-xs-12">
                                        <label for="input-search-iseek"><?php print t('Find a colleague by name, department, and more');?></label>
                                </div>
                                <div class="col-lg-9 col-xs-8 search-rpad0">
					<input class="search-input" name="query" type="text" id="searchSimpleInput">
                                </div>
                                <div class="col-lg-3 col-xs-4 search-lpad0">
					<button id="searchTriggerSimple" type="button" class="search-button" data-toggle="modal" data-target="#myModal"><?php print t('Search');?></button>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-md-12">
                                        <div id="search-links">
                                                <a href="<?php print t('content/update-information-global-contact-directory');?>"><?php print t('Update my information');?></a>  |
                                                <span id="searchTriggerAdvanced"><?php print t('Advanced search');?></span> |
                                                <a href="<?php print t('content/additional-phone-resources');?>"><?php print t('Additional resources');?></a>
                                        </div>
                                </div>
                        </div>
                        <div class="row">
                                <div class="col-xs-12">
                                        <label for="input-search-iseek"><?php print t('Search iSeek or ODS');?></label> <!-- placeholder="Search the UN Intranet or ODS"  !-->
                                </div>
                                <div class="col-lg-7 col-md-7 col-xs-5 search-rpad0">
                                        <input type="text" name="search-intranet" class="search-input" id="input-search-iseek">
                                </div>
                                <div class="col-lg-2 col-md-2 col-xs-3 search-lpad0 search-rpad0" id="select-search-default-container">
                                        <select id="select-search" class="search-input"> 
                                                <option>iSeek</option>
                                                <option>ODS</option>
                                        </select>
                                </div>
                                <div class="col-lg-3 col-md-3 col-xs-4 search-lpad0">
                                        <button id="searchIseekOrOds" name="Search" class="search-button"><?php print t('Search');?></button>
                                </div>
                        </div>
		</div> 
                <!-- </form> -->
            </div>

