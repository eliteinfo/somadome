<?php
  //  $strUrlFile = pathinfo($_SERVER['REQUEST_URI'],PATHINFO_FILENAME).'.'.pathinfo($_SERVER['REQUEST_URI'],PATHINFO_EXTENSION);
    $url=pathinfo($_SERVER['REQUEST_URI'],PATHINFO_FILENAME);
?>
<div class="page-sidebar nav-collapse collapse">
    <!-- BEGIN SIDEBAR MENU -->        
    <ul class="page-sidebar-menu">
        <li>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
            <div class="sidebar-toggler hidden-phone"></div>
            <!-- BEGIN SIDEBAR TOGGLER BUTTON -->
        </li>
        <li>
            <!-- BEGIN RESPONSIVE QUICK SEARCH FORM -->
            <!--<form class="sidebar-search">
                <div class="input-box">
                    <a href="javascript:;" class="remove"></a>
                    <input type="text" placeholder="Search..." />
                    <input type="button" class="submit" value=" " />
                </div>
            </form>-->
            <!-- END RESPONSIVE QUICK SEARCH FORM -->
        </li>
        <li class="start <?php if($url=='dashboard'){?> active<?php }?>">
            <a href="dashboard.php">
                <i class="icon-home"></i> 
                <span class="title">Dashboard</span>
                <span class="selected"></span>
            </a>
        </li>
        <li class="<?php if(in_array($url,array('add_customers','list_customers'))){?> active<?php }?>" >
            <a href="javascript:;">
                <i class="icon-user"></i> 
                <span class="title">Hosts</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">            
        <li class="<?php if(in_array($url,array('add_customers'))){?>active<?php }?>"><a href="add_customers.php">Add host</a></li>
        <li class="<?php if(in_array($url,array('list_customers'))){?>active<?php }?>"><a href="list_customers.php">List hosts</a></li>
            </ul>
        </li>
		
		<li class="<?php if(in_array($url,array('add_units','list_units'))){?> active<?php }?>" >
            <a href="javascript:;">
                <i class="icon-user"></i> 
                <span class="title">Domes</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">            
        <li class="<?php if(in_array($url,array('add_units'))){?>active<?php }?>"><a href="add_units.php">Add dome</a></li>
        <li class="<?php if(in_array($url,array('list_units'))){?>active<?php }?>"><a href="list_units.php">List domes</a></li>
            </ul>
        </li>
		<li class="<?php if(in_array($url,array('add_users','list_users'))){?> active<?php }?>" >
            <a href="javascript:;">
                <i class="icon-user"></i> 
                <span class="title">Users</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
        <li class="<?php if(in_array($url,array('list_users'))){?>active<?php }?>"><a href="list_users.php">List users</a></li>
            </ul>
        </li>
        
         <li class="has-sub<?php if(in_array($url,array('list_upcomming','list_cancelled','list_complete'))){?> active<?php }?> ">
                    <a href="javascript:;">
                        <i class="icon-copy"></i> 
            <span class="title">Booking</span>
            <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
               <li class="<?php if(in_array($url,array('list_upcomming','list_upcomming'))){?>active<?php }?>">
                            <a href="list_upcomming.php">Upcomming</a>
                </li>
                 <li class="<?php if(in_array($url,array('list_cancelled','list_cancelled'))){?>active<?php }?>">
                            <a href="list_cancelled.php">Cancelled</a>
                </li>
                 <li class="<?php if(in_array($url,array('list_complete','list_complete'))){?>active<?php }?>">
                            <a href="list_complete.php">Complete</a>
                </li>
              </ul>
        </li>
        
		
		   <li class="has-sub<?php if(in_array($url,array('list_content','add_new_content','home_steps','home_content'))){?> active<?php }?> ">
                    <a href="javascript:;">
                        <i class="icon-copy"></i> 
            <span class="title">CMS</span>
            <span class="arrow "></span>
            </a>
            <ul class="sub-menu">
               <li class="<?php if(in_array($url,array('list_content','add_new_content'))){?>active<?php }?>">
                            <a href="list_content.php">Show All</a>
                </li>
              </ul>
        </li>
		  <li class="<?php if(in_array($url,array('social_links','manage_social_links'))){?> active<?php }?>" >
            <a href="social_links.php">
                <i class="icon-cogs"></i> 
                <span class="title">Social Link</span>
                <span class="arrow "></span>
            </a>
            <?php /*?><ul class="sub-menu">            
                <li class="<?php if(in_array($url,array('social_links'))){?>active<?php }?>"><a href="social_links.php">Social Link</a></li>
              
            </ul><?php */?>
        </li>
       
        
        
    </ul>
    <!-- END SIDEBAR MENU -->
</div>