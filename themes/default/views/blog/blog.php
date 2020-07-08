<style>
  .item { max-height: 55px !important; }
  .parallax-window { min-height: 220px; position: relative; }
</style>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h1 class="wow fadeInUp animated title go-right"><?php echo $title;?>
            <small style="color:#fff" class="price"><sup><?php echo $date;?></sup></small>
          </h1>
        </div>
      </div>
    </div>

<div class="container sections-wrapper">
  <div class="row">
    <div class="primary col-md-8 col-sm-12 col-xs-12">
      <div class="panel panel-default">
        <div class="panel-body">

        <img src="<?php echo $thumbnail;?>" class="img-responsive" />
          <div class="row">
            <!--//desc-->
            <div class="panel-body go-right RTL">
              <?php echo $desc; ?>
            </div>
            <!--//desc-->
          </div>
          <!--//item-->
        </div>
      </div>
      <?php if(!empty($related_posts)){ ?>
      <h3 class="go-right"><?php echo trans('0289');?></h3>
      <div class="clearfix"></div>
      <div class="row">
        <?php
          foreach($related_posts as $post):
           $bloglib->set_id($post->post_id);
           $bloglib->post_short_details(); ?>
        <div class="col-sm-4 col-md-3 col-sm-4 col-xs-12">
          <a href="<?php echo base_url().'blog/'.$post->post_slug;?>" class="thumbnail">
          <img src="<?php echo pt_post_thumbnail($post->post_id); ?>" style="height:100px" class="post-img img-fade" />
          <button style="padding-left:5px" class="btn btn-primary btn-block btn-xs"><?php echo character_limiter(strip_tags($bloglib->title), 20);?></button>
          </a>
        </div>
        <?php endforeach; ?>
      </div>
      <?php  } ?>
    </div>
    <?php include('sidebar.php'); ?>
  </div>
  <!--//row-->
</div>
<!--//masonry-->

<br><br><br>