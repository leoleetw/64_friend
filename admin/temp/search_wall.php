<div>
	<div>
		<table width=100%>
			<tr>
				<td width=15% style="text-align:right"><font>查詢類型：</font></td>
				<td width=30%>
					<select id="search_type" name="search_type" class="form-control">
						<option value="uid"> 會員編號</option>
						<option value="member_name"> 會員暱稱或本名</option>
						<option value="wa_id"> 塗鴉牆編號</option>
						<option value="wa_content"> 塗鴉牆內容</option>
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
	<div id="wall_list_div" style="display:none">
	</div>
</div>

<div class="modal fade" id="loading_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<div class="modal-header">
      	<h1>LOADING...</h1>
      </div>
      <div class="modal-body">
      	<img src='../include/images/loading1.gif' style="width:100%">
      </div>
    </div>
  </div>
</div>
<script>
	function re_change_state(mytext){
		$('#loading_Modal').modal('hide');
		var arr = new Array();
		arr = mytext.split("|");
		if(arr[0]=='0')
			alert(arr[1]);
		else if(arr[0]=='1')
			return false;
		else
			alert(mytext);
	}
	function change_state(wa_id , this_value){
		$('#loading_Modal').modal({
		  keyboard: false,
		  backdrop: "static"
		});
		var str = "";
		if(this_value == '1')
			str = "action=change_state&show=1&wa_id="+wa_id;
		else if(this_value == '0')
			str = "action=change_state&show=0&wa_id="+wa_id;
		CallServer("ajax/search_wall.php", str, "POST", true, "mytext",re_change_state );
	}
	function re_search_wall(mytext){
		none("loading_div");
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		var uid = "";
		var sex = "";
		var n = 0 ;
		if(arr.length == 0)
			alert("查無資料");
		else{
			str = "<table id='wall_list_talbe' width=100% class='table'><thead><tr><th width='20%'>會員</th><th width='35%'>內容</th><th width='35%'>圖片</th><th width='10%'>動作</th></tr></thead><tbody>";
			for(var i = 0 ; i < arr.length ; ++i){
				uid="";
				for(n = 0 ; n < 7-arr[i].uid.length ; ++n)
					uid += "0";
				uid += arr[i].uid;
				sex = "";
				if(arr[i].sex=="0")
					sex = "男";
				else
					sex = "女";
				str +="<tr><td><div><img src='../update/face_photo/"+arr[i].photo_url+"'></div>"+arr[i].name+"("+sex+")<br>"+arr[i].nick+"<br>"+uid+"</td>";
				
				str +="<td>"+arr[i].wa_content+"</td><td>";
				if(isnull(arr[i].wall_photo)!='')
					str +="<img src='../update/wall_s/"+arr[i].wall_photo+"'>";
				str += "</td><td><select onchange=change_state('"+arr[i].wa_id+"',this.value);>";
				str += "<option value='0' ";
				if(arr[i].wa_state == '0')
					str += "selected";
				str += " >顯示</option><option value='1' ";
				if(arr[i].wa_state == '1')
					str += "selected";
				str += "><font style='color:red;'>隱藏</font></option><option value='9'>刪除</option></select></td></tr>";
					
			}
			str += "</tbody></table>";
			Dd("wall_list_div").innerHTML = str;
		}
		block("wall_list_div");
	}
	function search_member(){
		if(Dd("search_type").value=="" || Dd("search_value").value==""){
			alert("搜尋值或條件不得為空");
		}
		else{
			var str = "";
			str = "action=search&search_type="+Dd("search_type").value+"&search_value="+Dd("search_value").value;
			none("wall_list_div");
			block("loading_div");
			CallServer("ajax/search_wall.php", str, "POST", true, "mytext",re_search_wall );
		}
	}
</script>