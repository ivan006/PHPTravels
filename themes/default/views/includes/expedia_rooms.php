<section  id="ROOMS" style="background-color:#FFFFFF">
  <div style="background-color:#F7F7F7">
    <div class="rooms-update">
      <form  action="" method="GET" role="search">
        <div class="col-md-2 col-sm-2 go-right">
          <div class="form-group">
            <label class="size12 RTL go-right"><i class="icon-calendar-7"></i> <?php echo trans('07');?></label>
            <input type="text" placeholder="<?php echo trans('07');?>" name="checkin" class="form-control dpean1" value="<?php echo $checkin;?>" required>
          </div>
        </div>
        <div class="col-md-2 col-sm-2 go-right">
          <div class="form-group">
            <label class="size12 RTL go-right"><i class="icon-calendar-7"></i> <?php echo trans('09');?></label>
            <input type="text" placeholder="<?php echo trans('09');?>" name="checkout" class="form-control dpean2" value="<?php echo $checkout;?>" required>
          </div>
        </div>
        <div class="col-md-2 col-sm-1 go-right">
          <div class="form-group">
            <label class="size12 RTL go-right"><i class="icon-user-7"></i> <?php echo trans('010');?></label>
            <select class="mySelectBoxClass form-control" name="adults" id="adults">
              <?php for($i = 1; $i <= $maxAdults;$i++){ ?>
              <option value="<?php echo $i;?>" <?php makeselected($i,$adultsCount); ?> ><?php echo $i;?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-2 col-sm-1 go-right">
          <div class="form-group">
            <label class="size12 RTL go-right"><i class="icon-user-7"></i> <?php echo trans('011');?></label>
            <select class="mySelectBoxClass form-control childcount" name="child" id="child">
              <option selected value="0">0</option>
              <?php for($child = 1; $child < 6;$child++){ ?>
              <option value="<?php echo $child;?>" <?php if($child == $childCount){ echo "selected"; } ?>> <?php echo $child;?> </option>
              <?php } ?>
            </select>
          </div>
        </div>
        <div class="col-md-4 go-right">
          <label>&nbsp;</label>
          <input type="hidden" name="ages" id="childages" value="<?php echo $childAges; ?>">
          <button class="btn btn-block btn-success btn-update textupper"><?php echo trans('0106');?></button>
        </div>
      </form>
      <div class="clearfix"></div>
    </div>
    <div class="alert alert-danger">
      <h4><?php echo trans('0370');?></h4>
      <span class="size14">
      <?php echo trans('0378');?>
      </span>
    </div>
    <?php if(empty($rooms)){ echo '<h1 class="text-center">' . trans("066") . '</h1>'; }else{ ?>
    <?php foreach($rooms as $room){ $roomImg = str_replace("_s","_z",$room['RoomImages']['RoomImage'][0]['url']); if(empty($roomImg)){ $roomImg = PT_BLANK; } ?>
    <form action="" method="GET">
      <div class="rooms-update" style="margin-top:0px;margin-bottom:0px">
        <div class="col-lg-3 col-md-4 col-sm-4 offset-0 go-right">
          <div class="zoom-gallery<?php echo $room['rateCode']; ?>">
            <a href="<?php echo $roomImg; ?>" data-source="<?php echo $roomImg; ?>" title="<?php echo $room['rateDescription']; ?>">
            <img class="img-responsive" src="<?php echo $roomImg; ?>">
            </a>
          </div>
        </div>
        <div class="col-lg-9 col-md-8 offset-0">
          <div class="labelright go-left" style="min-width:180px;margin-left:5px">
            <span class="green size20">
            <?php
              $nightlyRate = $room['RateInfos']['RateInfo']['ConvertedRateInfo']['@maxNightlyRate'];
              $currency = $room['RateInfos']['RateInfo']['ConvertedRateInfo']['@currencyCode'];
              if(empty($nightlyRate)){
              $nightlyRate = $room['RateInfos']['RateInfo']['ChargeableRateInfo']['@maxNightlyRate'];
              $currency = $room['RateInfos']['RateInfo']['ChargeableRateInfo']['@currencyCode'];
              }

              ?>
            <b>
            <small><?php echo $currency; ?>  </small> <?php echo $nightlyRate; ?>
            </b></span><br/>
            <span class="size11 grey"><?php echo trans('0245');?></span>
            <br/>
            <div class="clearfix"></div>
            <br>
            <div class="book">
              <span <?php if(!empty($loggedin)){ ?> onclick="booknow()" <?php }else{ ?> data-toggle="modal" data-target="#book<?php echo $room['rateCode'];?>" <?php } ?> class="btn btn-action btn-block"><?php echo trans('0142');?></span>
              <br><small><strong> <?php echo trans('0542'); ?></strong> </small> <br>
            </div>
          </div>
          <div style="line-height: 13px" class="labelleft2 rtl_title_home go-text-right RTL">
            <h4 class="mtb0 RTL go-text-right"><b><?php echo $room['rateDescription']; ?></b></h4>
            <h5 style="color:#8A8A8A"><?php echo trans('010');?> <?php echo $room['rateOccupancyPerRoom'];?> </h5>
            <hr>
            <div class="col-md-6 visible-lg visible-md go-right" id="accordion" style="margin-top: 0px;">
              <div class="row">
                <?php if($room['RateInfos']['RateInfo']['nonRefundable']){ ?>
                <button data-toggle="collapse" data-parent="#accordion" class="hidden-xs btn btn-danger"  href="#nonrefund<?php echo $room['rateCode'];?>"><?php echo trans('0309');?></button>
                <?php }else{ ?>
                <span class="hidden-xs btn btn-success"><?php echo trans('0344');?></span>
                <?php } ?>
                <button data-toggle="collapse" data-parent="#accordion" class="hidden-xs btn btn-info"  href="#details<?php echo $room['rateCode'];?>"><?php echo trans('052');?></button>
              </div>
            </div>
            <br><br><br>
            <p class="grey RTL"><?php echo character_limiter($r->desc, 280);?></p>
            <br/>
            <ul class="hotelpreferences go-right hidden-xs">
              <?php $cnt = 0; foreach($item->amenities as $amt){ $cnt++; if($cnt <= 10){ if(!empty($amt['name'])){ ?>
              <img title="<?php echo $amt['name'];?>" data-toggle="tooltip" data-placement="top" style="height:25px;" src="<?php echo $amt['icon'];?>" alt="<?php echo $amt['name'];?>" />
              <?php } } } ?>
            </ul>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </form>
    <div class="clearfix"></div>
    <!-- refund policy -->
    <div id="nonrefund<?php echo $room['rateCode'];?>" class="alert alert-danger panel-collapse collapse">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="clearfix"></div>
          <p><?php echo $room['RateInfos']['RateInfo']['cancellationPolicy']; ?></p>
        </div>
      </div>
    </div>
    <!-- refund policy -->
    <div id="details<?php echo $room['rateCode'];?>" class="alert alert-warning panel-collapse collapse">
      <div class="panel panel-default">
        <div class="panel-body">
          <div class="carousel magnific-gallery row">
            <?php $imgCount = 0; foreach($room['RoomImages']['RoomImage'] as $Img){ $imgCount++; if($imgCount <= 4){ $imgurl = str_replace("_s","_z",$Img['url']); ?>
            <div class="col-md-3">
              <div class="zoom-gallery<?php echo $room['rateCode'];?>">
                <a href="<?php echo $imgurl;?>" data-source="<?php echo $imgurl;?>" title="<?php echo $room['rateDescription']; ?>">
                <img class="img-responsive" style="max-height:144px" src="<?php echo $imgurl;?>">
                </a>
              </div>
            </div>
            <script type="text/javascript">
              $('.zoom-gallery<?php echo $r->id; ?>').magnificPopup({
                delegate: 'a',
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                image: {
                  verticalFit: true,
                  titleSrc: function(item) {
                    return item.el.attr('title') + ' ';
                  }
                },
                gallery: {
                  enabled: true
                },
                zoom: {
                  enabled: true,
                  duration: 300, // don't foget to change the duration also in CSS
                  opener: function(element) {
                    return element.find('img');
                  }
                }

              });

            </script>
            <?php } } ?>
          </div>
          <p>
            <!--<strong><?php echo trans('046');?> : </strong>-->
          </p>
          <p><?php echo $room['RoomType']['descriptionLong']; ?></p>
          <p></p>
          <hr>
          <p><strong><?php echo trans('055');?> : </strong></p>
          <?php foreach($room['RoomType']['roomAmenities']['RoomAmenity'] as $roomAmenity){ ?>
          <div class="col-md-4">
            <ul class="checklist">
              <li><?php echo $roomAmenity['amenity'];?></li>
            </ul>
          </div>
          <?php } ?>
          <div class="clearfix"></div>
        </div>
      </div>
    </div>
    <script type="text/javascript">
      $(".zoom-gallery<?php echo $room['rateCode']; ?>").magnificPopup({
        delegate: 'a',
        type: 'image',
        closeOnContentClick: false,
        closeBtnInside: false,
        mainClass: 'mfp-with-zoom mfp-img-mobile',
        image: {
          verticalFit: true,
          titleSrc: function(item) {
            return item.el.attr('title') + ' ';
          }
        },
        gallery: {
          enabled: true
        },
        zoom: {
          enabled: true,
          duration: 300, // don't foget to change the duration also in CSS
          opener: function(element) {
            return element.find('img');
          }
        }

      });

    </script>
    <script>
      $('.collapse').on('show.bs.collapse', function () {
          $('.collapse.in').collapse('hide');
      });
    </script>
    <!-- Modal -->
    <div class="modal fade" id="book<?php echo $room['rateCode'];?>" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"><?php echo trans('0463');?></h4>
          </div>
          <div class="modal-body">
            <p><?php echo trans('0464');?></p>
            <img src="<?php echo base_url(); ?>assets/img/users.png" class="img-responsive"/>
            <hr>
            <div class="row">
              <div class="col-md-6">
                <form id="bookloginform" action="<?php echo base_url();?>properties/reservation" method="GET">
                  <input type="hidden" name="adults" value="<?php  echo $adultsCount; ?>" />
                  <!-- <input type="hidden" name="child" value="" /> -->
                  <input type="hidden" name="checkin" value="<?php  echo $checkin; ?>" />
                  <input type="hidden" name="checkout" value="<?php  echo $checkout; ?>" />
                  <input type="hidden" name="roomtype" value="<?php echo $room['RoomType']['@roomCode']; ?>" />
                  <input type="hidden" name="ratekey" value="<?php echo $room['RateInfos']['RateInfo']['RoomGroup']['Room']['rateKey']; ?>" />
                  <input type="hidden" name="ratecode" value="<?php echo $room['rateCode']; ?>" />
                  <input type="hidden" name="hotel" value="<?php echo $hotelid; ?>" />
                  <input type="hidden" name="sessionid" value="<?php echo $sessionid;?>" />
                  <button type="submit" class="btn btn-primary btn-block btn-lg"><?php echo trans('04');?></button>
                </form>
              </div>
              <div class="col-md-6">
                <form action="<?php echo base_url();?>properties/reservation" method="GET">
                  <input type="hidden" name="adults" value="<?php  echo $adultsCount; ?>" />
                  <!-- <input type="hidden" name="child" value="" /> -->
                  <input type="hidden" name="checkin" value="<?php  echo $checkin; ?>" />
                  <input type="hidden" name="checkout" value="<?php  echo $checkout; ?>" />
                  <input type="hidden" name="roomtype" value="<?php echo $room['RoomType']['@roomCode']; ?>" />
                  <input type="hidden" name="ratekey" value="<?php echo $room['RateInfos']['RateInfo']['RoomGroup']['Room']['rateKey']; ?>" />
                  <input type="hidden" name="ratecode" value="<?php echo $room['rateCode']; ?>" />
                  <input type="hidden" name="hotel" value="<?php echo $hotelid; ?>" />
                  <input type="hidden" name="sessionid" value="<?php echo $sessionid;?>" />
                  <input type="hidden" name="user" value="guest" />
                  <button type="submit" class="btn btn-success btn-block btn-lg"><?php echo trans('0167');?></button>
                </form>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <?php if($app_settings[0]->allow_registration){ if($app_settings[0]->user_reg_approval == "Yes"){ ?>
            <form action="<?php echo base_url();?>properties/reservation" method="GET">
              <input type="hidden" name="adults" value="<?php  echo $adultsCount; ?>" />
              <!-- <input type="hidden" name="child" value="" /> -->
              <input type="hidden" name="checkin" value="<?php  echo $checkin; ?>" />
              <input type="hidden" name="checkout" value="<?php  echo $checkout; ?>" />
              <input type="hidden" name="roomtype" value="<?php echo $room['RoomType']['@roomCode']; ?>" />
              <input type="hidden" name="ratekey" value="<?php echo $room['RateInfos']['RateInfo']['RoomGroup']['Room']['rateKey']; ?>" />
              <input type="hidden" name="ratecode" value="<?php echo $room['rateCode']; ?>" />
              <input type="hidden" name="hotel" value="<?php echo $hotelid; ?>" />
              <input type="hidden" name="sessionid" value="<?php echo $sessionid;?>" />
              <input type="hidden" name="user" value="register" />
              <button type="submit" class="btn btn-default"><?php echo trans('05');?></button>
            </form>
            <?php } } ?>
            <!--            <button type="button" class="btn btn-danger" data-dismiss="modal"><?php echo trans('0346');?></button>-->
          </div>
        </div>
      </div>
    </div>
    <?php } ?>
    <?php } ?>
    <script>
      jQuery(document).ready(function($) {
      $('.showcalendar').on('change',function(){
         var roomid = $(this).prop('id');
         var monthdata = $(this).val();
        $("#roomcalendar"+roomid).html("<br><br><div id='rotatingDiv'></div>");
       $.post("<?php echo base_url();?>hotels/roomcalendar", { roomid: roomid, monthyear: monthdata}, function(theResponse){ console.log(theResponse);
       $("#roomcalendar"+roomid).html(theResponse);  }); }); });
    </script>
    <script>
      $('.collapse').on('show.bs.collapse', function () {
          $('.collapse.in').collapse('hide');
      });
    </script>
    <script type="text/javascript">
      function booknow(){
        $("#bookloginform").submit();
      }
    </script>
  </div>
</section>