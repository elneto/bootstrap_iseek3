<?php
/**
 * @file
 * Template for the weather module. 
 * Modified by KSD the Drupal way according to: https://www.drupal.org/node/341628
 */
?>
<div class="row">
  <div class="col-lg-12">
    <div class="timezone large-text">&nbsp;<i class="fa fa-sun-o fa-2x"></i>&nbsp;&nbsp;<?php print t('Time zone and weather');?></span>
      <a data-toggle="collapse" data-target="#weather-box" aria-expanded="true" aria-controls="weather-box" class="visible-xs collapser"><i class="fa fa-angle-down"></i></a>  
    </div>
  </div>
</div>
<div class="row collapse in" id="weather-box">
  <div class="col-md-12 col-lg-6 timezone-pad-r0">
    <div class="dutystaion-container ">
      <?php 
      //to get the time now:
      $city = [
        "Addis Ababa" => "Africa/Addis_Ababa",
        "Bangkok" => "Asia/Bangkok",
        "Beirut" => "Asia/Beirut",
        "Geneva" => "Europe/Berlin",
        "Nairobi" => "Africa/Nairobi",
        "New York" => "America/New_York",
        "Santiago" => "America/Mendoza",
        "Vienna" => "Europe/Vienna",
      ];

      $i = 0;
      foreach($weather as $place): 
        $iSeekTime = format_date(time(), "custom", "H:i", $city[$place['name']]); 
	$iSeekDate = format_date(time(), "custom", "D j M", $city[$place['name']]);	

          if ($i == 4): //2nd row?>
            </div></div>
              <div class="col-md-12 col-lg-6 timezone-pad-l0">
              <div class="dutystaion-container ">
          <?php endif ?>

        <?php if ($i!=7): ?>
          <div class="col-md-3 col-xs-6 dutystaion">
        <?php else: //the final square (Vienna)?>
          <div class="col-md-3 col-xs-6 dutystaion-last">
        <?php endif ?>
          
          <div class="duty-station-city duty-margin"><?php print t($place['name']); ?></div> <!-- $place['link'] links to forecast -->
          <?php if (empty($place['forecasts'])): ?>
            <?php print(t('Currently, there is no weather information available.')); ?>
          <?php endif ?>
          <?php foreach($place['forecasts'] as $forecast): ?>
            <?php foreach($forecast['time_ranges'] as $time_range => $data): ?>
              <div class="medium-text duty-margin"><?php print $iSeekDate; ?></div>
              <div class="medium-text duty-margin time"><?php print $iSeekTime; ?></div>
              
              <div class="row ">
                <div class="col-lg-3">      
                  <?php print $data['symbol']; ?>
                </div>
                <div class="col-lg-9 duty-padding">
                    <div class="row medium-text ">
                      <?php print $data['condition']; ?>
                    </div>
                    <div class="row medium-text temp">
                      <?php print $data['temperature']; ?>
                    </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php endforeach; ?>
          <?php if (isset($place['station'])): ?>
            <p style="clear:left">
              <?php print t('Location of this weather station:'); ?><br />
              <?php print $place['station']; ?>
            </p>
          <?php endif ?>
         
        </div> 

      <?php 
      $i++;
      endforeach; ?>
    </div>
  </div>
</div> <!-- end of main row-->
