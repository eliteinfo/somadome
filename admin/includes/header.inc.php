<div class="navbar-inner">
    <div class="container-fluid">
        <!-- BEGIN LOGO -->
        <a class="brand" href="dashboard.php">
<!--<img src="images/logo2.png" style="margin-top:-13px;" width="80"  />-->
        <b style="font-size:18px; color:#fff"><?php echo $_SESSION['Somadome_site']; ?></b>
        </a>
        <!-- END LOGO -->
        <!-- BEGIN RESPONSIVE MENU TOGGLER -->
        <a href="javascript:;" class="btn-navbar collapsed" data-toggle="collapse" data-target=".nav-collapse">
        <img src="assets/img/menu-toggler.png" alt="" />
        </a>          
        <ul class="nav pull-right">
            
            <?php if($_SESSION['admin_id']!='') { ?>
					<li class="dropdown user">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						Setting
						<i class="icon-angle-down"></i>
						</a>
						<ul class="dropdown-menu">
							<li><a href="profile.php"><i class="icon-bookmark-empty" style="margin-right:5px;"></i>Profile</a></li>
							<li><a href="logout.php"><i class="icon-key"></i>&nbsp;&nbsp;Log Out</a></li>
						</ul>
					</li><?php } ?>
        </ul>
    </div>
</div>