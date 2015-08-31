<?
	include_once('config.php');
?>
<!--span class="navbar-header"><a class="navbar-brand" href="index.php"></a></span-->
<!-- Navigation -->
<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

    <div class="navbar-header">
    </div>
    <ul class="nav navbar-top-links navbar-right">
        <li>
						<a href="index.php"><i class="fa fa-home fa-fw"></i> 首頁</a>
        </li>

        <!--li class="dropdown">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="viewuser.php"><i class="fa fa-user fa-fw"></i>個人資料</a>
                </li>
                <li><a href="#" onclick="$('#pwd_model').modal('show');"><i class="fa fa-gear fa-fw"></i> 修改密碼</a>
                </li>
                <li class="divider"></li>
                <li><a href="#" onclick="logout();"><i class="fa fa-sign-out fa-fw"></i> 登出</a>
                </li>
            </ul>
        </li-->
    </ul>
      <div align="center">
				  <table width='100%'>
						<tr>
							<td width='10%'>
							</td>
						</tr>
					</table>
			</div>
		<div class="navbar-default sidebar" role="navigation">
      <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">
          <li>
						<?php if($_SERVER['PHP_SELF']==_page."index.php"){ ?>
							<a class="active" href="index.php"><i class="fa fa-dashboard fa-fw"></i> 首頁</a>
						<?php }
						else{ ?>
							<a href="index.php"><i class="fa fa-home fa-fw"></i> 回首頁</a>
						<?php } ?>
          </li>
          <li>
						<?php if($_SERVER['PHP_SELF']==_page."code_input.php"){ ?>
							<a class="active" href="code_input.php"><i class="fa fa-dashboard fa-fw"></i> code_input</a>
						<?php }
						else{ ?>
							<a href="code_input.php"><i class="fa fa-home fa-fw"></i> code_input</a>
						<?php } ?>
          </li>
          <li>
						<?php if($_SERVER['PHP_SELF']==_page."member_check.php"){ ?>
							<a class="active" href="member_check.php"><i class="fa fa-dashboard fa-fw"></i> 會員審核</a>
						<?php }
						else{ ?>
							<a href="member_check.php"><i class="fa fa-home fa-fw"></i> 會員審核</a>
						<?php } ?>
          </li>

          
          <?php if($_SERVER['PHP_SELF']==_page."search_member.php"||$_SERVER['PHP_SELF']==_page."search_wall.php"||$_SERVER['PHP_SELF']==_page."search_report.php"||$_SERVER['PHP_SELF']==_page."search_album.php"){ ?>
            <li class="active">
          <?php }else{ ?>
          	<li>
          <?php } ?>
	            <a href="#"><i class="fa fa-search fa-fw"></i> 會員管理<span class="fa arrow"></span></a>
	            <ul class="nav nav-second-level">
	            	<?php 
	            		if($_SERVER['PHP_SELF']==_page."search_member.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="search_member.php"><i class="fa fa-users fa-fw"></i>查詢會員</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="search_member.php"><i class="fa fa-users fa-fw"></i>查詢會員</a>
	                </li>
	               <?php } ?>
	               
	               <?php 
	            		if($_SERVER['PHP_SELF']==_page."search_wall.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="search_wall.php"><i class="fa fa-users fa-fw"></i>查詢塗鴉牆</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="search_wall.php"><i class="fa fa-users fa-fw"></i>查詢塗鴉牆</a>
	                </li>
	               <?php } ?>
	               
	               <?php 
	            		if($_SERVER['PHP_SELF']==_page."search_report.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="search_report.php"><i class="fa fa-users fa-fw"></i>查看檢舉</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="search_report.php"><i class="fa fa-users fa-fw"></i>查看檢舉</a>
	                </li>
	               <?php } ?>
	               
	               <?php 
	            		if($_SERVER['PHP_SELF']==_page."search_album.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="search_album.php"><i class="fa fa-users fa-fw"></i>查看相簿</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="search_album.php"><i class="fa fa-users fa-fw"></i>查看相簿</a>
	                </li>
	               <?php } ?>
	               
	            </ul>
            </li>
            
            <?php if($_SERVER['PHP_SELF']==_page."edit_about.php"){ ?>
            <li class="active">
          <?php }else{ ?>
          	<li>
          <?php } ?>
	            <a href="#"><i class="fa fa-search fa-fw"></i> 文章編輯<span class="fa arrow"></span></a>
	            <ul class="nav nav-second-level">
	            	<?php 
	            		if($_SERVER['PHP_SELF']==_page."edit_about.php"){ 
	            	?>
	                <li>
	                    <a class="active" href="edit_about.php"><i class="fa fa-users fa-fw"></i>關於我們</a>
	                </li>
	              <?php }
	              			else{ ?>
	              	<li>
	                    <a href="edit_about.php"><i class="fa fa-users fa-fw"></i>關於我們</a>
	                </li>
	               <?php } ?>
	            </ul>
	          </li>
        </ul>
      </div>
      
    </div>
</nav>