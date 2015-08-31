<div>
	<div>
		<table width=100%>
			<tr>
				<td width=15% style="text-align:right"><font>查詢類型：</font></td>
				<td width=30%>
					<select id="search_type" name="search_type" class="form-control">
						<option value="uid"> 會員編號</option>
						<option value="ident_code"> 特殊編號</option>
						<option value="member_name"> 會員暱稱或本名</option>
					</select>
				</td>
				<td width=15% style="text-align:right"><fnot>查詢值：</fnot></td>
				<td width=30%>
					<input type="text" id="search_value" name="search_value" value="" class="form-control">
				</td>
				<td width=10% style="text-align:center">
					<input type="button" id="search_btn" name="search_btn" value="查詢" class="btn" onclick="search_member();">
				</td>
			</tr>
		</table>
	</div>
	<div id="loading_div" style="display:none"><img src="../include/images/loading.gif"></div>
	<div id="member_list_div" style="display:none">
		
	</div>
	<div id="member_data_div" style="display:none">
		<form id="member_data" action="ajax/search_member.php" method="post">
			<table class="table">
				<tr>
					<td rowspan="14">
						<div><img id="face_photo" name="face_photo"></div>
						<div><a href="" id="member_data_a" target="_blank">個人頁面</a></div>
						<div>
							<input type="hidden" id="uid" name="uid" value="" >
							<font id="uid_font"></font>-<input type="text" id="ident_code" name="ident_code" value=""  class="form-control" style="width:48%;display:inline">
						</div>
						<div>登入IP：<font id="login_ip"></font></div>
						<div>登入DATE：<font id="login_date"></font></div>
						<div>被收藏數量：<font id="fa_count"></font></div>
						<div>
							帳號狀態：
								<select id="user_state" name="user_state">
									<option value='0'> 尚未开通</option>
									<option value='1'> 一般會員</option>
									<option value='2'> VIP會員</option>
									<option value='9'> 停權</option>
									<option value='99'> 系統管理員</option>
								</select>
						</div>
					</td>
					<td>姓名：</td>
					<td><input type="text" id="member_name" name="member_name" class="form-control"></td>
				</tr>
				<tr>
					<td>暱稱：</td>
					<td><input type="text" id="member_nick" name="member_nick" class="form-control"></td>
				</tr>
				<tr>
					<td>
						性别︰
					</td>
					<td>
						<input type="radio" id="sex0" name="sex" value="0"> 男
						<input type="radio" id="sex1" name="sex" value="1"> 女
					</td>
				</tr>
				<tr>
					<td>
						所在地︰
					</td>
					<td>
						<select id="city_cate" name="city_cate" class="form-control" style="width:48%;display:inline;">
							<option value="">请选择</option>
							<?
								$city_cate_value = "";
								$sql = "select * from code where type='city';";
								$result = mysqli_query($sqli,$sql);
								while($row_option = mysqli_fetch_array($result)){
									echo "<option value='".$row_option["id"]."' > ".$row_option["name"]."</option>";
								}
							?>
						</select>
						<input type="hidden" id="city_code_temp" value="" >
						<select id="city_code" name="city_code" class="form-control" style="width:48%;display:inline;">
							<option value="">请选择</option>
							
						</select>
					</td>
				</tr>
				<tr>
					<td>
						生日︰
					</td>
					<td>
						<select id="birth_day_y" name="birth_day_y" class="form-control" style="width:30%;display:inline;">
							<option value="">请选择</option>
							<? 
								$birthday = Array();
								$birthday = explode('-',$row["birth_day"]);
								for($i=1900 ; $i <= intval(date("Y"));++$i){
									echo "<option value='".$i."' > ".$i." </option>";
								}
							?>
						</select>年
						<select id="birth_day_m" name="birth_day_m" class="form-control" style="width:30%;display:inline;">
							<option value="">请选择</option>
							<?
								for($i=1 ; $i <= 12;++$i){
									if($i < 10){
										echo "<option value='0".$i."' > 0".$i." </option>";
									}
									else{
										echo "<option value='".$i."' > ".$i." </option>";
									}
								}
							?>
						</select>月
						<select id="birth_day_d" name="birth_day_d" class="form-control" style="width:30%;display:inline;">
							<option value="">请选择</option>
							<?
								for($i=1 ; $i <= 31;++$i){
									if($i < 10){
										echo "<option value='0".$i."' > 0".$i." </option>";
									}
									else{
										echo "<option value='".$i."' > ".$i." </option>";
									}
								}
							?>
						</select>日
					</td>
				</tr>
				<tr>
					<td>
						血型︰
					</td>
					<td>
						<select id="blood_type" name="blood_type" class="form-control">
							<option value="">请选择</option>
							<option value="X">不清楚</option>
							<option value="A">A</option>
							<option value="B">B</option>
							<option value="O">O</option>
							<option value="AB">AB</option>
						</select>
					</td>
				</tr>
				<tr>
					<td>
						身高︰
					</td>
					<td>
						<select id="height" name="height" class="form-control">
							<option value="">请选择</option>
							<?
								for($i=120 ; $i <= 220;++$i){
									echo "<option value='".$i."' > ".$i."cm </option>";
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
						<select id="weight" name="weight" class="form-control">
							<option value="">请选择</option>
							<?
								for($i=30 ; $i <= 150;++$i){
									echo "<option value='".$i."' > ".$i."kg </option>";
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
						<select id="edu_bg" name="edu_bg" class="form-control">
							<option value="">请选择</option>
							<?
								$sql = "select * from code where type='edu_bg';";
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
						职业︰
					</td>
					<td>
						<select id="job" name="job" class="form-control">
							<option value="">请选择</option>
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
						信仰︰
					</td>
					<td>
						<select id="faith" name="faith" class="form-control">
							<option value="">请选择</option>
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
						兴趣︰
					</td>
					<td>
						<?
								$interest = explode("|",$row["interest"]);
								$sql = "select * from code where type='interest' order by id;";
								$result = mysqli_query($sqli,$sql);
								for($n=0 ; $n < $row_option = mysqli_fetch_array($result); ++$n){
									echo "<input type='checkbox' id='interest".$row_option["id"]."' name='interest[]' value='".$row_option["id"]."'  > ".$row_option["name"]." ";
								}
							?>
					</td>
				</tr>
				<tr>
					<td>
						自我介绍︰<br/><font class="font_small">(100字内)&nbsp;&nbsp;</font>
					</td>
					<td>
						<textarea id="introduction" name="introduction" class="form-control"></textarea>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<div style="float:right">
							<input type="hidden" id="action" name="action" value="edit_member_data" >
							<input type="button" id="cancel_btn" name="cancel_btn" value="取消" onclick="none('member_data_div');block('member_list_div');">
							<input type="submit" id="member_update" name="member_update" value="修改">
							
						</div>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
<script>
	function input_city_code(mytext){
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		str = "<option value='' > 请选择 </option>";
		for(var i = 0 ; i < arr.length ; ++i){
			str += "<option value='"+arr[i].id+"' > "+arr[i].name+"</option>";
		}
		Dd("city_code").innerHTML = str;
		Dd("city_code").value = Dd("city_code_temp").value;
	}
	function re_get_member_data(mytext){
		none("loading_div");
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		Dd("face_photo").src = "../update/face_photo/"+arr.photo_url;
		Dd("member_data_a").href = "../member_data.php?uid="+arr.uid;
		Dd("uid").value = arr.uid;
		Dd("uid_font").innerHTML = arr.uid;
		Dd("login_ip").innerHTML = arr.login_ip;
		Dd("login_date").innerHTML = arr.login_date;
		Dd("fa_count").innerHTML = arr.fa_count;
		Dd("user_state").value = arr.state;
		Dd("ident_code").value = arr.ident_code;
		Dd("member_name").value = arr.name;
		Dd("member_nick").value = arr.nick;
		Dd("city_cate").value = arr.city_cate;
		Dd("city_code_temp").value = arr.city_code;
		var birth = new Array();
		birth = arr.birth_day.split("-");
		Dd("birth_day_y").value = birth[0];
		Dd("birth_day_m").value = birth[1];
		Dd("birth_day_d").value = birth[2];
		Dd("blood_type").value = arr.blood_type;
		Dd("height").value = arr.height;
		Dd("weight").value = arr.weight;
		Dd("edu_bg").value = arr.edu_bg;
		Dd("job").value = arr.job;
		Dd("faith").value = arr.faith;
		Dd("introduction").value = arr.introduction;
		if(arr.sex=="0")
			Dd("sex0").checked=true;
		else
			Dd("sex1").checked=true;
		if(isnull(arr.interest)!=""){
			var interest = new Array();
			interest = arr.interest.split("|");
			for(var i = 0 ; i < interest.length ; ++i)
				Dd("interest"+interest[i]).checked = true;
		}
		block("member_data_div");
		CallServer("../ajax/code.php", "action=city_code&city_cate="+Dd("city_cate").value, "POST", true, "mytext",input_city_code );
	}
	
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
      CallServer("../ajax/code.php", str, "POST", true, "mytext",re_city_code );
  });
  
	function get_member_data(uid){
		var str = "";
		str = "action=member_data&uid="+uid;
		none("member_list_div");
		block("loading_div");
		CallServer("ajax/search_member.php", str, "POST", true, "mytext",re_get_member_data );
	}
	
	function re_search_member(mytext){
		none("loading_div");
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		var uid = "";
		var n = 0 ;
		if(arr.length == 0)
			alert("查無資料");
		else{
			str = "<table id='member_list_talbe' width=100% class='table'><thead><tr><th width='25%'>會員編號</th><th width='25%'>姓名</th><th width='25%'>暱稱</th><th width='25%'>性別</th></tr></thead><tbody>";
			for(var i = 0 ; i < arr.length ; ++i){
				uid="";
				for(n = 0 ; n < 7-arr[i].uid.length ; ++n)
					uid += "0";
				uid += arr[i].uid;
				if(isnull(arr[i].ident_code)!=""){
					uid += "-";
					for(n = 0 ; n < 6-arr[i].ident_code.length ; ++n)
						uid += "0";
					uid += arr[i].ident_code;
				}
				str +="<tr><td><a href=# onclick=get_member_data('"+arr[i].uid+"');>"+uid+"</a></td>";
				str +="<td>"+arr[i].name+"</td>";
				str +="<td>"+arr[i].nick+"</td>";
				if(arr[i].sex=="0")
					str +="<td>男</td></tr>";
				else
					str +="<td>女</td></tr>";
			}
			str += "</tbody></table>";
			Dd("member_list_div").innerHTML = str;
		}
		block("member_list_div");
	}
	function search_member(){
		if(Dd("search_type").value=="" || Dd("search_value").value==""){
			alert("搜尋值或條件不得為空");
		}
		else{
			var str = "";
			str = "action=search&search_type="+Dd("search_type").value+"&search_value="+Dd("search_value").value;
			none("member_list_div");
			none("member_data_div");
			block("loading_div");
			CallServer("ajax/search_member.php", str, "POST", true, "mytext",re_search_member );
		}
	}
</script>