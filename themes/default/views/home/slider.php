<!-- WRAP -->
<div class="wrap ctup">
<div class="slideup">
  <div class="z-index100" style="background-color:#000000">
    <div class="col-md-12 scolright go-left visible-lg visible-md">
      <div class="row">
        <div id="Carousel" class="carousel slide carousel-fade">
          <div class="carousel-inner fadeIn animated">
            <?php $mulcur = ""; $mainslides = pt_get_main_slides(); $scount = 0; foreach($mainslides as $ms){ $sliderlib->set_id($ms->slide_id); $sliderlib->slide_details(); $scount++; $sactive = ""; if($scount == 1){ $sactive = "active"; }else{ $sactive = ""; } ?>
            <div class="item <?php echo $sactive; ?>">
              <div style="background-color:#000" class="slider">
                <img style="width:100%" src="<?php echo PT_SLIDER_IMAGES.$ms->slide_image;?>">
              </div>
              <div class="clearfix"></div>
              <div class="container">
                <div class="carousel-caption pull-right">
                  <h5 data-wow-duration="1s" data-wow-delay="0.1s" style="font-size:30px;font-family: "OpenSansLight", sans-serif;" class="pull-right fadeInUp wow text-left go-left"><?php echo $sliderlib->title;?></h5>
                  <div class="clearfix"></div>
                  <p data-wow-duration="2s" data-wow-delay="0.1s" style="font-size:30px;" class="flash wow text-left  go-left"><strong class="pull-right"><?php echo $sliderlib->desc;?></strong></p>
                  <div class="clearfix"></div>
                  <i data-wow-duration="1s" data-wow-delay="0.2s" style="font-size:26px;color:yellow;margin-top:10px" class="slim uppercase fadeInDown wow pull-right go-left" style="font-size:26px;color:yellow;margin-top:10px; font-weight: bold"><?php echo $sliderlib->optionalText;?></i>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div>
            <?php } ?>
          </div>
          <a class="left carousel-control" href="#Carousel" data-slide="prev">
          <span class="glyphicon-chevron-left fa fa-angle-left"></span>
          </a>
          <a class="right carousel-control" href="#Carousel" data-slide="next">
          <span class="glyphicon-chevron-right fa fa-angle-right"></span>
          </a>
        </div>
      </div>
    </div>
    <div  style="position:absolute;width:100%;z-index: 100;">
      <div class="hidden-sm hidden-xs">
        <div style="margin-top: 90px;"></div>
      </div>
      <div class="container">
        <div class="col-md-6 col-xs-12 go-right RTL_Bar" style="padding-right:0px;padding-left:0px;margin-top:25px">
          <div class="row">
            <ul style="max-width:570px;" class="nav nav-tabs nav-justified RTL pdr0">
              <?php  if(pt_main_module_available('hotels')){ ?>
              <li role="presentation" class="active text-center" data-title="HOTELS"> <a class="text-left" href="#HOTELS" data-toggle="tab" aria-controls="home" aria-expanded="true"><span class="hotel"></span> <?php echo trans('Hotels');?></a></li>
              <?php } ?>
              <?php  if(pt_main_module_available('ean')){ ?>
              <li role="presentation" class="text-center"  data-title="EXPEDIA"> <a href="#EXPEDIA" data-toggle="tab" aria-controls="home" aria-expanded="true"><span class="hotel"></span> <?php echo trans('Ean');?></a></li>
              <?php } ?>
              <?php  if(pt_main_module_available('flightsdohop')){ ?>
              <li role="presentation" class="text-center"  data-title="DOHOP"> <a href="#DOHOP" data-toggle="tab" aria-controls="home" aria-expanded="true"><span class="flight"></span> <?php echo trans('Flightsdohop');?></a></li>
              <?php } ?>
              <?php  if(pt_main_module_available('tours')){ ?>
              <li role="presentation" class="text-center" data-title="TOURS"> <a href="#TOURS" data-toggle="tab" aria-controls="home" aria-expanded="true"><span class="suitcase"></span> <?php echo trans('Tours');?></a></li>
              <?php } ?>
              <?php  if(pt_main_module_available('cars')){ ?>
              <li role="presentation" class="text-center" data-title="CARS"> <a href="#CARS" data-toggle="tab" aria-controls="home" aria-expanded="true"><span class="car"></span> <?php echo trans('Cars');?></a></li>
              <?php } ?>
              <?php  if(pt_main_module_available('cartrawler')){ ?>
              <li role="presentation" class="text-center" data-title="CARTRAWLER"> <a href="#CARTRAWLER" data-toggle="tab" aria-controls="home" aria-expanded="true"><span class="car"></span> <?php echo trans('Cars');?></a></li>
              <?php } ?>
            </ul>
          </div>
          <div class="clearfix"></div>
          <div style="max-width:570px;" class="tab-content row">


            <!-- Hotels  -->
            <div role="tabpanel" class="tab-pane fade active in <?php pt_searchbox('hotels'); ?>" id="HOTELS" aria-labelledby="home-tab">
              <?php echo searchForm('hotels'); ?>
            </div>
            <!-- Hotels  -->
            <!-- Expedia Hotels  -->
            <div  role="tabpanel" class="tab-pane fade <?php pt_searchbox('ean'); ?>" id="EXPEDIA" aria-labelledby="home-tab">
            <?php echo searchForm('ean'); ?>
            </div>
            <!-- Expedia Hotels  -->
            <!-- Dohop Flights  -->
            <div  role="tabpanel" class="tab-pane fade <?php pt_searchbox('Flightsdohop'); ?>" id="DOHOP" aria-labelledby="home-tab">
              <?php echo searchForm('flightsdohop'); ?>
            </div>
            <!-- Dohop Flights  -->
            <!-- Tours  -->
            <div  role="tabpanel" class="tab-pane fade <?php pt_searchbox('tours'); ?>" id="TOURS" aria-labelledby="home-tab">
            <?php echo searchForm('tours'); ?>
            </div>
            <!-- Tours  -->
            <!-- Cars  -->
            <div  role="tabpanel" class="tab-pane fade <?php pt_searchbox('cars'); ?>" id="CARS" aria-labelledby="home-tab">
              <?php echo searchForm('cars'); ?>
            </div>
            <!-- Cars  -->
            <!-- Cartrawler  -->
            <div  role="tabpanel" class="tab-pane fade <?php pt_searchbox('cartrawler'); ?>" id="CARTRAWLER" aria-labelledby="home-tab">
               <?php echo searchForm('cartrawler'); ?>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function() {
                  $('.carousel').carousel({
                                  interval: 95000
                  })
  });
</script>