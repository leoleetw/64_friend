<?
	include_once("include/dbinclude.php");
	@$recommend = isset($_POST["recommend"]) ? $_POST['recommend'] : $_GET['recommend'] ;
?>
<form id='register_form' action='ajax/register.php' method="post">
	<div class="tab-content">
	  <div class="tab-pane active" id="tab1">
	  	<table width="100%">
      	<tr>
      		<td width="15%" align="right">帐号：</td>
      		<td width="90%">
      			<div id="acc_div" class="form-group">
      				<input type="text" id="acc" name="acc" value="" class="form-control" style="width:60%;display:inline;" placeholder="英文数字8～16字元" onkeypress="checkinput_reg(this.id);" onKeyUp="checkinput_reg(this.id);" onchange="checkinput(this.id);">
      				<font style="color:red;display:inline;" id="acc_note"></font>
      			</div>
      		</td>
      	</tr>
      	<tr>
      		<td align="right">密码：</td>
      		<td>
      			<div id="pwd_div" class="form-group">
      				<input type="password" id="pwd" name="pwd" value="" class="form-control" style="width:60%;display:inline;" placeholder="英文数字8～16字元" onkeypress="checkinput_reg(this.id);" onKeyUp="checkinput_reg(this.id);">
      				<font style="color:red;display:inline;" id="pwd_note"></font>
      			</div>
      		</td>
      	</tr>
      	<tr>
      		<td align="right">确认密码：</td>
      		<td>
      			<div id="pwd_ck_div" class="form-group">
      				<input type="password" id="pwd_ck" name="pwd_ck" value="" class="form-control" style="width:60%;display:inline;" placeholder="英文数字8～16字元" onkeypress="checkinput_reg(this.id);" onKeyUp="checkinput_reg(this.id);">
      				<font style="color:red;display:inline;" id="pwd_ck_note"></font>
      			</div>
      		</td>
      	</tr>
      	<tr>
      		<td align="right">E-mail：</td>
      		<td>
      			<div id="email_div" class="form-group">
      				<input type="text" id="email" name="email" value="" class="form-control" style="width:60%;display:inline;" onkeypress="checkinput_reg(this.id);" onKeyUp="checkinput_reg(this.id);" onchange="checkinput(this.id);">
      				<font style="color:red;display:inline;" id="email_note"></font>
      			</div>
      		</td>
      	</tr>
      	<tr>
      		<td align="right">手机：</td> <!--大陸11碼 第一個號碼為1   台灣 10碼 第一個為0-->
      		<td>
      			<div id="mobile_div" class="form-group">
      				<input type="text" id="mobile" name="mobile" value="" class="form-control" style="width:60%;display:inline;" onkeypress="checkinput_reg(this.id);" onKeyUp="checkinput_reg(this.id);" onchange="checkinput(this.id);">
      				<font style="color:red;display:inline;" id="mobile_note"></font>
      			</div>
      		</td>
      	</tr>
      	<tr>
      		<td align="right">推薦人ID：</td> <!---->
      		<td>
      			<div id="recommend_div" class="form-group">
      				<?
      					if($recommend!=""){
      				?>
      				<input type="text" id="recommend" name="recommend" value="<? echo $recommend; ?>" class="form-control" style="width:60%;display:inline;" readonly>
      				<?
      					}else{
      				?>
      				<input type="text" id="recommend" name="recommend" value="<? echo $recommend; ?>" class="form-control" style="width:60%;display:inline;">
      				<?
      					}
      				?>
      				<font style="color:red;display:inline;" id="recommend_note">推荐人验证成功後，将会得到奖励</font>
      			</div>
      		</td>
      	</tr>
      </table>
		<a href="#tab2" data-toggle="tab">下一頁</a>
	  </div>
	  
	  <div class="tab-pane" id="tab2">
	    <table width="100%">
	    	<tr>
	    		<td width="20%">真实姓名︰</td>
	    		<td>
	    			<div class="form-group">
		    			<input type="text" id="name" name="name" value="" class="form-control">
		    		</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>昵称︰</td>
	    		<td>
	    			<div class="form-group">
	    				<input type="text" id="nick" name="nick" value="" class="form-control">
	    			</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>
	    			<div class="form-group">
	    			性别︰
	    			</div>
	    			<div class="form-group" id="measure_name_div" style="display:none">
	    				三围（英寸）︰
	    			</div>
	    		</td>
	    		<td>
	    			<div class="form-group">
		    			<input type="radio" id="sex0" name="sex" value="0" onclick="change_measure_state(this.value);"> 男
							<input type="radio" id="sex1" name="sex" value="1" onclick="change_measure_state(this.value);"> 女
						</div>
						<div class="form-group" id="measure_div" style="display:none">
	    				胸围︰
	    				<select id="breast" name="breast" class="form-control" style="width:25%;display:inline;">
	    					<option value="">请选择</option>
	    					<option value="0">不清楚</option>
	    				<?
	    					for($i = 30 ; $i <= 42 ; ++$i)
	    						echo "<option value='".$i."' > ".$i." </option>";
	    				?>
	    				</select>
	    				腰围︰
	    				<select id="waist" name="waist" class="form-control" style="width:25%;display:inline;">
	    					<option value="">请选择</option>
	    					<option value="0">不清楚</option>
	    				<?
	    					for($i = 20 ; $i <= 40 ; ++$i)
	    						echo "<option value='".$i."' > ".$i." </option>";
	    				?>
	    				</select>
	    				臀围︰
	    				<select id="hips" name="hips" class="form-control" style="width:25%;display:inline;">
	    					<option value="">请选择</option>
	    					<option value="0">不清楚</option>
	    				<?
	    					for($i = 30 ; $i <= 50 ; ++$i)
	    						echo "<option value='".$i."' > ".$i." </option>";
	    				?>
	    				</select>
		    		</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td></td>
	    		<td>
	    			
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>所在地︰</td>
	    		<td>
	    			<div class="form-group">
		    			<select id="city_cate" name="city_cate" class="form-control" style="width:45%;display:inline;">
								<option value="">请选择</option>
								<?
									$sql = "select * from code where type='city';";
									$result = mysqli_query($sqli,$sql);
									while($row_option = mysqli_fetch_array($result))
										echo "<option value='".$row_option["id"]."'  > ".$row_option["name"]."</option>";
								?>
							</select>
							<select id="city_code" name="city_code" class="form-control" style="width:45%;display:inline;">
								<option value="">请选择</option>
							</select>	
						</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>生日︰</td>
	    		<td>
	    			<div class="form-group">
		    			<select id="birth_day_y" name="birth_day_y" class="form-control" style="width:25%;display:inline;">
								<option value="">请选择</option>
								<? 
									for($i=1900 ; $i <= intval(date("Y"));++$i){
										echo "<option value='".$i."' > ".$i." </option>";
									}
								?>
							</select>
							<font>年</font>
							<select id="birth_day_m" name="birth_day_m" class="form-control" style="width:25%;display:inline;">
								<option value="">请选择</option>
								<? 
									for($i=1 ; $i <= 12;++$i){
										if($i < 10)
											echo "<option value='0".$i."' > 0".$i." </option>";
										else
											echo "<option value='".$i."' > ".$i." </option>";
									}
								?>
							</select>
							<font>月</font>
							<select id="birth_day_d" name="birth_day_d" class="form-control" style="width:25%;display:inline;">
								<option value="">请选择</option>
								<? 
									for($i=1 ; $i <= 31;++$i){
										if($i < 10)
											echo "<option value='0".$i."' > 0".$i." </option>";
										else
											echo "<option value='".$i."' > ".$i." </option>";
									}
								?>
							</select>
							<font>日</font>
						</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>身高︰</td>
	    		<td>
	    			<div class="form-group">
		    			<select id="height" name="height" class="form-control">
								<option value="">请选择</option>
								<? 
									for($i=120 ; $i <= 220;++$i)
										echo "<option value='".$i."' > ".$i."cm </option>";
								?>
							</select>
						</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>体重︰</td>
	    		<td>
	    			<div class="form-group">
		    			<select id="weight" name="weight" class="form-control">
								<option value="">请选择</option>
								<? 
									for($i=30 ; $i <= 150;++$i)
										echo "<option value='".$i."' > ".$i."kg </option>";
								?>
							</select>
						</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>血型︰</td>
	    		<td>
	    			<div class="form-group">
		    			<select id="blood_type" name="blood_type" class="form-control">
								<option value="">请选择</option>
								<option value="X">不清楚</option>
								<option value="A">A</option>
								<option value="B">B</option>
								<option value="O">O</option>
								<option value="AB">AB</option>
							</select>
						</div>
					</td>
	    	</tr>
	    	
	    	
	    	<tr>
	    		<td>学历︰</td>
	    		<td>
	    			<div class="form-group">
		    			<select id="edu_bg" name="edu_bg" class="form-control">
								<option value="">请选择</option>
								<?
									$sql = "select * from code where type='edu_bg';";
									$result = mysqli_query($sqli,$sql);
									while($row_option = mysqli_fetch_array($result))
										echo "<option value='".$row_option["id"]."' > ".$row_option["name"]."</option>";
								?>
							</select>
						</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>职业︰</td>
	    		<td>
	    			<div class="form-group">
		    			<select id="job" name="job" class="form-control">
								<option value="">请选择</option>
								<?
									$check = 0;
									$sql = "select * from code where type='job';";
									$result = mysqli_query($sqli,$sql);
									while($row_option = mysqli_fetch_array($result))
										echo "<option value='".$row_option["id"]."'  > ".$row_option["name"]."</option>";
								?>
							</select>
						</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>信仰：</td>
	    		<td>
	    			<div class="form-group">
		    			<select id="faith" name="faith" class="form-control">
								<option value="">请选择</option>
								<?
									$check = 0;
									$sql = "select * from code where type='faith';";
									$result = mysqli_query($sqli,$sql);
									while($row_option = mysqli_fetch_array($result))
										echo "<option value='".$row_option["id"]."' > ".$row_option["name"]."</option>";
								?>
							</select>
						</div>
	    		</td>
	    	</tr>
	    	<tr>
	    		<td>兴趣︰</td>
	    		<td>
	    			<?
							$sql = "select * from code where type='interest';";
							$result = mysqli_query($sqli,$sql);
							for($n = 0 ; $n < $row_check = mysqli_fetch_array($result);++$n){
						?>
							<input type="checkbox" id="interest<? echo ($n+1); ?>" name="interest[]" value="<? echo $row_check["id"]; ?>"> <? echo $row_check["name"]; ?>
						<?
							}
						?>
					</td>
	    	</tr>
	    </table>
	    
	    <a href="#tab1" data-toggle="tab">上一頁</a>
	    <input type="hidden" id="action" name="action" value="">
	    <input type="button" value="送出" onclick="register();">
	  </div>
	</div>
</form>
<script>
	function change_measure_state(this_value){
		if(this_value=="0"|| this_value==""){
			none("measure_name_div");
			none("measure_div");
		}
		else{
			block("measure_name_div");
			block("measure_div");
		}
	}
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
	function re_checkinput(mytext){
		var arr = new Array();
		arr = mytext.split("|");
		if(arr[0]=="0"){
			Dd(arr[1]+"_div").className="form-group has-success";
			Dd(arr[1]+"_note").innerHTML="";
		}
		else{
			Dd(arr[1]+"_div").className="form-group has-error";
			if(arr[1]=="acc")
				Dd(arr[1]+"_note").innerHTML="＊该帐号已重复";
			else if(arr[1]=="email")
				Dd(arr[1]+"_note").innerHTML="＊该信箱已重复";
			else if(arr[1]=="mobile")
				Dd(arr[1]+"_note").innerHTML="＊该手机已重复";
		}
	}
	function checkinput(this_id){
		if(Dd(this_id+"_div").className=="form-group has-success"){
			str = "action=check&target="+this_id+"&value="+Dd(this_id).value;
			CallServer("ajax/register.php", str, "POST", true, "mytext",re_checkinput );
		}
	}
	
	function checkinput_reg(this_id){
		var reg=/[^A-Za-z0-9_]/g ;
		if(this_id=="acc" || this_id=="pwd"){
			if(Dd(this_id).value.length < 8 || Dd(this_id).value.length > 16){ 
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊字数需8～16个";
			}
			else if(reg.test(Dd(this_id).value)){
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊不得有特殊字元";
			}
			else{
				Dd(this_id+"_div").className="form-group has-success";
				Dd(this_id+"_note").innerHTML="";
			}
		}
		else if(this_id=="pwd_ck"){
			if(Dd("pwd").value != Dd("pwd_ck").value || Dd("pwd_ck").value == ""){
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊两次密码不相同";
			}
			else{
				Dd(this_id+"_div").className="form-group has-success";
				Dd(this_id+"_note").innerHTML="";
			}
		}
		else if(this_id=="email"){
			if(Dd(this_id).value.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/)== -1){
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊email格式不符";
			}
			else{
				Dd(this_id+"_div").className="form-group has-success";
				Dd(this_id+"_note").innerHTML="";
			}
		}
		else if(this_id=="mobile"){
			if(Dd(this_id).value.length == 10){
				if(Dd(this_id).value.search(/^0+[0-9]/)== -1){
					Dd(this_id+"_div").className="form-group has-error";
					Dd(this_id+"_note").innerHTML="＊手机格式不符";
				}
				else{
					Dd(this_id+"_div").className="form-group has-success";
					Dd(this_id+"_note").innerHTML="";
				}
			}
			else if(Dd(this_id).value.length == 11){
				if(Dd(this_id).value.search(/^1+[0-9]/)== -1){
					Dd(this_id+"_div").className="form-group has-error";
					Dd(this_id+"_note").innerHTML="＊手机格式不符";
				}
				else{
					Dd(this_id+"_div").className="form-group has-success";
					Dd(this_id+"_note").innerHTML="";
				}
			}
			else{
				Dd(this_id+"_div").className="form-group has-error";
				Dd(this_id+"_note").innerHTML="＊手机格式不符";
			}
		}
	}
	function register(){
		var reg=/[^A-Za-z0-9_]/g ;
		if(Dd("acc").value=="" || Dd("pwd").value==""  || Dd("pwd_ck").value==""  || Dd("email").value=="" ){ //输入值判定
			alert("请先将所有栏位填完");
		}
		else if(Dd("pwd").value.length < 8 || Dd("pwd").value.length > 16 || Dd("acc").value.length < 8 || Dd("acc").value.length > 16){
			alert("帐号及密码字数需为8～16个");
		}
		else if(Dd("pwd").value != Dd("pwd_ck").value){ //密码验证
			Dd("pwd").value = "";
			Dd("pwd_ck").value = "";
			Dd("pwd").focus();
			alert("两次密码输入不一致");
		}
		else if(reg.test(Dd("acc").value)){ //特殊字元判定 帐号
			Dd("acc").focus();
			alert("帐号不得包括特殊字元");
		}
		else if(reg.test(Dd("pwd").value)){ //特殊字元判定 密码
			Dd("pwd").focus();
			alert("密码不得包括特殊字元");
		}
		else if (Dd("email").value.search(/^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/)== -1){ //email验证
			Dd("email").focus();
			alert("E-mail格式不符合规定");
		}
		else if(Dd("acc_div").className=="form-group has-error" || Dd("pwd_div").className=="form-group has-error" || Dd("pwd_ck_div").className=="form-group has-error" || Dd("email_div").className=="form-group has-error"|| Dd("mobile_div").className=="form-group has-error"){
			alert("尚有项目未通过验证");
		}
		else if(Dd("name").value=="" || Dd("nick").value=="" ||  Dd("city_code").value==""){
			alert("尚有项目未填写");
		}
		else if(Dd("birth_day_y").value=="" || Dd("birth_day_m").value=="" || Dd("birth_day_d").value==""|| Dd("height").value==""|| Dd("weight").value==""){
			alert("尚有项目未填写");
		}
		else if(Dd("blood_type").value==""|| Dd("edu_bg").value==""|| Dd("job").value==""|| Dd("faith").value==""){
			alert("尚有项目未填写");
		}
		else if(Dd("sex0").checked==false && Dd("sex1").checked==false){
			alert("性别尚未选择");
		}
		else if(Dd("sex1").checked==true &&(Dd("breast").value==""|| Dd("waist").value==""|| Dd("hips").value=="")){
			alert("三围尚未填写");
		}
		else{
			Dd("register_form").action.value="register";
			Dd("register_form").submit();
		}
	}
</script>