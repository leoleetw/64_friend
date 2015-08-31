<div id="sidebar-wrapper">
	<div id="big_nav" class="sidebar-nav">
	    <a href="index.php"><img src="include/images/home.png" height="29" width="32"></a>
	    <? if($_SESSION["user_id"]==""){ ?>
	    <div class="sidebar-login">
	    	<form id="from_account" action="ajax/log_in.php" method="post">
	    		<input type="text" id="login_acc" name="login_acc" value="" class="form-control" style="width:70%;float:left" placeholder="帐号"/>
	    		<input type="password" id="login_pwd" name="login_pwd" value="" class="form-control" style="width:70%;float:left" placeholder="密码"/>
	    		<input type="hidden" id="action" name="action" value="log_in">
				<input type="submit" id="submit_login" name="submit_login" value="登入" class="btn">
			</form>
	    </div>
	  	<? }else{ ?>
  		<a href="user_data.php"><img src="<? echo $_SESSION["user_photo"]; ?>"></a>
  		<div><? echo $_SESSION["user_nick"]; ?></div>
  		<form id="from_log_out" action="ajax/log_in.php" method="post">
  			<input type="hidden" id="action" name="action" value="log_out">
  			<input type="submit" id="logout_btn" name="logout_btn" value="登出" class="btn" style="float:right">
  		</form>
	  	<? } ?>
	    <a href="search.php">所有会员</a>
	    <a href="favorite.php">我的收藏</a>
	    <a href="#">活动讯息</a>
	    <a href="about.php">关於我们</a>
	    <a href="#">联络我们</a>
	</div>
</div>

<script>
	function change_nav(){
		setTimeout(function () {
      if(Dd("small_nav").style.display=="none"){
				none("big_nav");
				block("small_nav");
			}
			else{
				none("small_nav");
				block("big_nav");
			}
    }, 400);

	}
	<? if($_SESSION["user_id"]==""){ ?>
	Dd("from_account").onsubmit = function (){
		if(Dd("login_acc").value==""||Dd("login_pwd").value==""){
			alert("帐号资讯不得为空!");
			return false;
		}
		else if(<? if($_SESSION["login_error_count"]!=""){echo $_SESSION["login_error_count"];}else{echo "XXX";} ?>==5){
			<? $error_time = strtotime(date("Y-m-d h:i:s"))-strtotime($_SESSION["login_error_time"]);  ?>
			if(<? echo $error_time;?> < 900){
				alert("帐号错误次数达5次，将暂时无法登入网站!剩余时间为:<? echo ($error_time-900);?>秒");
				return false;
			}
		}
		else{
			return true;
		}
	}
	<? }else{ ?>
		Dd("from_log_out").onsubmit = function (){
			return true;
		}
	<? } ?>
</script>
