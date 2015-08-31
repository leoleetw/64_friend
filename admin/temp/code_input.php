<div class="col-lg-6">
	<input type="button" id="add_top" name="add_top" value="新建" onclick="Dd('code_form_up').reset();$('#top_Modal').modal('show');Dd('top_action').value='top_add';">
	
	<!--input type="button" id="seq_top" name="seq_top" value="排序"-->
	<table id="" class="table">
		<thead><tr><th>type</th><th>name</th><th>動作</th></tr></thead>
		<tbody>
		<?
			$sql = "select DISTINCT type from code order by id";
			$result = mysqli_query($sqli,$sql);
			while($row = mysqli_fetch_array($result)){
				echo "<tr ><td><a href=# onclick=show_down('".$row["type"]."','".$row["name"]."');>".$row["type"]."</a></td><td>".$row["name"]."</td><td>
				<input type='button' id='update_top' name='update_top' value='修改' onclick=$('#top_Modal').modal('show');Dd('top_action').value='top_update';Dd('top_id').value='".$row["id"]."';Dd('top_type').value='".$row["type"]."';Dd('top_name').value='".$row["name"]."';>
				<input type='button' id='delete_top' name='delete_top' value='刪除'></td></tr>";
			}
		?>
		</tbody>
	</table>
</div>
<div class="col-lg-6">
	<div id="down_div" style="display:none">
		<input type="button" id="add_down" name="add_down" value="新建" onclick="$('#down_Modal').modal('show');Dd('down_action').value='down_add';">
		<input type="button" id="update_top" name="update_top" value="修改">
		<input type="button" id="delete_top" name="delete_top" value="刪除">
		<input type="button" id="seq_top" name="seq_top" value="排序">
		<table id="down_table" class="table">
			<thead><tr><th>type</th><th>name</th><th>value</th><th>seq</th></tr></thead>
			<tbody>
			</tbody>
		</table>
	</div>
</div>
<form id='code_form_up' action='ajax/code.php' method="post">
	<div class="modal fade" id="top_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">新增項目</h4>
	      </div>
	      <div class="modal-body">
	        <table width="100%">
	        	<tr>
	        		<td width="18%" align="right">type(英文)：</td>
	        		<td width="90%">
	        			<div id="top_type_div" class="form-group">
	        				<input type="hidden" id="top_id" name="top_id" value="">
	        				<input type="text" id="top_type" name="top_type" value="" class="form-control" style="width:60%;display:inline;">
	        			</div>
	        		</td>
	        	</tr>
	        	<tr>
	        		<td align="right">name(中文)：</td>
	        		<td>
	        			<div id="top_name_div" class="form-group">
	        				<input type="text" id="top_name" name="top_name" value="" class="form-control" style="width:60%;display:inline;">
	        			</div>
	        		</td>
	        	</tr>
	        </table>
	        <input type="hidden" id="top_action" name="top_action" value="" >
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" onclick="top_update();">確定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>

<form id='code_form_down' action='ajax/code.php' method="post">
	<div class="modal fade" id="down_Modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">新增項目</h4>
	      </div>
	      <div class="modal-body">
	        <table width="100%">
	        	<tr>
	        		<td align="right">name(中文)：</td>
	        		<td>
	        			<div id="down_names_div" class="form-group">
	        				<input type="hidden" id="down_type" name="down_type" value="">
	        				<input type="text" id="down_name" name="down_name" value="" class="form-control" style="width:60%;display:inline;" readonly>
	        			</div>
	        		</td>
	        	</tr>
	        	<tr>
	        		<td align="right">value(顯示值)：</td>
	        		<td>
	        			<div id="down_value_div" class="form-group">
	        				<input type="text" id="down_value" name="down_value" value="" class="form-control" style="width:60%;display:inline;">
	        			</div>
	        		</td>
	        	</tr>
	        </table>
	        <input type="hidden" id="down_action" name="down_action" value="" >
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="button" class="btn btn-primary" onclick="down_update();">確定</button>
	      </div>
	    </div>
	  </div>
	</div>
</form>
<script>
	function re_top_update(mytext){
		var arr = new Array();
		arr = mytext.split("|");
		if(arr[0]=="0")
			history.go(0);
		else
			alert(arr[1]);
	}
	function top_update(){
		var str = "";
		if(Dd("top_action").value=="top_add"){
			str = "action="+Dd("top_action").value+"&type="+Dd("top_type").value+"&name="+Dd("top_name").value;
			CallServer("ajax/code_input.php", str, "POST", true, "mytext",re_top_update );
		}
		else if(Dd("top_action").value=="top_update"){
			str = "action="+Dd("top_action").value+"&id="+Dd("top_id").value+"&type="+Dd("top_type").value+"&name="+Dd("top_name").value;
			CallServer("ajax/code_input.php", str, "POST", true, "mytext",re_top_update );
		}
	}
	function re_show_down(mytext){
		var arr = new Array();
		arr = JSON.parse(mytext);
		var str = "";
		if(arr.length == 0){
			alert("查無資料");
			
		}
		else{
			str = "<thead><tr><th>name</th><th>value</th><th>seq</th><th>動作</th></tr></thead><tbody>";
			for(var i = 0 ; i < arr.length ; ++i){
				str +="<tr>";
				str +="<td>"+arr[i].name+"</td>";
				str +="<td>"+arr[i].value+"</td>";
				str +="<td>"+arr[i].seq+"</td>";
				str +="<td><input type='button' id='update_down' name='update_down' value='修改' onclick=$('#down_Modal').modal('show');Dd('down_action').value='down_update';Dd('down_id').value='"+arr[i].id+"';Dd('down_name').value='"+arr[i].name+"';Dd('down_value').value='"+arr[i].value+"';</td></tr>";
			}
			str += "</tbody>";
			Dd("down_table").innerHTML = str;
		}
		block("down_div");
	}
	function show_down(this_type,this_name){
		Dd("down_name").value=this_name;
		str = "action=show_down&type="+this_type;
		CallServer("ajax/code_input.php", str, "POST", true, "mytext",re_show_down );
	}
</script>