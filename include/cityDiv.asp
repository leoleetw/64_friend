<?xml version="1.0"  encoding="big5" ?>
<divList>
<?php
response.buffer =true
response.expires=-1
set conn=server.createobject("ADODB.Connection")
conn.Provider="sqloledb"
conn.open "server="&session("server")&";uid="&session("uid")&";pwd="&session("pwd")&";database="&session("database")
	cityCode = request("cityCode")
	sql = "SELECT mCode, mValue FROM CodeCity WHERE codeMetaID='" & cityCode & "'"
	set RS1 = conn.execute(sql)
	while not RS1.eof
		echo "<row><mCode>" & RS1("mCode") & "</mCode><mValue>" & RS1("mValue") & "</mValue></row>" & vbCRLF
		RS1.moveNext
	wend
	
sub retrieveByXML
	set rptXmlDoc = Server.CreateObject("MICROSOFT.XMLDOM")
	rptXmlDoc.async = false
	rptXmlDoc.setProperty("ServerHTTPRequest") = true	
	
	LoadXML = server.MapPath(".") & "\dsd.xml"
'	debugPrint LoadXML & "<HR>"
	xv = rptXmlDoc.load(LoadXML)
	
  if rptXmlDoc.parseError.reason <> "" then 
    echo("XML parseError on line " &  rptXmlDoc.parseError.line)
    echo("<BR>Reason: " &  rptXmlDoc.parseError.reason)
    Response.End()
  end if

  	set optionList = rptXmlDoc.selectNodes("//dsTable[tableName='CodeMain']/instance/row[codeMetaID='"&cityCode&"']")
  	for each opItem in optionList
'  		echo "<divItem><mCode>" & opItem.selectSingleNode("mCode")
		echo opItem.xml
  	next
'	response.ContentType = "text/xml"
'	XMlDoc2.save(Response)	
'	echo 	rptXmlDoc.transformNode(xslDom)
'	response.end
end sub
?>
</divList>