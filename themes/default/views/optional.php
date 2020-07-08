<link href="<?php echo $theme_url; ?>assets/include/slider/slider.min.css" rel="stylesheet" />
<script src="<?php echo $theme_url; ?>assets/include/slider/slider.js"></script>
<!--<section class="parallax-window" data-parallax="scroll" data-image-src="<?php echo $hotel->sliderImages[0]['fullImage']; ?>" data-natural-width="300" data-natural-height="200">
  <div class="parallax-content-2">
    <div class="container">
      <div class="row">
        <div class="col-md-8 col-sm-8">
          <h1 class="wow fadeInUp animated title"><?php echo character_limiter($hotel->title, 80);?></h1>
          <span class="title"><i class="icon-location-6"></i> <?php echo $hotel->location; ?> <?php echo $hotel->stars;?></span>
        </div>
         <?php if($avgReviews->overall > 0){ ?>
        <div class="col-md-4 col-sm-4">
          <div id="price_single_main">
            <div class="title" id="score_details"><span><?php echo $avgReviews->overall;?></span> <small>(<?php echo trans('058');?> <?php echo $avgReviews->totalReviews; ?> <?php echo trans('042');?>)</small></div>
          </div>
        </div><?php } ?>
      </div>
    </div>
  </div>
  </section>-->
<!-- End section -->
<div class="collapse" id="collapseMap">
  <div id="map" class="map">
  </div>
</div>
<div class="container">
  <div class="col-md-7">
    <h2 class="wow fadeInUp animated"><strong>New York Marriot Hotel</strong> <?php  for($i=1; $i<=4; $i++) {  ?><small><i class="icon-star text-primary"></i></small><?php } ?></h2>
    <h4><i class="icon-location-6"></i> United States of America</h4>
  </div>
  <div class="col-md-5">
    <div class="row">
      <div class="col-md-6" style="margin-top:10px">
        <h3 class="wow fadeInUp animated"><small>price</small> $220 <small>avg / night</small></h3>
      </div>
      <div class="col-md-6" style="margin-top:20px">
        <a class="btn_map pull-right btn-block" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap"><?php echo trans('067');?></a>
      </div>
    </div>
  </div>
</div>
<div class="container">
  <div class="col-md-12">
    <div class="panel with-nav-tabs panel-default">
      <div class="panel-heading">
        <ul class="nav nav-tabs" style="font-size: 14px;font-weight: bold;">
          <li class="text-center"><a href="#tab2primary" data-toggle="tab">DESCRIPTION</a></li>
          <li class="active text-center"><a href="#tab1primary" data-toggle="tab">ROOMS</a></li>
          <li class="text-center"><a href="#tab2primary" data-toggle="tab">POLICY</a></li>
          <li class="text-center"><a href="#tab2primary" data-toggle="tab">AMENITIES</a></li>
          <li class="text-center"><a href="#tab2primary" data-toggle="tab">REVIEWS</a></li>
          <li class="text-center"><a href="#tab2primary" data-toggle="tab">RELATED</a></li>
        </ul>
      </div>
      <div style="padding:10px">
        <div class="row">
          <div class="col-md-7">
            <div class="fotorama" data-allowfullscreen="true" data-nav="thumbs">
              <?php  for($i=1; $i<=15; $i++) {  ?>
              <img src="http://localhost/Dropbox/v4/uploads/images/hotels/slider/2.jpg" />
              <?php } ?>
            </div>
          </div>
          <div class="col-md-5">
            <div class="c100 p85" style="margin-top:10px">
              <span>8.2</span>
              <div class="slice">
                <div class="bar"></div>
                <div class="fill"></div>
              </div>
            </div>
            <h1>Wonderfull</h1>
            <a href="#">&nbsp;&nbsp;this is dummy text content</a>
            <div class="clearfix"></div>
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. like Aldus PageMaker including versions of Lorem Ipsum <a href="#" class="text-primary"><strong>Read More...</strong></a></p>
            <div class="aboutHotel__amenities__wrap" style="margin-left: 0px;">
              <h4 class="main-title  go-right">Hotel Amenities</h4>
              <div class="clearfix"></div>
              <i class="tiltle-line go-right"></i>
              <div class="clearfix"></div>
              <div class="go-text-right">
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/522827_airport.png"><span class="text-left go-text-right"> Airport Transport</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/593292_receptionist.png"><span class="text-left go-text-right"> Business Center</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/920288_wheelchar.png"><span class="text-left go-text-right"> Disabled Facilities</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/813018_laundry.png"><span class="text-left go-text-right"> Laundry Service</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/53193_858245_wifi.png"><span class="text-left go-text-right"> Wi-Fi Internet</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/906341_bar.png"><span class="text-left go-text-right"> Bar Lounge</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/926605_811401_poll.png"><span class="text-left go-text-right"> Swimming Pool</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/6348_541779_parking.png"><span class="text-left go-text-right"> Inside Parking</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/403809_764557_fitness.png"><span class="text-left go-text-right"> Fitness Center</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/7599_441834_children.png"><span class="text-left go-text-right"> Children Activites</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/162720_hall.png"><span class="text-left go-text-right"> Banquet Hall</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/999481_elevator.png"><span class="text-left go-text-right"> Elevator</span></span></div>
                <div class="row col-md-6" style=""><span style="margin:10px;"><img class="go-right" style="max-height:30px;max-witdh:40px" src="http://localhost/Dropbox/v4/uploads/images/hotels/amenities/179352_pet.png"><span class="text-left go-text-right"> Pets Allowed</span></span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" href="<?php echo $theme_url; ?>assets/css/circle.css" />
<style>
  .aboutHotel__amenities__wrap__ul {
  list-style-type: none;
  float: left;
  }
  ul, li {
  border: 0;
  font-family: inherit;
  font-size: 100%;
  font-style: inherit;
  font-weight: inherit;
  margin: 0;
  outline: 0;
  padding: 0;
  vertical-align: baseline;
  }
  .aboutHotel__amenities__wrap__li {
  float: left;
  display: block;
  margin-right: 1.75788%;
  width: 49.12106%;
  margin: 0;
  color: #383838;
  line-height: 28px;
  font-size: 14px;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  }
  ul, li {
  border: 0;
  font-family: inherit;
  font-size: 100%;
  font-style: inherit;
  font-weight: inherit;
  margin: 0;
  outline: 0;
  padding: 0;
  vertical-align: baseline;
  }
  .line {
  height: 2px;
  width: 40px;
  background-color: #4d9cd7;
  display: inline-block;
  }
  .panel-default > .panel-heading {
  color: rgb(255, 255, 255);
  background-color: #353535;
  border-color: #444444;
  }
  .panel-heading {
  padding-left: 0px;
  padding-top: 0px;
  padding-bottom: 0px;
  border-bottom: 1px solid transparent;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
  }
  .nav > li > a {
  color: #FFF;
  }
</style>
<!-- End Map -->
<section  style="background-color:#f9f9f9">
  <div class="container">
    <aside class="col-lg-10 col-md-12">
      <style>
        .col2 {
        width:17.766667%;
        }
      </style>
      <div class="box_style_1 expose">
        <h3 class="inner"><?php echo trans('027');?></h3>
        <form  action="" method="GET" role="search">
          <div class="col-md-2 col2">
            <div class="form-group">
              <label><i class="icon-calendar-7"></i> <?php echo trans('07');?></label>
              <input type="text" placeholder="<?php echo trans('07');?>" name="checkin" class="form-control dpd1" value="<?php echo $hotelslib->checkin;?>" required>
            </div>
          </div>
          <div class="col-md-2 col2">
            <div class="form-group">
              <label><i class="icon-calendar-7"></i> <?php echo trans('09');?></label>
              <input type="text" placeholder="<?php echo trans('09');?>" name="checkout" class="form-control dpd2" value="<?php echo $hotelslib->checkout;?>" required>
            </div>
          </div>
          <div class="col-md-2 col2">
            <div class="form-group">
              <label><i class="icon-user-7"></i> <?php echo trans('010');?></label>
              <div class="numbers-row">
                <input type="text" value="1" id="adults" class="qty2 form-control" name="adults">
              </div>
            </div>
          </div>
          <div class="col-md-2 col2">
            <div class="form-group">
              <label><i class="icon-user-7"></i> <?php echo trans('011');?></label>
              <div class="numbers-row">
                <input type="text" value="0" id="child" class="qty2 form-control" name="child">
              </div>
            </div>
          </div>
          <div class="col-md-3 col-sm-3"><br>
            <button class="btn btn-lg btn-block btn-success"><?php echo trans('0106');?></button>
          </div>
        </form>
        <div class="clearfix"></div>
      </div>
    </aside>
    <div class="col-md-2 visible-lg">
      <div class="box_style_4">
        <i class="icon_set_1_icon-90"></i>
        <h6><span><?php echo trans('0477');?></span> <?php echo trans('0476');?></h6>
        <a href="#tel://<?php echo $phone; ?>" class="text-primary">+<?php echo $phone; ?></a>
        <!--<small>Monday to Friday 9.00am - 7.30pm</small>-->
      </div>
    </div>
    <!--End row -->
    <div class="clearfix"></div>
    <div class="panel-body">
      <h2 class="main-title go-right">Description</h2>
      <div class="clearfix"></div>
      <i class="tiltle-line go-right"></i>
      <span class="go-right RTL">
        <p>This business hotel is connected to the Congress Center Basel and is only a 15-minute walk away from the centre. It offers elegant rooms, fine cuisine and up-to-date fitness facilities. All rooms have recently been renovated and feature air-conditioning, wired and wireless internet access, an LCD satellite TV, as well as tea and coffee making facilities. At restaurant Grill25 you can enjoy a wide range of steaks and fresh fish from the grill. Also vegetarian dishes are available. Shops, hairdressers and a pharmacy are located right next to the Swissotel Le Plaza Basel. The Swissotel Le Plaza Basel is approximately 15 minutes by taxi from the airport, 10 minutes by public transport from the train station and 5 minutes' walk from the musical theatre.</p>
      </span>
      <div class="clearfix"></div>
      <div class="row">
        <div class="col-md-12">
          <hr>
        </div>
      </div>
      <h4 id="terms" class="main-title  go-right">Policy &amp; Terms</h4>
      <div class="clearfix"></div>
      <i class="tiltle-line  go-right"></i>
      <div class="clearfix"></div>
      <span class="RTL">
        <p>Room service, Car hire, 24-hour front desk, Express check-in/check-out, Currency exchange, Ticket service, Luggage storage, Concierge service, Babysitting/child services, Laundry, Dry cleaning, Ironing service, Meeting/banquet facilities, Business centre, Fax/photocopying, VIP room facilities</p>
      </span>
      <p class="RTL"><i class="fa fa-clock-o text-success"></i> <strong> Check in </strong> :   12 AM - <i class="fa fa-clock-o text-warning"></i>   <strong> Check out </strong> :  04:00 PM </p>
      <div class="row">
        <!--<div class="col-md-4">
          <h4>Payment Options</h4>
          <ul class="list_ok">
                                <li>Credit Card</li>
                      <li>Wire Transfer</li>
                      <li>American Express</li>
                      <li>Paypal</li>
                              </ul>
          </div>-->
        <div class="col-md-12">
          <hr>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-4 col-lg-5" style="border-left: solid 1px #DDD;">
          <h4 class="main-title  go-right">Reviews</h4>
          <div class="clearfix"></div>
          <i class="tiltle-line  go-right"></i>
          <div class="clearfix"></div>
          <div style="margin-bottom:10px"></div>
          <div id="score_detail"><span>6.5</span> <small>(  5 Reviews )</small></div>
          <div class="clearfix"></div>
          <!-- End general_rating -->
          <div class="row" id="rating_summary">
            <div class="">
              <div class="col-xs-2 col-md-3 col-lg-2">
                <label class="text-left">Clean </label>
              </div>
              <div class="col-xs-10 col-md-9 col-lg-10">
                <div class="progress">
                  <div class="progress-bar progress-bar-warning go-right" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="10" style="width: 60%">
                    <span class="sr-only"></span>
                  </div>
                </div>
              </div>
              <div class="col-xs-2 col-md-3 col-lg-2">
                <label class="text-left">Comfort</label>
              </div>
              <div class="col-xs-10 col-md-9 col-lg-10">
                <div class="progress">
                  <div class="progress-bar progress-bar-warning go-right" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 62%">
                    <span class="sr-only"></span>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xs-2 col-md-3 col-lg-2">
              <label class="text-left">Location</label>
            </div>
            <div class="col-xs-10 col-md-9 col-lg-10">
              <div class="progress">
                <div class="progress-bar progress-bar-warning go-right" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 68%">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
            <div class="col-xs-2 col-md-3 col-lg-2">
              <label class="text-left">Facilities</label>
            </div>
            <div class="col-xs-10 col-md-9 col-lg-10">
              <div class="progress">
                <div class="progress-bar progress-bar-warning go-right" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 56%">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
            <div class="col-xs-2 col-md-3 col-lg-2">
              <label class="text-left">Staff</label>
            </div>
            <div class="col-xs-10 col-md-9 col-lg-10">
              <div class="progress">
                <div class="progress-bar progress-bar-warning go-right" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                  <span class="sr-only"></span>
                </div>
              </div>
            </div>
          </div>
          <div class="clearfix"></div>
          <br>
          <div class="row">
            <div class="col-md-6">
              <button style="font-size:12px;padding: 5px 0px;" data-toggle="collapse" data-parent="#accordion" class="hidden-xs btn btn-info btn-block btn-lgs" href="#READREVIEWS">Read Reviews</button>
            </div>
            <div class="col-md-6">
              <button style="font-size:12px;padding: 5px 0px;" data-toggle="collapse" data-parent="#accordion" class="hidden-xs btn btn-warning btn-block btn-lgs" href="#ADDREVIEW">Add Review</button>
            </div>
          </div>
        </div>
      </div>
      <!--<div class="col-md-12">
        <ul class="list list-inline text-small go-text-right ">
                                </ul>
        </div>-->
    </div>
    <hr>
    <?php include 'includes/reviews.php';?>
  </div>
  <!--End container -->
</section>
<!--End container -->
<?php include 'includes/related.php';?>
<script>
  $(document).ready(function() {
      $('.maps').click(function () {
          $('.maps iframe').css("pointer-events", "auto");
      });

      $( ".maps" ).mouseleave(function() {
        $('.maps iframe').css("pointer-events", "none");
      });

      $(".dpd1").on("blur",function(){

       setTimeout(
          function(){
          var dt = $(".dpd1").val();

          var dd = dt.split("/");

        $("#d1first").html(dd[0]);
        $("#d1second").html(dd[1]);
        $("#d1third").html(dd[2]);
          }
          ,250);

      });

      $(".dpd2").on("blur",function(){
        setTimeout(
          function(){
          var dt = $(".dpd2").val();
          var dd = dt.split("/");
          $("#d2first").html(dd[0]);
          $("#d2second").html(dd[1]);
          $("#d2third").html(dd[2]);
          }
          ,250);


      });


   });

</script>
<style>
  .maps iframe{
  pointer-events: none;
  }
</style>
<!-- Comments Modal-->
<script type="text/javascript">
  $(function(){
    $('.reviewscore').change(function(){
  var sum = 0;
  var avg = 0;
  var id = $(this).attr("id");
  $('.reviewscore_'+id+' :selected').each(function() {
  sum += Number($(this).val());
  });
  avg = sum/5;
  $("#avgall_"+id).html(avg);
  $("#overall_"+id).val(avg);
  });

  //submit review
  $(".addreview").on("click",function(){
  var id = $(this).prop("id");
  $.post("<?php echo base_url();?>admin/ajaxcalls/postreview", $("#reviews-form-"+id).serialize(), function(resp){
    var response = $.parseJSON(resp);
   // alert(response.msg);
    $("#review_result"+id).html("<div class='alert "+response.divclass+"'>"+response.msg+"</div>").fadeIn("slow");
  });

  setTimeout(function(){

  $("#review_result"+id).fadeOut("slow");

  }, 3000);

  });

  })
</script>
<script type="text/javascript">
  $(function(){
  // Add/remove wishlist
  $(".wish").on('click',function(){
  var loggedin = $("#loggedin").val();
  var removelisttxt = $("#removetxt").val();
  var addlisttxt = $("#addtxt").val();
  var title = $("#itemid").val();
  var module = $("#module").val();
  if(loggedin > 0){ if($(this).hasClass('addwishlist')){
   var confirm1 = confirm("<?php echo trans('0437');?>");
   if(confirm1){
     $(".wish").removeClass('addwishlist btn-primary');
  $(".wish").addClass('removewishlist btn-warning');
  $(".wishtext").html(removelisttxt);
  $.post("<?php echo base_url();?>account/wishlist/add", { loggedin: loggedin, itemid: title,module: module }, function(theResponse){ });

   }
   return false;

  }else if($(this).hasClass('removewishlist')){
  var confirm2 = confirm("<?php echo trans('0436');?>");
  if(confirm2){
   $(".wish").addClass('addwishlist btn-primary'); $(".wish").removeClass('removewishlist btn-warning');
  $(".wishtext").html(addlisttxt);
  $.post("<?php echo base_url();?>account/wishlist/remove", { loggedin: loggedin, itemid: title,module: module }, function(theResponse){
  });
  }
  return false;

  } }else{ alert("<?php echo trans('0482');?>"); } });
  // End Add/remove wishlist
  })
  // End document ready
</script>