<?php
session_start();
mb_internal_encoding('utf-8');
include_once("database.ini.php");
function getip(){
    $ipaddress = '';
    if (!empty($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(!empty($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(!empty($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function encrypt($str){
	return md5(crypt($str,$str)); 
}
function RandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}
function mysqldate($mytext){
	$arr=Array();
	$arr=explode(" ",$mytext);
	$arr[0] = str_replace("-", "/" ,$arr[0]);
	//echo $arr[0];
	return $arr[0];
}
function mysqldatetime($mytext){
	$arr=Array();
	$arr=explode(".",$mytext);
	//echo $arr[0];
	return $arr[0];
}
function mysqltime($mytext){
	$arr=Array();
	$str=Array();
	$arr=explode(".",$mytext);
	$str=explode(" ",$arr[0]);
	//echo $str[1];
	return $str[1];
}
function dateDiff($startDate, $endDate) {
  $startArry = getdate(strtotime($startDate));
  $endArry = getdate(strtotime($endDate));
  $start_date = gregoriantojd($startArry["mon"], $startArry["mday"], $startArry["year"]);
  $end_date = gregoriantojd($endArry["mon"], $endArry["mday"], $endArry["year"]);

  return round(($end_date - $start_date), 0);
}
function minDiff($startTime, $endTime) {
    $start = strtotime($startTime);
    $end = strtotime($endTime);
    $timeDiff = $end - $start;
    return floor($timeDiff / 60);
}
function QuerySQL ($sql){
	global $sqli;
	$array = Array();
	$result = mysqli_query($sqli,$sql);
	for($i = 0 ; $i < $row = mysqli_fetch_array($result) ; ++$i){
		$array[$i] = $row;
	}
	return $array;
}

function instr($Str_Sourec,$Str_Target){ 
  if($Str_Sourec == "" || $Str_Target == ""){ 
      return -1; 
  }else{ 
      $StrTo = strpos($Str_Sourec,$Str_Target); 
      if($StrTo >= 0){ 
          return $StrTo; 
      }else{ 
          return -1; 
      } 
  } 
}
function checkFun($data,$data1){
	if(instr($data1,$data) > 0){ 
		return "checked";
	}
}
function CheckSubmitJ ($SubmitType){
	echo "document.form.action.value='".$SubmitType."';" . Chr(13) . Chr(10);
  echo "document.form.submit();" . Chr(13) . Chr(10);
}
function CheckEmailJ ($FName){
  echo "if(document.form." . $FName . ".value.indexOf('@')==-1||document.form." . $FName . ".value.indexOf('.')==-1){" . Chr(13) . Chr(10);
  echo "  alert('您輸入的電子郵件不合法！');" . Chr(13) . Chr(10);
  echo "  document.form." . $FName . ".focus();" . Chr(13) . Chr(10);
  echo "  return;" . Chr(13) . Chr(10);
  echo "}" . Chr(13) . Chr(10);
}
Function Checklen($FName,$CLength,$ListField){              //'檢測中英文夾雜字串實際長度
    echo "x = form." . $FName . ".value;" . Chr(13) . Chr(10);
    echo "if (x.length > " . $CLength . "){" . Chr(13) . Chr(10);
    echo "   alert( ". Chr(34) . $ListField . " 欄位長度超過限制 !".Chr(34) .");". Chr(13) . Chr(10);
    echo "   form." . $FName .".focus(); " . Chr(13) . Chr(10);
    echo "   return; " . Chr(13) . Chr(10);
    echo "} " . Chr(13) . Chr(10);
}
function ChecklenJ($FName,$CLength,$ListField){//檢測中英文夾雜字串實際長度
  echo "var cnt=0;" . Chr(13) . Chr(10) ;
  echo "var sName=document.form." . $FName . ".value" . Chr(13) . Chr(10);
  echo "for(var i=0;i<sName.length;i++ ){" . Chr(13) . Chr(10);
  echo "  if (escape(sName.charAt(i)).length >= 4) cnt+=2;" . Chr(13) . Chr(10)   ;
  echo "  else cnt++;" . Chr(13) . Chr(10);
  echo "}" . Chr(13) . Chr(10);
  echo "if(cnt>" . $CLength . "){" . Chr(13) . Chr(10);
  echo "  alert('". $ListField . "  欄位長度超過限制！');" . Chr(13) . Chr(10);
  echo "  return;" . Chr(13) . Chr(10);
  echo "}" . Chr(13) . Chr(10);
}

Function CheckSubmit($SubmitType){
  echo "document.form.action.value='".$SubmitType."';" . Chr(13) . Chr(10);
  echo "document.form.submit();" . Chr(13) . Chr(10);
}
Function CheckString ($FName,$ListField){
    echo "if(form." . $FName . ".value==".Chr(34).Chr(34)."){ " . Chr(13) . Chr(10);
    echo "   alert( ". Chr(34) . $ListField . " 欄位不可為空白 !" . Chr(34) .");" . Chr(13) . Chr(10);
    echo "   form." . $FName .".focus(); " . Chr(13) . Chr(10);
    echo "return;}   " . Chr(13) . Chr(10);
}
Function CheckNumber ($FName,$ListField){
    echo "if (isNaN(form." . $FName . ".value)) { " . Chr(13) . Chr(10);
    echo "   alert( ". Chr(34) . $ListField . " 欄位必須為數字 !".Chr(34) .");". Chr(13) . Chr(10);
    echo "   form." . $FName .".focus " . Chr(13) . Chr(10);
    echo "   return; " . Chr(13) . Chr(10);
    echo "} " . Chr(13) . Chr(10);
}
Function CheckContentJ ($FName,$ListField){
  echo "var content=document.form." . $FName . ".value.toLowerCase();" . Chr(13) . Chr(10);
  echo "var AryKey = new Array('script','Iframe','a href','url','drop','create','delete','table','','1=1','--',';');" . Chr(13) . Chr(10) ; 
  echo "for(var i=0;i<=AryKey.length-1;i++){" . Chr(13) . Chr(10);
  echo "  if(content.indexOf(AryKey[i])!=-1){" . Chr(13) . Chr(10);
  echo "    alert('". $ListField . "  欄位請勿輸入 '+AryKey[i]+'  保留字元！');" . Chr(13) . Chr(10);
  echo "    return;" . Chr(13) . Chr(10);
  echo "  }" . Chr(13) . Chr(10);
  echo "}" . Chr(13) . Chr(10);
}
Function CheckDate1 ($FName,$ListField){
    echo "if(form." . $FName . ".value!=".Chr(34).Chr(34)."){ " . Chr(13) . Chr(10);
    echo "	var newdate = new date(form." . $FName . ".value);". Chr(10);
    echo "	if(!IsNaN(newdate) || (form." . $FName . ".value.substr(0,1)!=".Chr(34)."2".Chr(34)." && form." . $FName . ".value.substr(0,1)!=".Chr(34)."1".Chr(34).")){ " . Chr(13) . Chr(10);
    echo "		alert( ". Chr(34) . $ListField . " 欄位必須為西元日期格式 ! yyyy-mm-dd".Chr(34) .");" .Chr(13) . Chr(10);
    echo "		form." . $FName .".focus(); " . Chr(13) . Chr(10);
    echo "		return; " . Chr(13) . Chr(10);
    echo "	} " . Chr(13) . Chr(10);
    echo "} " . Chr(13) . Chr(10);
}

function Message(){
    if($_SESSION["errnumber"]==0)
       echo "<center>".$_SESSION["msg"]."</center>";
    else{
       echo "<script> alert('" .$_SESSION["msg"]."')";
       echo "</script>";
    }
    $_SESSION["msg"]="";
    $_SESSION["errnumber"]=0;
}
?>