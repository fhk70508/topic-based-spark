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
</head>
<body>
<div id="main" style="
  position: absolute;
  left: 50%; 
  margin-left:-150px;
  top: 50%;
  margin-top: -100px;
  width: 300px;
  height: 200px;">
<form Action = 'sox_client.php' Method = 'POST'>
<h3>使用者登入</h3>
	Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: <input type="text" name="name" width/><br><br><br>
	Password : <input type="password" name="password" /><br><br><br><br>

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" value="送出" >
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<input type="button" value="註冊" onclick="location.href='member.php'">
</form>
</div>

</body>
</html>
