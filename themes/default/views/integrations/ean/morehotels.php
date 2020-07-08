<div class="clearfix"></div>
<input type="hidden" name="moreResultsAvailable" id="moreResultsAvailable" value="<?php echo $moreResultsAvailable; ?>" />
<input type="hidden" name="cacheKey" id="cacheKey" value="<?php echo $cacheKey; ?>" />
<input type="hidden" name="cacheLocation" id="cacheLocation" value="<?php echo $cacheLocation; ?>" />
<input type="hidden" name="" id="agesappendurl" value="<?php echo $agesApendUrl; ?>" />
###
<div class="row" style="margin-left:0px;margin-right:0px">
  <?php
    if(!empty($module)){
    foreach($module as $item){
    ?>
  <div class="offset-2">
        <div class="wow fadeInUp col-lg-4 col-md-4 col-sm-4 offset-0 go-right">
          <div class="img_list">
            <a href="<?php echo $item->slug;?>">
              <img src="<?php echo $item->thumbnail;?>" alt="<?php echo character_limiter($item->title,20);?>">
              <div class="short_info"></div>
            </a>
          </div>
        </div>
        <div class="wow fadeInUp col-md-8 offset-0">
          <div class="itemlabel3">
            <div class="labelright go-left" style="min-width:105px;margin-left:5px">
              <br/>
              <span class="green size18">
              <?php  if($item->price > 0){ ?>
              <b>
              <small><?php echo $item->currCode;?></small> <?php echo $item->currSymbol; ?><?php echo $item->price;?>
              </b></span>
              <div class="clearfix"></div>
              <hr>
              <?php } ?>
              <?php if($appModule == "ean"){ if($item->tripAdvisorRating > 0){ ?>
              <div class="review text-center size18"><i class="icon-thumbs-up-4"></i><?php echo $item->tripAdvisorRating;?> </div>
              <div class="clearfix"></div>
              <hr>
              <?php } } ?>
              <a href="<?php echo $item->slug;?>">
              <button type="submit" class="btn btn-action"><?php echo trans('0177');?></button>
              </a>
            </div>
            <div class="labelleft2 rtl_title_home">
              <h4 class="mtb0 RTL go-text-right">
                <a href="<?php echo $item->slug;?>"><b><?php echo character_limiter($item->title,20);?></b></a>
                <!-- Cars airport pickup -->  <?php if($appModule == "cars"){ if($item->airportPickup == "yes"){ ?> <button class="btn btn-success btn-xs"><i class="icon-paper-plane-2"></i> <?php echo trans('0207');?></button> <?php } } ?> <!-- Cars airport pickup -->
              </h4>
              <a class="go-right" href="javascript:void(0);" onclick="showMap('<?php echo base_url();?>home/maps/<?php echo $item->latitude; ?>/<?php echo $item->longitude; ?>/<?php echo $appModule; ?>/<?php echo $item->id;?>','modal');" title="<?php echo $item->location;?>"><i style="margin-left: -3px;" class="icon-location-6 go-right"></i><?php echo character_limiter($item->location,10);?></a> <span class="go-right"><?php echo $item->stars;?></span>
              <br><br>
              <p class="grey RTL"><?php echo character_limiter($item->desc,200);?></p>
              <br/>
            </div>
          </div>
        </div>
    </div>
  </div>
  <div class="clearfix"></div>
  <div class="offset-2">
    <hr style="margin-top: 10px; margin-bottom: 10px;">
  </div>
  <?php } } ?>
</div>