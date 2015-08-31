<div>
	<div>
		<input type="button" id="no_check_btn" name="no_check_btn" value="尚未確認的檢舉" class="btn btn-primary">
		<table width=100%>
			<tr>
				<td width=15% style="text-align:right"><font>查詢類型：</font></td>
				<td width=30%>
					<select id="search_type" name="search_type" class="form-control">
						<option value="uid"> 會員編號</option>
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
	<div id="report_list_div" style="display:none">
		
	</div>
</div>
<div class="modal fade" id="show_report_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
    	<div class="modal-header">
      	相關檢舉
      </div>
      <div class="modal-body">
      	<div id='show_report_div'></div>
      </div>
      <div class="modal-footer">
	    	<button type="button" class="btn btn-primary" data-dismiss="modal">确定</button>
	    </div>
    </div>
  </div>
</div>
<script>
	function re_show_report(mytext){
		var str = "";
		var arr = new Array();
		arr = JSON.parse(mytext);
		str = "<table class='table' width=100%><tr><td rowspan='3'><img src='../update/face_photo/"+arr.photo_url+"' style='width:100px;'></td>";
		var uid="";
		for(n = 0 ; n < 7-arr.uid.length ; ++n)
			uid += "0";
		uid += arr.uid;
		var sex = "";
		if(arr.sex=="0")
			sex = "男";
		else
			sex = "女";
		str += "<td>"+arr.target.name+"("+sex+")</td><td rowspan='3'>";
		if(arr.rep_type=='album')
			str += "<a href='../photo.php?alb_id="+arr.rep_target+"' target='_blank'><div><img src='../update/album_s/"+arr.rep_target+"/"+arr.target.alb_cover+"' style='width:100px;'></div></a>"+arr.target.alb_title;
		else if(arr.rep_type=='member')
			str += "<a href='../member_data?uid="+arr.target.uid+"' target='_blank'>個人資料頁面</a>";
		else if(arr.rep_type=='wall'){
			str += "<div>"+arr.target.wa_content+"</div>";
			if(isnull(arr.target.wall_photo)!='')
				str += "<div><img src='../update/wall_s/"+arr.target.wall_photo+"' style='width:100px;'></div>";
		}
		str += "</td></tr><tr><td>"+arr.target.nick+"</td></tr><tr><td>"+uid+"</td></tr></table>";
		str += "<table class='table' width=100%><tr><th colspan='3'>檢舉人列表</th></tr>";
		for(var i = 0 ; i < arr.other.length ; ++i){
			str += "<tr><td rowspan='3'><img src='../update/face_photo/"+arr.other[i].photo_url+"' style='width:100px;'></td>";
			uid="";
			for(n = 0 ; n < 7-arr.other[i].uid.length ; ++n)
				uid += "0";
			uid += arr.other[i].uid;
			sex = "";
			if(arr.other[i].sex=="0")
				sex = "男";
			else
				sex = "女";
			str += "<td>"+arr.other[i].name+"("+sex+")</td><td rowspan='3'>"+arr.other[i].note+"</td></tr><tr><td>"+arr.other[i].nick+"</td></tr><tr><td>"+uid+"</td></tr>";
		}
		str += "</table>";
		Dd("show_report_div").innerHTML = str ;
		$('#show_report_Modal').modal('show');
	}
	function show_report(rep_type,rep_target){
		var str = ""
		str = "action=show_report&rep_type="+rep_type+"&rep_target="+rep_target;
		CallServer("ajax/search_report.php", str, "POST", true, "mytext",re_show_report );
	}
	function re_no_check(mytext){
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
			str = "<table id='report_list_talbe' width=100% class='table'><thead><tr><th width='15%'>檢舉人</th><th width='15%'>被檢舉人</th><th width='10%'>類型</th><th width='40%'>畫面</th><th width='10%'>理由</th><th width='10%'>狀態</th></tr></thead><tbody>";
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
				str += "<tr><td><div><img src='../update/face_photo/"+arr[i].photo_url+"' style='width:100px;'></div>"+arr[i].name+"("+sex+")<br>"+arr[i].nick+"<br>"+uid+"</td>";
				
				uid="";
				for(n = 0 ; n < 7-arr[i].target.uid.length ; ++n)
					uid += "0";
				uid += arr[i].target.uid;
				sex = "";
				if(arr[i].target.sex=="0")
					sex = "男";
				else
					sex = "女";
				str += "<td><div><img src='../update/face_photo/"+arr[i].target.photo_url+"' style='width:100px;'></div>"+arr[i].target.name+"("+sex+")<br>"+arr[i].target.nick+"<br>"+uid+"</td>";
				if(arr[i].rep_type == 'member'){
					str += "<td>個人資料</td><td><a href='../member_data?uid="+arr[i].target.uid+"' target='_blank'>個人資料頁面</a></td>";
				}
				else if(arr[i].rep_type == 'album'){
					str += "<td>相簿</td><td><a href='../photo.php?alb_id="+arr[i].rep_target+"' target='_blank'><div><img src='../update/album_s/"+arr[i].rep_target+"/"+arr[i].target.alb_cover+"' style='max-width:380px;'></div></a>"+arr[i].target.alb_title+"</td>";
				}
				else if(arr[i].rep_type == 'wall'){
					str += "<td>塗鴉牆</td><td><div>"+arr[i].target.wa_content+"</div>";
					if(isnull(arr[i].target.wall_photo)!='')
						str += "<div><img src='../update/wall_s/"+arr[i].target.wall_photo+"'></div>";
					str += "</td>";
				}
				else{
					str += "<td colspan='2'>未知錯誤</td>";
				}
				str += "<td>"+arr[i].note;
				if(parseInt(arr[i].other) > 0)
					str += "<a onclick=show_report('"+arr[i].rep_type+"',"+arr[i].rep_target+");>("+arr[i].other+")</a>";
				str += "</td></tr>";
			}
			str += "</tbody></table>";
			Dd("report_list_div").innerHTML = str;
		}
		block("report_list_div");
	}
	
	$('#no_check_btn').click(function(){
		var str = "";
		str = "action=no_check";
		none("report_list_div");
		block("loading_div");
		CallServer("ajax/search_report.php", str, "POST", true, "mytext",re_no_check );
	});
</script>