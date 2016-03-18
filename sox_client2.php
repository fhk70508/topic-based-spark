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
 input[type=checkbox]{
 display:none;
}
input[id=del1] + label
{
background: url("del1.jpg") no-repeat;
height: 86px;
width: 86px;
display:inline-block;
padding: 0 0 0 0px;
}
input[id=del1]:checked + label
{
background: url("del2.jpg") no-repeat;
height: 86px;
width: 86px;
display:inline-block;
padding: 0 0 0 0px;
}
input[id=del2] + label
{
background: url("del1.jpg") no-repeat;
height: 86px;
width: 86px;
display:inline-block;
padding: 0 0 0 0px;
}
input[id=del2]:checked + label
{
background: url("del2.jpg") no-repeat;
height: 86px;
width: 86px;
display:inline-block;
padding: 0 0 0 0px;
}
</style>
</head>
<body>
<div id="main" style="
  position: absolute;
  left: 50%; 
  margin-left:-135px;
  top: 50%;
  margin-top: -280px;">
<form Action = 'sox_ajax.php' Method = 'POST'>
<input type="hidden" name="name" value="<?php echo $_POST['name'];?>" id=name/><br><br>
<input type="hidden" name="mail" value="<?php echo $_POST['mail'] ?: 'isnot@aaa.com';?>" id = mail/><br>
<h3>主題選擇</h3>
	<input type="checkbox" name="title[]" value="表演活動" id="topic1"><label for="topic1"></label>
	<input type="checkbox" name="title[]" value="展覽活動" id="topic2"><label for="topic2"></label>
	<input type="checkbox" name="title[]" value="電影欣賞" id="topic3"><label for="topic3"></label>
<br>
	<input type="checkbox" name="title[]" value="其他活動" id="topic4"><label for="topic4"></label>
	<input type="checkbox" name="title[]" value="研習活動" id="topic5"><label for="topic5"></label>
	<input type="checkbox" name="title[]" value="經典講座" id="topic6"><label for="topic6"></label>
<br>
<h3>門票選擇</h3>
	<input type="checkbox" name="ticket[]" value="免費" id="ticket7"><label for="ticket7"></label>
	<input type="checkbox" name="ticket[]" value="售票" id="ticket8"><label for="ticket8"></label>
	<input type="checkbox" name="ticket[]" value="索票" id="ticket9"><label for="ticket9"></label>
<br><br>
<input type="submit" name="action" value="送出" >
<input type="submit" name="action" value="取消訂閱" >
</form>
</div>
</body>
</html>
