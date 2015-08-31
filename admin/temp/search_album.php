<div>
	<div>
		<table width=100%>
			<tr>
				<td width=15% style="text-align:right"><font>查詢類型：</font></td>
				<td width=30%>
					<select id="search_type" name="search_type" class="form-control">
						<option value="uid"> 會員編號</option>
						<option value="member_name"> 會員暱稱或本名</option>
						<option value="alb_id"> 相簿編號</option>
						<option value="alb_title"> 相簿名稱</option>
					</select>
				</td>
				<td width=15% style="text-align:right"><fnot>查詢值：</fnot></td>
				<td width=30%>
					<input type="text" id="search_value" name="search_value" value="" class="form-control">
				</td>
				<td width=10% style="text-align:center">
					<input type="button" id="search_btn" name="search_btn" value="查詢" class="btn" onclick="search_album();">
				</td>
			</tr>
		</table>
	</div>
	<div id="loading_div" style="display:none"><img src="../include/images/loading.gif"></div>
	<div id="album_list_div" style="display:none"></div>
	<div id="album_div" style="display:none">
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
	//--action
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
	function change_state(alb_id , state){
		$('#loading_Modal').modal({
		  keyboard: false,
		  backdrop: "static"
		});
		var str = "";
		str = "action=change_state&alb_id="+alb_id+"&state="+state;
		CallServer("ajax/search_album.php", str, "POST", true, "mytext",re_change_state );
	}
	//--ALBUM
	function re_get_photo(mytext){
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
			uid="";
			for(n = 0 ; n < 7-arr.uid.length ; ++n)
				uid += "0";
			uid += arr.uid;
			sex = "";
			if(arr.sex=="0")
				sex = "男";
			else
				sex = "女";
			str = "<table class='table' width='100%'><tr><td rowspan='3'><img src='../update/face_photo/"+arr.photo_url+"'></td><td><div id='member_name'>"+arr.name+"("+sex+")</div></td>";
			str += "<td rowspan='3'><select onchange=change_state("+arr.alb_id+",this.value);><option value='0' ";
				if(arr.alb_state=='0')
					str += "selected";
				str +=" > 顯示中</option><option value='1' ";
				if(arr.alb_state=='1')
					str += "selected";
				str += " > 隱藏</option><option value='9'> 刪除</option></td></tr>";
			str += "<tr><td><div id='member_nick'>"+arr.nick+"</div></td></tr><tr><td><div id='member_uid'>"+uid+"</div></td></tr>";
			str += "<tr><td colspan='3'><div id='alb_cover'>"+arr.alb_title+"</div></td></tr>";
			str += "<tr><td colspan='3'><div id='album_photo'>";
			for(var i = 0 ; i < arr.photo.length ; ++i){
				
				str +="<div style='display:inline'><img src='../update/album_s/"+arr.photo[i].alb_id+"/"+arr.photo[i].pho_url+"' style='max-width:300px;'></div>";
			}
			str += "</div></td></tr><tr><td colspan='2'><input type='button' id='cancel_btn' value='取消' class='btn' onclick=none('album_div');block('album_list_div');></td></tr></table>";
			Dd("album_div").innerHTML = str;
		}
		block("album_div");
	}
	function get_photo(alb_id){
		var str = "";
		str = "action=alb_photo&alb_id="+alb_id;
		none("album_list_div");
		block("loading_div");
		CallServer("ajax/search_album.php", str, "POST", true, "mytext",re_get_photo );
	}
	//--LIST
	function re_search_album(mytext){
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
			str = "<table id='album_list_talbe' width=100% class='table'><thead><tr><th width='20%'>會員</th><th width='80%'>相簿</th><th width='10%'>狀態</th></tr></thead><tbody>";
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
				str +="<td><div><img src='../update/album_s/"+arr[i].alb_id+"/"+arr[i].alb_cover+"' style='max-width:300px;' onclick=get_photo('"+arr[i].alb_id+"')></div><div>"+arr[i].alb_title+"</div></td>";
				str +="<td><select onchange=change_state("+arr[i].alb_id+",this.value);><option value='0' ";
				if(arr[i].alb_state=='0')
					str += "selected";
				str +=" > 顯示中</option><option value='1' ";
				if(arr[i].alb_state=='1')
					str += "selected";
				str += " > 隱藏</option><option value='9'> 刪除</option></td></tr>";
			}
			str += "</tbody></table>";
			Dd("album_list_div").innerHTML = str;
		}
		block("album_list_div");
	}
	function search_album(){
		if(Dd("search_type").value=="" || Dd("search_value").value==""){
			alert("搜尋值或條件不得為空");
		}
		else{
			var str = "";
			str = "action=search&search_type="+Dd("search_type").value+"&search_value="+Dd("search_value").value;
			none("album_list_div");
			none("album_div");
			block("loading_div");
			CallServer("ajax/search_album.php", str, "POST", true, "mytext",re_search_album );
		}
	}
</script>