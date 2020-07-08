<!DOCTYPE html>
<?php $CI = &get_instance(); $ishome = $CI->uri->segment(1); $currenturl = uri_string(); $app_settings = $CI->settings_model->get_settings_data(); $allowreg = $app_settings[0]->allow_registration; $allowsupplierreg = $app_settings[0]->allow_supplier_registration; if(!empty($metadesc)){ $metadescription = $metadesc; }else{ if( empty($ishome)){ $metadescription = $app_settings[0]->meta_description; } } if(!empty($metakey)){ $metakeywords = $metakey; }else{ if(empty($ishome)){ $metakeywords =  $app_settings[0]->keywords; } } $lang_set = $CI->theme->_data['lang_set']; $langname = $CI->session->userdata('lang_name'); $isRTL = isRTL($lang_set); if(empty($langname)){ $langname = languageName($lang_set); }else{ $langname = $langname; } ?>
<html ng-app="phptravelsApp">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="<?php echo @$metadescription; ?>">
    <meta name="keywords" content="<?php echo @$metakeywords; ?>">
    <meta name="author" content="PHPTRAVELS">
    <title><?php if(empty($ishome)){ echo $app_settings[0]->home_title; }else{ echo $CI->theme->_data['page_title']; } ?></title>
    <link rel="shortcut icon" href="<?php echo PT_GLOBAL_IMAGES_FOLDER.'favicon.png';?>">
    <link href="<?php echo $theme_url; ?>assets/css/bootstrap.css" rel="stylesheet" media="screen">
    <link href="<?php echo $theme_url; ?>assets/css/custom.css" rel="stylesheet" media="screen">
    <!-- facebook --------->
    <meta property="og:title" content="<?php $ishome = $CI->uri->segment(1); if(empty($ishome)){ echo $app_settings[0]->home_title; }else{ echo $CI->theme->_data['page_title']; } ?>"/>
    <meta property="og:site_name" content="<?php echo $app_settings[0]->site_title;?>"/>
    <meta property="og:description" content="<?php if($app_settings[0]->seo_status == "1"){echo $metadescription;}?>"/>
    <meta property="og:image" content="<?php echo base_url(); ?>uploads/global/favicon.png"/>
    <meta property="og:url" content="<?php echo $app_settings[0]->site_url;?>/"/>
    <meta property="og:publisher" content="https://www.facebook.com/<?php echo $app_settings[0]->site_title;?>"/>
    <script type="application/ld+json">{"@context":"http://schema.org/","@type":"Organization","name":"<?php echo $app_settings[0]->site_title;?>","url":"<?php echo $app_settings[0]->site_url;?>/","logo":"<?php echo base_url(); ?>uploads/global/favicon.png","sameAs":"https://www.facebook.com/<?php echo $app_settings[0]->site_title;?>","sameAs":"https://twitter.com/<?php echo $app_settings[0]->site_title;?>","sameAs":"https://www.pinterest.com/<?php echo $app_settings[0]->site_title;?>/","sameAs":"https://plus.google.com/u/0/<?php echo $app_settings[0]->site_title;?>/posts","contactPoint":{"@type":"ContactPoint","telephone":"<?php echo $phone; ?>","contactType":"Customer Service"}}{"@context":"http://schema.org","@type":"WebSite","name":"<?php echo $app_settings[0]->site_title;?>","url":"<?php echo $app_settings[0]->site_url;?>"}  </script>
    <!--[if lt IE 9]>        <script src="<?php echo $theme_url; ?>assets/js/html5shiv.js"></script> <script src="<?php echo $theme_url; ?>assets/js/respond.min.js"></script><![endif]-->
    <!-- BASE CSS --------->
    <link href="<?php echo $theme_url; ?>style.css" rel="stylesheet">
    <style> @import "<?php echo $theme_url; ?>childtheme/childstyle.css"; </style>
    <!-- Google Maps ------> <script type="text/javascript" src="//maps.googleapis.com/maps/api/js?key=<?php echo $app_settings[0]->mapApi; ?>&libraries=places"></script>
    <!-- jQuery -----------> <script src="<?php echo $theme_url; ?>assets/js/jquery-1.11.2.min.js"></script> <script src="<?php echo $theme_url; ?>assets/js/wow.min.js"></script>
    <!-- RTL CSS ----------> <?php if($isRTL == "RTL"){ ?>
    <link href="<?php echo $theme_url; ?>RTL.css" rel="stylesheet">
    <?php } ?>
    <!-- Mobile Redirect --> <?php if($app_settings[0]->mobile_redirect_status == "Yes"){ if($ishome != "invoice"){ ?> <script>if(/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)){ window.location ="<?php echo $app_settings[0]->mobile_redirect_url ?>";}</script> <?php } } ?>
    <!--[if lt IE 7]>
    <link rel="stylesheet" type="text/css" href="<?php echo $theme_url; ?>assets/css/font-awesome-ie7.css" media="screen" />
    <![endif]-->
    <link rel="stylesheet" href="<?php echo $theme_url; ?>assets/css/jquery-ui.css" />
  </head>
  <body id="top">
    <div class="header-top col-md-12">
      <div class="container">
        <div class="row">
          <div class="col-md-6 col-sm-8 col-xs-12 hidden-xs go-right">
            <div class="pull-left header-phone go-right">
              <?php if(!empty($phone)){ ?><i class="icon_set_1_icon-55"></i> <?php echo $phone; ?><?php } ?>
            </div>
            <div class="header-brdr pull-left hidden-xs go-right"></div>
            <div class="pull-left header-email go-right">
              <a class="ftitle" href="mailto:<?php echo $contactemail; ?>" id="email_footer">
                <div class="text-center"><i class="icon_set_1_icon-95 go-right"></i> <span ><?php echo $contactemail; ?></span></div>
              </a>
            </div>
          </div>
          <div class="col-md-6 col-sm-4 col-xs-12 header-right go-right">
            <div style="position:relative; " class="pull-right header-lang go-left">
              <?php if (strpos($currenturl,'book') !== false || !empty($hideLang)) { }else{
                if($app_settings[0]->multi_lang == '1') { $default_lang = $app_settings[0]->default_lang; if(!empty($lang_set)){ $default_lang = $lang_set; } ?>
              <a style="border-bottom: 0px; padding: 10px; display: inline-block; margin: -5px 0 0;color:#fff" href="javascript: void();" class="dropdown-toggle" data-toggle="dropdown"><img src="<?php echo PT_LANGUAGE_IMAGES.$default_lang.".png";?>" width="21" height="14" alt="<?php echo $langname;?>"> <?php echo $langname;?> </a>
              <ul class="dropdown-menu">
                <?php $language_list = pt_get_languages();?>
                <?php foreach($language_list as $ldir => $lname){ $selectedlang = '';
                  if(!empty($lang_set) && $lang_set == $ldir){
                  $selectedlang = 'selected';
                  }elseif(empty($lang_set) && $default_lang == $ldir){ $selectedlang = 'selected'; } ?>
                <li><a href="<?php echo pt_set_langurl($langurl,$ldir);?>" data-langname="<?php echo $lname['name'];?>" id="<?php echo $ldir; ?>" class="changelang" ><img src="<?php echo PT_LANGUAGE_IMAGES.$ldir.".png";?>" width="21" height="14" alt="">  <?php echo $lname['name'];?></a></li>
                <?php } ?>
              </ul>
              <?php } ?>
              <?php  } ?>
            </div>
            <div class="header-brdr pull-right hidden-xs hidden-md go-left"></div>
            <?php if(strpos($currenturl,'book') == false && $app_settings[0]->multi_curr == 1 && empty($hideCurr)){ $currencies = ptCurrencies(); ?>
            <form class="dropdown pull-right header-currency ng-pristine ng-valid go-left">
              <div class="styled-select">
                <select onchange="change_currency(this.value)" class="selectz" style="font-weight: 100;height: 2.3em;" name="currency" id="currency">
                  <?php foreach($currencies as $c){ ?>
                  <option value="<?php echo $c->id;?>" <?php makeSelected($currency,$c->code); ?>><?php echo $c->name;?></option>
                  <?php } ?>
                </select>
              </div>
              <div class="clearfix"></div>
            </form>
            <?php } ?>
          </div>
        </div>
      </div>
    </div>
    <div class="clearfix"></div>
    <!-- Top wrapper -->
    <div class="navbar navbar-static-top navbar-default <?php echo @$hidden; ?>">
      <div class="container">
        <div class="navbar">
          <!-- Navigation-->
          <div class="navbar-header go-right">
            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a href="<?php echo base_url(); ?>" class="navbar-brand"><img src="<?php echo PT_GLOBAL_IMAGES_FOLDER.$app_settings[0]->header_logo_img;?>" alt="<?php echo $app_settings[0]->site_title;?>" class="logo"/></a>
          </div>
          <div class="navbar-collapse collapse">




            <ul class="nav navbar-nav navbar-right go-left">
              <li class="dropdown <?php pt_active_link();?> go-right">
                <a class="dropdown-toggle" href="<?php echo base_url(); ?>"> <?php echo trans('01');?> </a>
              </li>
              <?php  $hmenu = get_header_menu();
                if(!empty($hmenu)){
                $menuitems = json_decode($hmenu[0]->menu_items);
                if(!empty($menuitems)){
                $icons = TRUE;
                foreach($menuitems as $hm){
                $pinfo =  get_page_details($hm->id);
                foreach($pinfo as $pagesinfo){
                $parent = parent_info($pagesinfo,$icons,$lang_set);
                $ischildactive = child_page_active($hm->children);
                if(!empty($hm->children) && $ischildactive){
                $dropdownmenu = "dropdown-menu";
                $dropdown = "dropdown";
                $dropdowntoggle = "dropdown-toggle";
                $datatoggle = "data-toggle='dropdown'";
                $caret = "<span class='caret'></span>";
                }else{
                 $dropdownmenu = "";
                $dropdown = "";
                $dropdowntoggle = "";
                $datatoggle = "";
                $caret = "";
                }
                ?>
              <li class="go-right <?php echo $dropdown." ".pt_active_link($pagesinfo->page_slug);?>">
                <a href="<?php echo $parent['hreflink'];?>" class="<?php pt_active_link($pagesinfo->page_slug).' '.$dropdowntoggle;?>" <?php echo $datatoggle;?>  target="<?php echo $parent['target'];?>" >
                  <!--<i class='<?php  echo $parent['icons'];?>'></i>--> <?php echo  $parent['pagetitle'];?>  <?php echo $caret;?>
                </a>
                <?php if(!empty($hm->children)){  ?>
                <ul class="<?php echo $dropdownmenu;?>">
                  <?php foreach($hm->children as $ch){
                    $children =  get_page_details($ch->id);
                    foreach($children as $childinfo){
                    $child = child_info($childinfo,$icons,$lang_set);
                    ?>
                  <li>
                    <a href="<?php  echo $child['hrefchild'];?>" target="<?php echo $child['childtarget'];?>" ><i class='<?php echo $child['icons'];?>'></i> <?php echo $child['childtitle'];?> </a>
                  </li>
                  <?php } } ?>
                </ul>
                <?php } ?>
              </li>
              <?php } } } } ?>
              <?php  if(!empty($customerloggedin)){ ?>
              <li class="pull-right">
                <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle"><?php echo $firstname; ?> <b class="lightcaret mt-2"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url()?>account/">  <?php echo trans('02');?></a></li>
                  <li><a href="<?php echo base_url()?>account/logout/">  <?php echo trans('03');?></a></li>
                </ul>
              </li>
              <?php }else{ if (strpos($currenturl,'book') !== false) { }else{ if($allowreg == "1"){ ?>
                <li class="pull-right">
                <a href="javascript:void(0);" data-toggle="dropdown" class="dropdown-toggle"><?php echo trans('0146');?> <b class="lightcaret mt-2"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php echo base_url(); ?>login">  <?php echo trans('04');?></a></li>
                  <li><a href="<?php echo base_url(); ?>register">  <?php echo trans('0115');?></a></li>
                </ul>
              </li>
              <?php } } } ?>
            </ul>
          </div>
        </div>
      </div>
    </div>
    <div class="hidden-xs">
      <div style="margin-top:10px"></div>
    </div>
    <div class="visible-xs">
      <div style="margin-top:10px"></div>
    </div>
    <div class="mtslide2 sliderbg2"></div>