<?
	include_once("include/dbinclude.php");
	$sql = "select a.* , b.* from user a, member b where a.uid = b.uid AND a.uid='".$_SESSION["user_id"]."';";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
?>
<div class="edit_nav">
	<a href="user_edit.php">修改资料</a>
	<a href="favorite.php">我的收藏</a>
	<a href="user_album.php">我的相簿</a>
	<a href="#">积分兑换</a>
	<a href="shop.php">购买礼物/储值</a>
</div>
<div class="edit_account">
	<table>
		<tr>
			<td>密码</td>
			<td><input type="text" id="pwd" name="pwd" value=""></td>
		</tr>
		<tr>
			<td>确认密码</td>
			<td><input type="text" id="pwd_ck" name="pwd_ck" value=""></td>
		</tr>
		<tr>
			<td>真实姓名</td>
			<td><input type="text" id="name" name="name" value="<? echo $row["name"]; ?>"></td>
		</tr>
		<!--tr>
			<td>手机</td>
			<td><input type='text' id=""></td>
		</tr-->
		<tr>
			<td>E-mail</td>
			<td><font class="font_small">若更改系统将再次寄出认证信</font><input type="button" id="" name="" value="修改"></td>
		</tr>
	</table>
	<a href="realName.php">实名认证</a>
	<a href="#">修改密码</a>
</div>
<div class="edit_personal edit_innerStyle">
	<form id="form_member" action="ajax/user_data.php" method="post">
		<table width="100%">
				<tr>
					<td class="edit_item">
						<input type='hidden' id='action' name='action' value="member_data">
						昵称︰
					</td>
					<td>
						<input type="text" id="nick" name="nick" value="<? echo $row["nick"]; ?>"><font class="font_small">16个字</font>
					</td>
				</tr>
				<tr>
					<td>
						性别︰
					</td>
					<td>
						<input type="radio" id="sex0" name="sex" value="0" <? if($row["sex"]=="0"){echo "checked";} ?>> 男
						<input type="radio" id="sex1" name="sex" value="1" <? if($row["sex"]=="1"){echo "checked";} ?>> 女
					</td>
				</tr>
				<tr>
					<td>
						所在地︰
					</td>
					<td>
						<select id="city_cate" name="city_cate">
							<option value="">请选择</option>
							<?
								$city_cate_value = "";
								$sql = "select * from code where type='city';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($row_option['id']==$row["city_cate"]){
										echo "selected";
										$city_cate_value = $row_option['value'];
									}
									echo " > ".$row_option["name"]."</option>";
								}
							?>
						</select>
						<select id="city_code" name="city_code">
							<option value="">请选择</option>
							<?
									$sql = "select * from code where type='city".$city_cate_value."';";
									$result = mysqli_query($sqli,$sql);
									while($row_option = mysqli_fetch_array($result)){
										echo "<option value='".$row_option["id"]."' ";
										if($row_option['id']==$row["city_code"]){
											echo "selected";
										}
										echo " > ".$row_option["name"]."</option>";
									}
							?>
						</select>
					</td>
				</tr>
				<!--tr>
					<td>
						生日︰
					</td>
					<td>
						<select id="birth_day_y" name="birth_day_y">
							<option value="">请选择</option>
							<? /*
								$birthday = Array();
								$birthday = explode('-',$row["birth_day"]);
								for($i=1900 ; $i <= intval(date("Y"));++$i){
									echo "<option value='".$i."' ";
									if($row["birth_day"]!=""){
										if(intval($birthday[0])==$i)
											echo "selected";
									}
									echo "> ".$i." </option>";
								}*/
							?>
						</select>年
						<select id="birth_day_m" name="birth_day_m">
							<option value="">请选择</option>
							<? /*
								for($i=1 ; $i <= 12;++$i){
									if($i < 10){
										echo "<option value='0".$i."' ";
										if($row["birth_day"]!=""){
											if(intval($birthday[1])==$i)
												echo "selected";
										}
										echo "> 0".$i." </option>";
									}
									else{
										echo "<option value='".$i."' ";
										if($row["birth_day"]!=""){
											if(intval($birthday[1])==$i)
												echo "selected";
										}
										echo "> ".$i." </option>";
									}
								}*/
							?>
						</select>月
						<select id="birth_day_d" name="birth_day_d">
							<option value="">请选择</option>
							<? /*
								for($i=1 ; $i <= 31;++$i){
									if($i < 10){
										echo "<option value='0".$i."' ";
										if($row["birth_day"]!=""){
											if(intval($birthday[2])==$i)
												echo "selected";
										}
										echo "> 0".$i." </option>";
									}
									else{
										echo "<option value='".$i."' ";
										if($row["birth_day"]!=""){
											if(intval($birthday[2])==$i)
												echo "selected";
										}
										echo "> ".$i." </option>";
									}
								}*/
							?>
						</select>日
					</td>
				</tr-->
				<tr>
					<td>
						血型︰
					</td>
					<td>
						<select id="blood_type" name="blood_type">
							<option value="">请选择</option>
							<option value="X"<? if($row["blood_type"]=="X"){ echo "selected";}?>>不清楚</option>
							<option value="A"<? if($row["blood_type"]=="A"){ echo "selected";}?>>A</option>
							<option value="B"<? if($row["blood_type"]=="B"){ echo "selected";}?>>B</option>
							<option value="O"<? if($row["blood_type"]=="O"){ echo "selected";}?>>O</option>
							<option value="AB"<? if($row["blood_type"]=="AB"){ echo "selected";}?>>AB</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						身高︰
					</td>
					<td>
						<select id="height" name="height">
							<option value="">请选择</option>
							<?
								for($i=120 ; $i <= 220;++$i){
									echo "<option value='".$i."' ";
									if($row["height"]!=""){
										if($row["height"]==$i)
											echo "selected";
									}
									echo "> ".$i."cm </option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						体重︰
					</td>
					<td>
						<select id="weight" name="weight">
							<option value="">请选择</option>
							<?
								for($i=30 ; $i <= 150;++$i){
									echo "<option value='".$i."' ";
									if($row["weight"]!=""){
										if($row["weight"]==$i)
											echo "selected";
									}
									echo "> ".$i."kg </option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						学历︰
					</td>
					<td>
						<select id="edu_bg" name="edu_bg">
							<option value="">请选择</option>
							<?
								$sql = "select * from code where type='edu_bg';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($row_option['id']==$row["edu_bg"]){
										echo "selected";
									}
									echo " > ".$row_option["name"]."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						职业︰
					</td>
					<td>
						<select id="job" name="job">
							<option value="">请选择</option>
							<?
								$sql = "select * from code where type='job';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($row_option['id']==$row["job"])
										echo "selected";
									echo " > ".$row_option["name"]."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						信仰︰
					</td>
					<td>
						<select id="faith" name="faith">
							<option value="">请选择</option>
							<?
								$sql = "select * from code where type='faith';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($row_option['id']==$row["faith"])
										echo "selected";
									echo " > ".$row_option["name"]."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						兴趣︰
					</td>
					<td>
						<?
								$interest = explode("|",$row["interest"]);
								$sql = "select * from code where type='interest';";
								$result = mysqli_query($sqli,$sql);
								for($n=0 ; $n < $row_option = mysqli_fetch_array($result); ++$n){
									echo "<input type='checkbox' id='interest".($n+1)."' name='interest[]' value='".$row_option["id"]."' ";
									if(in_array($row_option["id"], $interest))
										echo "checked";
									echo " > ".$row_option["name"]." ";
									if(($n+1)%8==0)
										echo "<br>";
								}
							?>
					</td>
				</tr>
				<tr>
					<td>
						自我介绍︰<br/><font class="font_small">(100字内)&nbsp;&nbsp;</font>
					</td>
					<td>
						<textarea id="introduction" name="introduction"><? echo $row["introduction"]; ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div style="float:right">
							<input type="button" id="member_update" name="member_update" value="修改">
						</div>
					</td>
				</tr>
		</table>
	</form>
</div>
<div class="edit_match edit_innerStyle">
	<?
		$sql = "select *  from member_require where uid='".$_SESSION["user_id"]."';";
		$result = mysqli_query($sqli,$sql);
		$rs_cn = mysqli_num_rows($result);
		if($rs_cn==0){
	?>
		<form id="form_require" action="ajax/user_data.php" method="post">
			<table>
				<tr>
					<td colspan="2">
						<input type='hidden' id='action' name='action' value="member_require_add">
						徵友条件
					</td>
				</tr>
				<tr>
					<td class="edit_item">
						性别︰
					</td>
					<td>
						<select id="re_sex" name="re_sex">
							<option value="0"> 男</option>
							<option value="1"> 女</option>
							<option value="2" selected> 不拘</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						所在地︰
					</td>
					<td>
						<select id="re_city_cate" name="re_city_cate">
							<option value="">不拘</option>
							<?
								$sql = "select * from code where type='city';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."'  > ".$row_option["name"]."</option>";
								}
							?>
						</select>
						<select id="re_city_code" name="re_city_code">
							<option value="">不拘</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						年龄︰
					</td>
					<td>
						<select id="re_age0" name="re_age0">
							<?
								for( $n = 18 ; $n <= 60 ; ++$n){
									echo "<option value='".$n."'";
										if($n==18)
											echo "selected";
									echo "> ".$n." </option>";
								}
							?>
						</select>~
						<select id="re_age1" name="re_age1">
							<?
								for( $n = 18 ; $n <= 60 ; ++$n){
									echo "<option value='".$n."' ";
										if($n==60)
											echo "selected";
									echo"> ".$n." </option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						身高︰
					</td>
					<td>
						<select id="re_height0" name="re_height0">
							<?
								for( $n = 120 ; $n <= 220 ; ++$n){
									echo "<option value='".$n."'";
										if($n==120)
											echo "selected";
									echo "> ".$n." cm</option>";
								}
							?>
						</select>~
						<select id="re_height1" name="re_height1">
							<?
								for( $n = 120 ; $n <= 220 ; ++$n){
									echo "<option value='".$n."' ";
										if($n==220)
											echo "selected";
									echo"> ".$n." cm</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						体重︰
					</td>
					<td>
						<select id="re_weight0" name="re_weight0">
							<?
								for( $n = 30 ; $n <= 150 ; ++$n){
									echo "<option value='".$n."'";
										if($n==30)
											echo "selected";
									echo "> ".$n." kg</option>";
								}
							?>
						</select>~
						<select id="re_weight1" name="re_weight1">
							<?
								for( $n = 30 ; $n <= 150 ; ++$n){
									echo "<option value='".$n."' ";
										if($n==150)
											echo "selected";
									echo"> ".$n." kg</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						血型︰
					</td>
					<td>
						<select id="re_blood_type" name="re_blood_type">
							<option value="X">不拘</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="O">O</option>
							<option value="AB">AB</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						信仰︰
					</td>
					<td>
						<select id="re_faith" name="re_faith">
							<option value="">不拘</option>
							<?
								$sql = "select * from code where type='faith';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."'  > ".$row_option["name"]."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						学历︰
					</td>
					<td>
						<select id="re_edu_bg" name="re_edu_bg">
							<option value="">不拘</option>
							<?
								$sql = "select * from code where type='edu_bg';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."'  > ".$row_option["name"]."以上</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						职业︰
					</td>
					<td>
						<select id="re_job" name="re_job">
							<option value="">不拘</option>
							<?
								$sql = "select * from code where type='job';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."'  > ".$row_option["name"]."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						叙述︰<br/><font class="font_small">(60字内)</font>
					</td>
					<td>
						<textarea id="re_note" name="re_note"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" id="require_add_btn" name="require_add_btn" value="修改">
					</td>
				</tr>
			</table>
		</form>
	<?
		}else{
			$row = mysqli_fetch_array($result);
	?>
		<form id="form_require" action="ajax/user_data.php" method="post">
			<table width="100%">
				<tr>
					<td colspan="2">
						<input type='hidden' id='action' name='action' value="member_require_edit">
						徵友条件
					</td>
				</tr>
				<tr>
					<td class="edit_item">
						性别︰
					</td>
					<td>
						<select id="re_sex" name="re_sex">
							<option value="0"<? if($row["re_sex"]=="0"){ echo "selected";}?>> 男</option>
							<option value="1"<? if($row["re_sex"]=="1"){ echo "selected";}?>> 女</option>
							<option value="2"<? if($row["re_sex"]=="2"){ echo "selected";}?>> 不拘</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						所在地︰
					</td>
					<td>
						<select id="re_city_cate" name="re_city_cate">
							<option value="">不拘</option>
							<?
								$city_cate_value = "";
								$sql = "select * from code where type='city';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($row_option['id']==$row["re_city_cate"]){
										echo "selected";
										$city_cate_value = $row_option['value'];
									}
									echo " > ".$row_option["name"]."</option>";
								}
							?>
						</select>
						<select id="re_city_code" name="re_city_code">
							<option value="">不拘</option>
							<?
								if($row["re_city_cate"]!="0"){
									$sql = "select * from code where type='city".$city_cate_value."';";
									$result = mysqli_query($sqli,$sql);
									while($row_option = mysqli_fetch_array($result)){
										echo "<option value='".$row_option["id"]."' ";
										if($row_option['id']==$row["re_city_code"]){
											echo "selected";
										}
										echo " > ".$row_option["name"]."</option>";
									}
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						年龄︰
					</td>
					<td>
						<select id="re_age0" name="re_age0">
							<?
								$age = explode("|",$row["re_age"]);
								for( $n = 18 ; $n <= 60 ; ++$n){
									echo "<option value='".$n."'";
										if($n==$age[0])
											echo "selected";
									echo "> ".$n." </option>";
								}
							?>
						</select>~
						<select id="re_age1" name="re_age1">
							<?
								for( $n = 18 ; $n <= 60 ; ++$n){
									echo "<option value='".$n."' ";
										if($n==$age[1])
											echo "selected";
									echo"> ".$n." </option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						身高︰
					</td>
					<td>
						<select id="re_height0" name="re_height0">
							<?
								$height = explode("|",$row["re_height"]);
								for( $n = 120 ; $n <= 220 ; ++$n){
									echo "<option value='".$n."'";
										if($n==$height[0])
											echo "selected";
									echo "> ".$n." cm</option>";
								}
							?>
						</select>~
						<select id="re_height1" name="re_height1">
							<?
								for( $n = 120 ; $n <= 220 ; ++$n){
									echo "<option value='".$n."' ";
										if($n==$height[1])
											echo "selected";
									echo"> ".$n." cm</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						体重︰
					</td>
					<td>
						<select id="re_weight0" name="re_weight0">
							<?
								$weight = explode("|",$row["re_weight"]);
								for( $n = 30 ; $n <= 150 ; ++$n){
									echo "<option value='".$n."'";
										if($n==$weight[0])
											echo "selected";
									echo "> ".$n." kg</option>";
								}
							?>
						</select>~
						<select id="re_weight1" name="re_weight1">
							<?
								for( $n = 30 ; $n <= 150 ; ++$n){
									echo "<option value='".$n."' ";
										if($n==$weight[1])
											echo "selected";
									echo"> ".$n." kg</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						血型︰
					</td>
					<td>
						<select id="re_blood_type" name="re_blood_type">
							<option value="X"<? if($row["re_blood_type"]=="X"){ echo "selected";}?>>不拘</option>
							<option value="A"<? if($row["re_blood_type"]=="A"){ echo "selected";}?>>A</option>
							<option value="B"<? if($row["re_blood_type"]=="B"){ echo "selected";}?>>B</option>
							<option value="O"<? if($row["re_blood_type"]=="O"){ echo "selected";}?>>O</option>
							<option value="AB"<? if($row["re_blood_type"]=="AB"){ echo "selected";}?>>AB</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						信仰︰
					</td>
					<td>
						<select id="re_faith" name="re_faith">
							<option value="">不拘</option>
							<?
								$sql = "select * from code where type='faith';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($row_option['id']==$row["re_faith"])
										echo "selected";
									echo " > ".$row_option["name"]."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						学历︰
					</td>
					<td>
						<select id="re_edu_bg" name="re_edu_bg">
							<option value="">不拘</option>
							<?
								$sql = "select * from code where type='edu_bg';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($row_option['id']==$row["re_edu_bg"]){
										echo "selected";
									}
									echo " > ".$row_option["name"]."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						职业︰
					</td>
					<td>
						<select id="re_job" name="re_job">
							<option value="">不拘</option>
							<?
								$sql = "select * from code where type='job';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' ";
									if($row_option['id']==$row["re_job"])
										echo "selected";
									echo " > ".$row_option["name"]."</option>";
								}
							?>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						叙述︰<br/><font class="font_small">(60字内)</font>
					</td>
					<td>
						<textarea id="re_note" name="re_note"><? echo $row["re_note"]; ?></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="button" id="require_edit_btn" name="require_edit_btn" value="修改">
					</td>
				</tr>
			</table>
		</form>
		<? } ?>
</div>
<script>
	function re_city_code(mytext){
		//alert(mytext);
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		str = "<option value='' > 请选择 </option>";
		for(var i = 0 ; i < arr.length ; ++i){
			str += "<option value='"+arr[i].id+"' > "+arr[i].name+"</option>";
		}
		Dd("city_code").innerHTML = str;
	}
  $("#city_cate").change(function(e) {
  		var str = "";
  		str = "action=city_code&city_cate="+Dd("city_cate").value;
      CallServer("ajax/code.php", str, "POST", true, "mytext",re_city_code );
  });
  function re_re_city_code(mytext){
		//alert(mytext);
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		str = "<option value='' > 不拘 </option>";
		for(var i = 0 ; i < arr.length ; ++i){
			str += "<option value='"+arr[i].value+"' > "+arr[i].name+"</option>";
		}
		Dd("re_city_code").innerHTML = str;
	}
  $("#re_city_cate").change(function(e) {
  		var str = "";
  		str = "action=city_code&city_cate="+Dd("re_city_cate").value;
      CallServer("ajax/code.php", str, "POST", true, "mytext",re_re_city_code );
  });
  $("#member_update").click(function(e){
  	if(Dd("nick").value.length > 16 || Dd("nick").value.length < 2){
  		alert("昵称长度为2～16个字");
  		return false;
  	}
  	else if(Dd("introduction").value.length > 100){
  		alert("自我介绍字数需100字内");
  		return false;
  	}
  	else
  		Dd("form_member").submit();
  })
  $("#require_add_btn").click(function(e){
  	if(Dd("re_note").value.length > 60){
  		alert("叙述字数需60字内");
  		return false;
  	}
  	else
  		Dd("form_require").submit();
  })
  $("#require_edit_btn").click(function(e){
  	if(Dd("re_note").value.length > 60){
  		alert("叙述字数需60字内");
  		return false;
  	}
  	else
  		Dd("form_require").submit();
  })

</script>