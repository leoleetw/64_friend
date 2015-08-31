<?
	include_once("include/dbinclude.php");
	
	$sql = "select a.* , b.* from user a, member b where a.uid = b.uid AND a.uid='".$_SESSION["user_id"]."';";
	$result = mysqli_query($sqli,$sql);
	$row = mysqli_fetch_array($result);
?>

<form id="form1" action="ajax/user_data.php" method="post">
			<input type='hidden' id='action' name='action'>
			昵称︰
				<input type="text" id="name" name="name" value="<? echo $row["name"]; ?>">
			性别︰
					<input type="radio" id="sex0" name="sex" value="0" <? if($row["sex"]=="0"){echo "checked";} ?>> 男
					<input type="radio" id="sex1" name="sex" value="1" <? if($row["sex"]=="1"){echo "checked";} ?>> 女
			生日︰
				<select id="birth_day_y" name="birth_day_y">
					<option>请选择</option>
					<? 
						$birthday = Array();
						$birthday = explode('-',$row["birth_day"]);
						for($i=1900 ; $i <= intval(date("Y"));++$i){
							echo "<option value='".$i."' ";
							if($row["birth_day"]!=""){
								if(intval($birthday[0])==$i)
									echo "selected";
							}
							echo "> ".$i." </option>";
						}
					?>
				</select>年
				<select id="birth_day_m" name="birth_day_m">
					<option>请选择</option>
					<? 
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
						}
					?>
				</select>月
				<select id="birth_day_d" name="birth_day_d">
					<option>请选择</option>
					<? 
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
						}
					?>
				</select>日
				血型︰
				<select id="blood_type" name="blood_type">
					<option>请选择</option>
					<option value="X"<? if($row["blood_type"]=="X"){ echo "selected";}?>>不清楚</option>
					<option value="A"<? if($row["blood_type"]=="A"){ echo "selected";}?>>A</option>
					<option value="B"<? if($row["blood_type"]=="B"){ echo "selected";}?>>B</option>
					<option value="O"<? if($row["blood_type"]=="O"){ echo "selected";}?>>O</option>
					<option value="AB"<? if($row["blood_type"]=="AB"){ echo "selected";}?>>AB</option>
				</select>
				身高︰
				<select id="height" name="height">
					<option>请选择</option>
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
				体重︰
				<select id="weight" name="weight">
					<option>请选择</option>
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
				所在地︰
				<select id="city_cate" name="city_cate">
					<option>请选择</option>
					<?
						$city = explode("|",$row["city_code"]);
						$sql = "select * from code where type='city';";
						$result = mysqli_query($sqli,$sql);
						while($row_option = mysqli_fetch_array($result)){
							echo "<option value='".$row_option["value"]."' ";
							if($row_option['value']==$city[0]){
								echo "selected";
							}
							echo " > ".$row_option["name"]."</option>";
						}
					?>
				</select>
				<select id="city_code" name="city_code">
					<option>请选择</option>
					<?
						if($row["city_code"]!=""){
							$sql = "select * from code where type='city".$city[0]."';";
							$result = mysqli_query($sqli,$sql);
							while($row_option = mysqli_fetch_array($result)){
								echo "<option value='".$row_option["value"]."' ";
								if($row_option['value']==$city[1]){
									echo "selected";
								}
								echo " > ".$row_option["name"]."</option>";
							}
						}
					?>
				</select>
				学历︰
				<select id="edu_bg" name="edu_bg">
					<option>请选择</option>
					<?
						$check = 0;
						$sql = "select * from code where type='edu_bg';";
						$result = mysqli_query($sqli,$sql);
						while($row_option = mysqli_fetch_array($result)){
							echo "<option value='".$row_option["value"]."' ";
							if($row_option['value']==$row["edu_bg"]){
								echo "selected";
								$check = 1 ;
							}
							echo " > ".$row_option["name"]."</option>";
						}
						if($row["edu_bg"]!="" && $check == 0)
							echo "<option value='".$row["edu_bg"]."' selected> ".$row["edu_bg"]."</option>";
					?>
				</select>
				学校︰
				<input type="text" id="school" name="school" value="<? echo $row["school"]; ?>">
				职业︰
				<select id="job" name="job">
					<option>请选择</option>
					<?
						$check = 0;
						$sql = "select * from code where type='job';";
						$result = mysqli_query($sqli,$sql);
						while($row_option = mysqli_fetch_array($result)){
							echo "<option value='".$row_option["value"]."' ";
							if($row_option['value']==$row["job"]){
								echo "selected";
								$check = 1 ;
							}
							echo " > ".$row_option["name"]."</option>";
						}
						if($row["job"]!="" && $check == 0)
							echo "<option value='".$row["job"]."' selected> ".$row["job"]."</option>";
					?>
				</select>
				信仰︰
				<select id="faith" name="faith">
					<option>请选择</option>
					<?
						$check = 0;
						$sql = "select * from code where type='faith';";
						$result = mysqli_query($sqli,$sql);
						while($row_option = mysqli_fetch_array($result)){
							echo "<option value='".$row_option["value"]."' ";
							if($row_option['value']==$row["faith"]){
								echo "selected";
								$check = 1 ;
							}
							echo " > ".$row_option["name"]."</option>";
						}
						if($row["edu_bg"]!="" && $check == 0)
							echo "<option value='".$row["faith"]."' selected> ".$row["faith"]."</option>";
					?>
				</select>
				自我介绍︰
				<textarea id="introduction" name="introduction"><? echo $row["introduction"]; ?></textarea>
				<!--
				开放观看（需先填妥资料，并经过审核）︰
				<input type="radio" id="open0" name="open" value="0" <? //if($row["state"]!="0"){echo "checked";} ?>> 是
				<input type="radio" id="open1" name="open" value="1" <? //if($row["state"]=="0"||$row["state"]==""){echo "checked";} ?>> 否
				-->
				当前状态︰<? if($row["state"]=='0'||$row["state"]==''){echo "未开放";}else if($row["state"]=='1'){echo "资料审核";}else if($row["state"]=='2'){echo "开放";} ?>
				<input type="button" id="cancel" name="cancel" value="取消">
				<input type="button" id="update" name="update" value="送出审核">
</form>

<script>
	function re_city_code(mytext){
		//alert(mytext);
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		str = "<option value='' > 请选择 </option>";
		for(var i = 0 ; i < arr.length ; ++i){
			str += "<option value='"+arr[i].value+"' > "+arr[i].name+"</option>";
		}
		Dd("city_code").innerHTML = str;
	}
  $("#city_cate").change(function(e) {
  		var str = "";
  		str = "action=city_code&city_cate="+Dd("city_cate").value;
      CallServer("ajax/code.php", str, "POST", true, "mytext",re_city_code );
  });
  $("#cancel").click(function(e) {
      history.go(-1);
  });
  
  $("#update").click(function(e) {
      form1.action.value='update';
      Dd("form1").submit();
  });

</script>