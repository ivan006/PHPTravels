<?php
 
 //Wish list global function for all modules
if (!function_exists('wishListInfo')) {

 function wishListInfo($module, $id){
 	$inwishlist = pt_isInWishList($module, $id);
 	if($inwishlist){
 	$html = '<div title="'.trans('028').'" data-toggle="tooltip" data-placement="left" id="'.$id.'" data-module="'.$module.'" class="wishlist wishlistcheck '.$module.'wishtext'.$id.' fav"><a  class="tooltip_flip tooltip-effect-1" href="javascript:void(0);"><span class="'.$module.'wishsign'.$id.' fav">-</span></a></div>';
 	}else{
 	$html = '<div  title="'.trans('029').'" data-toggle="tooltip" data-placement="left" id="'.$id.'" data-module="'.$module.'" class="wishlist wishlistcheck '.$module.'wishtext'.$id.'"><a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);"><span class="'.$module.'wishsign'.$id.'">+</span></a></div>';
 	}

 	return $html;

 }

}

//Tours locations part on home page
if (!function_exists('toursWithLocations')) {

 function toursWithLocations(){
 	$appObj = appObj();
 	$toursLib = $appObj->load->library('tours/tours_lib');
 	$totalLocations = 7;
 	$locationData = $toursLib->toursByLocations($totalLocations);
 	return $locationData;

 }

}

//Tours locations part on home page
if (!function_exists('searchForm')) {

 function searchForm($module = "hotels"){
 	$appObj = appObj(); 
 	$themeData = (object)$appObj->theme->_data;

	//$themeData->checkin = date($themeData->app_settings[0]->date_f,strtotime('+'.CHECKIN_SPAN.' day', time()));
	$themeData->checkinMonth = strtoupper(date("F",convert_to_unix($themeData->checkin)));
	$themeData->checkinDay = date("d",convert_to_unix($themeData->checkin));
	//$themeData->checkout = date($themeData->app_settings[0]->date_f, strtotime('+'.CHECKOUT_SPAN.' day', time()));
	$themeData->checkoutMonth = strtoupper(date("F",convert_to_unix($themeData->checkout)));
	$themeData->checkoutDay = date("d",convert_to_unix($themeData->checkout));

 

	$themeData->eancheckin = date("m/d/Y", convert_to_unix($themeData->eancheckin,"m/d/Y"));
	$themeData->eancheckout = date("m/d/Y", convert_to_unix($themeData->eancheckout,"m/d/Y"));

  $themeData->eancheckinMonth = strtoupper(date("F",convert_to_unix($themeData->eancheckin,"m/d/Y")));
  $themeData->eancheckinDay = date("d",convert_to_unix($themeData->eancheckin,"m/d/Y"));

  $themeData->eancheckoutMonth = strtoupper(date("F",convert_to_unix($themeData->eancheckout,"m/d/Y")));
  $themeData->eancheckoutDay = date("d",convert_to_unix($themeData->eancheckout,"m/d/Y"));

	$themeData->ctcheckin = date("m/d/Y", strtotime("+1 days"));
	$themeData->ctcheckout = date("m/d/Y", strtotime("+2 days"));

  $tourType = @$_GET['type'];

 	?>	
 	<div ng-controller="autoSuggestCtrl">         

<?php if(pt_main_module_available($module)){ 
if($module == "flightsdohop"){ ?>
<!-- Dohop Flights Search -->
              <form action="//whitelabel.dohop.com/w/<?php echo $themeData->dohopusername;?>/" method="GET" target="_blank">
                <div class="go-right">
                  <i class="icon-location-6 locaicon"></i>
                  <div style="min-height:50px" class="col-md-6 go-right">
                    <div class="row">
                      <input placeholder="<?php echo trans('0119');?>" required id="a1" name="a1" type="text" class="form-control RTL search-location form-control-icon sterm searchInput fadeIn animated" placeholder="<?php echo trans('0273');?>" autocomplete="off" required />
                      <div id="a1resp" class="autosuggest"></div>
                    </div>
                  </div>
                  <i class="icon-location-6 locaicon"></i>
                  <div style="min-height:50px" class="col-md-6 go-right">
                    <div class="row">
                      <input placeholder="<?php echo trans('0120');?>" required id="a2" name="a2" type="text" class="form-control RTL search-location form-control-icon sterm searchInput fadeIn animated" placeholder="<?php echo trans('0120');?>" autocomplete="off" required />
                      <div id="a2resp" class="autosuggest"></div>
                    </div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block chkin">
                  <h4  class="check text-center"><?php echo trans('0472');?></h4>
                  <div class="days text-center"><span id="dpfd1chkinDay"> <?php echo $themeData->checkinDay; ?> </span> <i class="chevron size14 fa fa-chevron-down"></i></div>
                  <h5  class="months text-center"><span id="dpfd1chkinMonth"> <?php echo $themeData->checkinMonth; ?> </span></h5>
                  <input type="text" class="form-control mySelectCalendar go-text-left checkinsearch RTL dpfd1 datepick" name="d1" value="" placeholder="<?php echo trans('08');?>" required />
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block selectReturn">
                  <h4  class="check text-center"><?php echo trans('0473');?></h4>
                  <div class="days text-center"><span id="dpfd2chkoutDay"><?php echo $themeData->checkoutDay; ?></span> <i class="chevron size14 fa fa-chevron-up"></i></div>
                  <h5  class="months text-center"><span id="dpfd2chkoutMonth"><?php echo $themeData->checkoutMonth; ?></span></h5>
                  <input type="text" class="returnDate mySelectCalendar checkinsearch RTL dpfd2 go-text-left datepick" name="d2" value="" placeholder="<?php echo trans('08');?>"  />
                </div>
                <div class="col-md-6 col-sm-6 col-xs-6 go-right check-block">
                  <br>
                  <select name="" id="trip" class="selectx">
                    <option value="2"><?php echo trans('0385');?></option>
                    <option value="1"><?php echo trans('0384');?></option>
                  </select>
                </div>
                <button type="submit" value="<?php echo trans('012');?>"  class="btn-primary btn btn-lg btn-block">
                <i class="icon_set_1_icon-78"></i> <?php echo trans('012');?></button>
              </form>
              <script type="text/javascript"> $(function(){ $("#trip").on("change",function(){ var tripVal = $(this).val(); if(tripVal == "1"){ $(".selectReturn").hide(); $(".returnDate").prop("disabled","disabled"); }else{ $(".returnDate").prop("disabled",""); $(".selectReturn").show(); } }) }) </script>
<!-- End Dohop Flights Search -->
<?php }elseif($module == "cartrawler"){ ?>
<!-- Start Cartrawler Form -->

 <form action="<?php echo base_url();?>car/" method="GET" target="_self">
                <div class="col-md-6 col-sm-6 go-right check-block-half">
                  <div class="row">
                    <input required id="ct1" name="startlocation" type="text" class="searchInput form-control RTL search-location form-control-icon ctlocation" placeholder="<?php echo trans('0210');?>" autocomplete="off" required />
                    <div id="ct1resp" class="autosuggest col-md-11 col-sm-11"></div>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6">
                  <div class="row">
                    <input id="ct2" name="endlocation" type="text" class="searchInput form-control RTL search-location form-control-icon ctlocation" placeholder="<?php echo trans('0211');?>" autocomplete="off" />
                    <div id="ct2resp" class="autosuggest col-md-11 col-sm-11"></div>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block chkin">
                  <h4  class="check text-center"><i class="icon-calendar-7"></i> <?php echo trans('0210');?> <?php echo trans('08');?></h4>
                  <div class="days text-center"><span id="dpcd1departcarDay"> <?php echo $themeData->checkinDay; ?> </span> <i class="chevron size14 fa fa-chevron-down"></i></div>
                  <h5  class="months text-center"><span id="dpcd1departcarMonth"> <?php echo $themeData->checkinMonth; ?> </span></h5>
                  <input type="text" class="datepick form-control-icon form-control checkinsearch RTL icon-calendar dpcd1" name="pickupdate" value="<?php echo $themeData->ctcheckin;?>" placeholder="<?php echo trans('08');?>" required />
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block">
                  <h4  class="check text-center go-right"><i class="icon_set_1_icon-38"></i> <?php echo trans('0210');?> <?php echo trans('0259');?></h4>
                  <div class="clearfix form-group"></div>
                  <select class="selectx" name="timeDepart">
                    <?php foreach($themeData->timing as $time){ ?>
                    <option value="<?php echo $time; ?>" <?php makeSelected('10:00',$time); ?> ><?php echo $time; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block chkout">
                  <h4  class="check text-center"><i class="icon-calendar-7"></i> <?php echo trans('0211');?> <?php echo trans('08');?></h4>
                  <div class="days text-center"><span id="dpcd2returncarDay"><?php echo $themeData->checkoutDay; ?></span> <i class="chevron size14 fa fa-chevron-up"></i></div>
                  <h5  class="months text-center"><span id="dpcd2returncarMonth"><?php echo $themeData->checkoutMonth; ?></span></h5>
                  <input type="text" class="datepick form-control-icon form-control checkinsearch RTL icon-calendar dpcd2" name="dropoffdate" value="<?php echo $ctcheckout;?>" placeholder="<?php echo trans('08');?>" required />
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block">
                  <h4  class="check text-center go-right"><i class="icon_set_1_icon-38"></i> <?php echo trans('0211');?> <?php echo trans('0259');?></h4>
                  <div class="clearfix form-group"></div>
                  <select class="selectx" name="timeReturn">
                    <?php foreach($themeData->timing as $time){ ?>
                    <option value="<?php echo $time; ?>" <?php makeSelected('10:00',$time); ?> ><?php echo $time; ?></option>
                    <?php } ?>
                  </select>
                </div>
                 <input type="hidden" id="pickuplocation" name="pickupLocationId" value="">
                <input type="hidden" id="returnlocation" name="returnLocationId" value="">
                <input type="hidden" name="clientId" value="<?php echo $themeData->cartrawlerid;?>">
                <input type="hidden" name="residencyId" value="PK">

                    <input type="submit" value="<?php echo trans('012');?>" class="btn-primary btn btn-lg btn-block">
              </form>

<!-- End Cartrawler Form -->
<?php }else{ ?>
              <form autocomplete="off" action="<?php echo base_url().$module;?>/search" method="GET" role="search">

              	<?php if($module == "cars"){ ?> 
              	<!-- Cars search form -->
              	<div class="col-md-6 col-sm-6 go-right check-block-half">
              	<div class="row">
                    <select name="pickupLocation" class="carsearch chosen-select RTL" id="carlocations" required >
                      <option><?php echo trans('0210');?> <?php echo trans('032');?></option>
                      <?php foreach($themeData->carspickuplocationsList as $locations): ?>
                      <option value="<?php echo $locations->id;?>" <?php makeSelected($themeData->selectedpickupLocation,$locations->id); ?> ><?php echo $locations->name;?></option>
                      <?php endforeach; ?>
                    </select>
                 </div>
                 </div>
                <div class="col-md-6 col-sm-6">
                  <div class="row">
                    <select name="dropoffLocation" class="carsearch chosen-select RTL" id="carlocations2" required >
                      <option><?php echo trans('0211');?> <?php echo trans('032');?></option>
                      <?php foreach($themeData->carsdropofflocationsList as $locations): ?>
                      <option value="<?php echo $locations->id;?>" <?php makeSelected($themeData->selecteddropoffLocation,$locations->id); ?> ><?php echo $locations->name;?></option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block chkin">
                  <h4  class="check text-center"><i class="icon-calendar-7"></i> <?php echo trans('0210');?> <?php echo trans('08');?></h4>
                  <div class="days text-center"><span id="departcarDay"> <?php echo $themeData->checkinDay; ?> </span> <i class="chevron size14 fa fa-chevron-down"></i></div>
                  <h5  class="months text-center"><span id="departcarMonth"> <?php echo $themeData->checkinMonth; ?> </span></h5>
                  <input type="text" class="datepick form-control RTL" id="departcar" name="pickupDate" placeholder="<?php echo trans('08');?>" value="<?php echo $themeData->checkin; ?>" required>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block">
                  <h4  class="check text-center go-right"><i class="icon_set_1_icon-38"></i> <?php echo trans('0210');?> <?php echo trans('0259');?></h4>
                  <div class="clearfix form-group"></div>
                  <select class="selectx" name="pickupTime">
                    <?php foreach($themeData->carModTiming as $time){ ?>
                    <option value="<?php echo $time; ?>" <?php makeSelected($themeData->pickupTime,$time); ?> ><?php echo $time; ?></option>
                    <?php } ?>
                  </select>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block chkout">
                  <h4  class="check text-center"><i class="icon-calendar-7"></i> <?php echo trans('0211');?> <?php echo trans('08');?></h4>
                  <div class="days text-center"><span id="returncarDay"><?php echo $themeData->checkoutDay; ?></span> <i class="chevron size14 fa fa-chevron-up"></i></div>
                  <h5  class="months text-center"><span id="returncarMonth"><?php echo $themeData->checkoutMonth; ?></span></h5>
                  <input type="text" class="datepick form-control RTL" id="returncar" name="dropoffDate" placeholder="<?php echo trans('08');?>" value="<?php echo $themeData->checkout; ?>" required>
                </div>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block">
                  <h4  class="check text-center go-right"><i class="icon_set_1_icon-38"></i> <?php echo trans('0211');?> <?php echo trans('0259');?></h4>
                  <div class="clearfix form-group"></div>
                  <select class="selectx" name="dropoffTime">
                    <?php foreach($themeData->carModTiming as $time){ ?>
                    <option value="<?php echo $time; ?>" <?php makeSelected($themeData->dropoffTime,$time); ?> ><?php echo $time; ?></option>
                    <?php } ?>
                  </select>
                </div>
              	<!-- End Cars search form -->

              	<?php }else{ ?>
                <div class="go-text-right">
                  <i class="icon-location-6 locaicon"></i>
                  <?php if($module == "ean"){ ?> 
                  <!-- Child Ages Modal -->
                     <style> .modal-backdrop { z-index: 99; } </style>
                      <script> $(function() { google.maps.event.addDomListener(window,"load",function(){new google.maps.places.Autocomplete(document.getElementById("HotelsPlacesEan"))}); }); </script>
            		  <script type="text/javascript"> $(function(){ $(".childcount").on("change",function(){ var count = $(this).val(); var ages = []; if(count > 0){ for(i = 1; i <= count; i++){ ages.push('0'); } $("#childages").val(ages); $(".ageselect").empty(); addChildsAgeField(count); $("#ages").modal('show'); }else{ $("#childages").val(""); } }) }); function addChildsAgeField(children) { var childagestxt = ''; for (child = 1; child <= children; child++) { var StringChildAge = ''; StringChildAge = '\ <label for="form-input-popover" class="col-sm-4 control-label">'+child+' Age</label><div class="col-sm-8">\n\ <select class="room-child-age form-control" onchange="updateChildAges();">\n\ <option value="0"> Under 1 </option>\n\ <option value="1">1</option>\n\ <option value="2">2</option>\n\ <option value="3">3</option>\n\ <option value="4">4</option>\n\ <option value="5">5</option>\n\ <option value="6">6</option>\n\ <option value="7">7</option>\n\ <option value="8">8</option>\n\ <option value="9">9</option>\n\ <option value="10">10</option>\n\ <option value="11">11</option>\n\ <option value="12">12</option>\n\ <option value="13">13</option>\n\ <option value="14">14</option>\n\ <option value="15">15</option>\n\ <option value="16">16</option>\n\ <option value="17">17</option>\n\ </select></div>'; $(".ageselect").append(StringChildAge); } } function updateChildAges(){ var selectedAges = []; $('.room-child-age option:selected').each(function () { selectedAges.push($(this).val()); }); $("#childages").val(selectedAges); } </script>
                  <!-- End Child Ages Modal -->
                  <!-- Start EAN search input -->
					 <input style="min-height:50px" required id="HotelsPlacesEan" name="city" type="text" class="searchInput form-control input-lg RTL search-location form-control-icon" placeholder="<?php echo trans('026');?>" value="<?php echo @$_GET['city']; ?>" required />
                   <!-- End EAN search input -->
				 <!-- Start Modal child ages -->
               <div class="modal fade" id="ages" tabindex="1" role="dialog" aria-hidden="true" style="margin-top:-70px">
                <div class="modal-dialog modal-sm" style="z-index: 9999;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel"><?php echo trans('011');?></h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group form-horizontal ageselect"> </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer"> <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo trans('0233');?></button> </div>
                  </div>
                </div>
              </div>
              <div class="modal fade" id="ages" tabindex="1" role="dialog" aria-hidden="true" style="margin-top:-70px">
                <div class="modal-dialog modal-sm" style="z-index: 9999;">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title" id="myModalLabel"><?php echo trans('011');?></h4>
                    </div>
                    <div class="modal-body">
                      <div class="form-group form-horizontal ageselect"> </div>
                      <div class="clearfix"></div>
                    </div>
                    <div class="modal-footer"> <button type="button" class="btn btn-primary" data-dismiss="modal"><?php echo trans('0233');?></button> </div>
                  </div>
                </div>
              </div>
              <!-- End Modal child ages -->
                  <?php }else{  ?>
                  <!-- Start Autosuggest textbox for hotels/tours -->
                    <input type="text" name="txtSearch" ng-model="selected" placeholder="<?php if($module == 'hotels'){ echo trans('026'); }elseif($module == 'tours'){ echo trans('0526'); } ?>" uib-typeahead="result as result.name for result in getResults($viewValue,'<?php echo base_url();?>home/suggestions/<?php echo $module;?>')" typeahead-loading="loadingLocations" typeahead-no-results="noResults" typeahead-popup-template-url="customTemplateResults.html" typeahead-on-select="onSelect($item, $model, $label)" typeahead-min-length='2' class="form-control searchInput">
                    <i ng-show="loadingLocations" class="glyphicon glyphicon-refresh"></i>
                    <div class="noResults" ng-show="noResults">
                      <i class="glyphicon glyphicon-remove"></i> <?php echo trans('066'); ?>
                    </div>
                  <!-- End Autosuggest textbox for hotels/tours -->
                  <?php } ?>
                </div>
                <div class="clearfix"></div>

              
                <div id="<?php if($module == 'hotels'){ echo 'dpd1'; }elseif($module == 'ean'){ echo 'dpean1'; }elseif($module == 'tours'){ echo 'tchkin'; } ?>" class="col-md-3 col-sm-6 col-xs-6 check-block focusDateInput go-right">
                  <h4  class="check text-center"><?php echo trans('07');?></h4>
                  <div class="clearfix"></div>
                  <div class="days text-center"><span id="<?php if($module == 'hotels'){ echo 'dpd1'; }elseif($module == 'ean'){ echo 'dpean1'; }elseif($module == 'tours'){ echo 't'; } ?>chkinDay"> <?php if($module == "ean"){ echo $themeData->eancheckinDay; }else{ echo $themeData->checkinDay; }; ?> </span> <i class="chevron size14 fa fa-chevron-down"></i></div>
                  <h5  class="months text-center"><span id="<?php if($module == 'hotels'){ echo 'dpd1'; }elseif($module == 'ean'){ echo 'dpean1'; }elseif($module == 'tours'){ echo 't'; } ?>chkinMonth"> <?php if($module == "ean"){ echo $themeData->eancheckinMonth; }else{ echo $themeData->checkinMonth; }; ?> </span></h5>
                  <input type="text" placeholder="<?php echo trans('07');?>" name="<?php if($module == 'hotels' || $module == 'ean'){ echo 'checkin'; }elseif($module == 'tours'){ echo 'date'; } ?>" class="datepick <?php if($module == 'hotels'){ echo 'dpd1'; }elseif($module == 'ean'){ echo 'dpean1'; }elseif($module == 'tours'){ echo 'tchkin'; } ?>" value="<?php if($module == 'ean'){ echo $themeData->eancheckin; }else{ echo $themeData->checkin; } ?>" required >
                </div>
              
  				<?php if($module == "hotels" || $module == "ean"){ ?>
                <div id="dpd2" class="col-md-3 col-sm-6 col-xs-6 go-right check-block focusDateInput">
                  <h4  class="check text-center"><?php echo trans('09');?></h4>
                  <div class="days text-center"><span id="<?php if($module == 'hotels'){ echo 'dpd2'; }elseif($module == 'ean'){ echo 'dpean2'; } ?>chkoutDay"><?php if($module == "ean"){ echo $themeData->eancheckoutDay; }else{ echo $themeData->checkoutDay; }; ?></span> <i class="chevron size14 fa fa-chevron-up"></i></div>
                  <h5  class="months text-center"><span id="<?php if($module == 'hotels'){ echo 'dpd2'; }elseif($module == 'ean'){ echo 'dpean2'; } ?>chkoutMonth"><?php if($module == "ean"){ echo $themeData->eancheckoutMonth; }else{ echo $themeData->checkoutMonth; }; ?></span></h5>
                  <input type="text" style="opacity: 0;" placeholder="<?php echo trans('09');?>" name="checkout" class="datepick <?php if($module == 'hotels'){ echo 'dpd2'; }elseif($module == 'ean'){ echo 'dpean2'; } ?>" value="<?php if($module == 'ean'){ echo $themeData->eancheckout; }else{ echo $themeData->checkout; } ?>" required >
                </div>
                  <?php } ?>

                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block">
                  <h4  class="check text-center"><?php if($module == "hotels" || $module == "ean"){ echo trans('010'); }elseif($module == "tours"){ echo trans('0446'); } ?></h4>
                  <div class="clearfix"></div>
                  <div class="numbers-row">
                    <input style="margin-top: -20px;" type="text" id="adults" class="qty2 days center-block" name="adults" value="<?php echo $themeData->adults; ?>">
                    <div class="minusplus inc button_inc">+</div>
                    <div class="minusplus dec button_inc">-</div>
                  </div>
                </div>

                <?php if($module == "hotels" || $module == "ean"){ ?>
                <div class="col-md-3 col-sm-6 col-xs-6 go-right check-block">
                  <h4  class="check text-center"><?php echo trans('011');?></h4>
                  <div class="clearfix"></div>
                  <?php if($module == "hotels"){ ?>
                  <div class="numbers-row">
                    <input style="margin-top: -20px;" type="text" id="child" class="qty2 days center-block" name="child" value="<?php echo $themeData->child; ?>">
                    <div class="minusplus inc button_inc">+</div>
                    <div class="minusplus dec button_inc">-</div>
                  </div>
                  <?php }else{  ?>
                  <br>
                 <select class="form-control selectx childcount" placeholder=" <?php echo trans('011');?> " name="child" id="child">
                  <?php for($i = 0; $i <= 4; $i++){ ?>
                   <option value="<?php echo $i; ?>" <?php makeSelected($themeData->child,$i); ?> > <?php echo $i; ?></option>
                   <?php } } ?>
                 </select>

                </div>
                <?php } ?>
				
				<?php if($module == "tours"){ ?>
				<div class="col-md-6 col-sm-6 col-xs-6 go-right check-block">
				<h4  style="font-size: 12px; margin-bottom: 5px; font-weight: bold;" class="check text-center go-right"><?php echo trans('0222');?></h4>
				<select class="selectx RTL" name="type" id="tourtype" >
				<option value=""> <?php echo trans('0158');?></option>
				<?php foreach($themeData->moduleTypes as $ttype){ ?>
				<option value="<?php echo $ttype->id;?>" <?php makeSelected($tourType,$ttype->id); ?> ><?php echo $ttype->name;?> </option>
				<?php } ?>
				</select>
				</div>
				<?php } if($module == "ean"){ ?>
				<input type="hidden" name="childages" id="childages" value="<?php echo $themeData->childages; ?>">
               <input type="hidden" name="search" value="search" >
				<?php }else{ ?>
                <input type="hidden" name="searching" value="{{searching}}"> <input type="hidden" name="modType" value="{{modType}}"> 
        <?php } } ?>

              <button type="submit"  class="btn-primary btn btn-lg btn-block"><i class="icon_set_1_icon-78"></i> <?php echo trans('012');?></button>
              </form>
<?php } } ?>
</div>
<?php 
 
 }

} //end searchForm function