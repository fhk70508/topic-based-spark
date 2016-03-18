<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

<meta name="viewport" content="width=divice-width; initial-scale=1">
<title></title>
<style type="text/css">
body{
background: url("background.jpg") no-repeat;
}

</style>
<script language="javascript">
function more(){
    nt = document.getElementById('tab').insertRow(document.getElementById('tab').rows.length-1)
    tn = nt.insertCell(0);
    tt = nt.insertCell(1);
    ta = nt.insertCell(2);
    tdl= nt.insertCell(3);
  
    tn.innerHTML = "<select name='title[]'><option value='表演活動'>表演活動</option><option value='展覽活動'>展覽活動</option><option value='電影欣賞'>電影欣賞</option><option value='其他活動'>其他活動</option><option value='研習活動'>研習活動</option><option value='經典講座'>經典講座</option></select>";
    tt.innerHTML = "<select name='ticket[]'><option value='免費'>免費</option><option value='售票'>售票</option><option value='索票'>索票</option></select>";
    ta.innerHTML = "<input type = 'date' name = 'OrderDate' />";   
    tdl.innerHTML = "<input type='checkbox' name='del' id='del' /><label for='del'></label>";
   
}
function $(objId){ 
return document.getElementById(objId); 
} 
function del_tbl(tblN,ckN){ 
var ck = document.getElementsByName(ckN); 
var tab = $(tblN); 
var rowIndex; 
for(var i=0;i<ck.length;i++){ 
if(ck[i].checked){ 
rowIndex = ck[i].parentNode.parentNode.sectionRowIndex; 
tab.deleteRow(rowIndex); 
i = -1; 
} } 
}
</script>
</head>
<body>
<div id="main" style="
  position: absolute;
  left: 50%; 
  margin-left:-135px;
  top: 50%;
  margin-top: -280px;">

<form Action = 'sox_ajax.php' Method = 'POST'>
<input type="hidden" name="name" value="<?php echo $_POST['name'];?>" id='name'/><br><br>
<input type="hidden" name="mail" value="<?php echo $_POST['mail'] ?: 'isnot@aaa.com';?>" id = 'mail'/><br>
<h3>編輯定閱資訊</h3>
<table  id="tab" border="1" cellpadding="5" cellspacing="1">
<tr align="center"><td>主題</td><td>消費</td><td>日期</td><td>選取</td></tr>
<tr >
<td>
<select name='title[]'><option value='表演活動'>表演活動</option><option value='展覽活動'>展覽活動</option><option value='電影欣賞'>電影欣賞</option><option value='其他活動'>其他活動</option><option value='研習活動'>研習活動</option><option value='經典講座'>經典講座</option></select>
</td>
<td>
<select name='ticket[]'><option value='免費'>免費</option><option value='售票'>售票</option><option value='索票'>索票</option></select>
</td>
<td>
 <input type = 'date' name = 'OrderDate' /> 
</td>
<td>
 <input type='checkbox' name='del' id='del'/><label for="del"></label>
</td>
</tr>
<tr align="center"><td colspan="3"><input type="submit" value="送出" /> | <input type="button" value="更多" onclick="more();" />
| <input type="button" name="btn_del" id="btn_del" value="刪 除" onclick="del_tbl('tab','del')"></td></tr>
</table>
</form>
</div>
</body>
</html>
