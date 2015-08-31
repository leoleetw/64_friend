<?
	include_once("../include/dbinclude.php");
?>
<!DOCTYPE html>
<html lang="tw">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>交友網後台管理系統</title>

    <!-- Bootstrap Core CSS -->
    <link href="../include/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../include/css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../include/css/admin_style.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../include/font-awesome-4.2.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    
		<script src="../include/js/jquery-1.11.0.js"></script>
		<script src="../include/js/plugins/metisMenu/metisMenu.min.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="../include/js/bootstrap.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
		<link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <!-- Custom Theme JavaScript -->
    <script src="../include/js/admin.js"></script>
    <script src="../include/js/ajax.js"></script>
</head>

<body>
	<div id="wrapper">
		<?php include_once('nav.php');?>
		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<!--h1 class="page-header">首頁</h1-->
					<p> </p>
					<table width="100%">
						<thead><th>編號</th><th>帳號</th><th>暱稱</th><th>狀態</th><th>動作</th></thead><tbody>
					<?
						$sql = "select a.* ,b.state , c.acc from member_check a , member b , user c where a.u_id = b.u_id AND a.u_id = c.u_id AND (b.state != '2' && b.state != '0');";			
						$result = mysqli_query($sqli,$sql);
						while($row = mysqli_fetch_array($result)){
					?>
						<tr>
							<td><? echo $row["u_id"]; ?></td><td><? echo $row["acc"]; ?></td><td><? echo $row["name"]; ?></td>
							<td><? if($row["state"]==1){echo "尚未進行審核!";} else if($row["state"]=="3"){echo "審核不通過";}?></td>
							<td>
								<input type="button" id="pass_btn" name="pass_btn" value="通過" onclick="pass_member(<? echo $row["u_id"]; ?>,this);">
								<input type="button" id="fail_btn" name="fail_btn" value="不通過" onclick="fail_member(<? echo $row["u_id"]; ?>,this);">
							</td>
						</tr>
					<?
						}
					?>
					</tbody></table>
				</div>
			</div>
			
		</div>
		
	</div>
	<?php include_once('footer.php');?>
		
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
		function re_fail_member(mytext){
			var arr = mytext.split("|");
			if(arr[0]=="1"){
				alert(arr[1]);
			}
			else if(arr[0]=="0"){
				Dd("myTable").deleteRow(arr[1]);
				alert("會員資料審核失敗成功!");
			}
			else{
				alert(mytext);
			}
		}
		function fail_member(u_id , r){
			var i = r.parentNode.parentNode.rowIndex;
			str = "action=fail&u_id="+u_id+"&row_index="+i;
			CallServer("ajax/member_check.php", str, "POST", true, "mytext",re_fail_member );
		}
		function re_pass_member(mytext){
			var arr = mytext.split("|");
			if(arr[0]=="1"){
				alert(arr[1]);
			}
			else if(arr[0]=="0"){
				Dd("myTable").deleteRow(arr[1]);
				alert("會員資料審核通過成功!");
			}
			else{
				alert(mytext);
			}
		}
		function pass_member(u_id , r){
			var i = r.parentNode.parentNode.rowIndex;
			str = "action=pass&u_id="+u_id+"&row_index="+i;
			CallServer("ajax/member_check.php", str, "POST", true, "mytext",re_pass_member );
		}
		function show_down(this_type,this_name){
			Dd("down_name").value=this_name;
			str = "action=show_down&type="+this_type;
			CallServer("ajax/code_input.php", str, "POST", true, "mytext",re_show_down );
		}
	</script>
</body>

</html>

