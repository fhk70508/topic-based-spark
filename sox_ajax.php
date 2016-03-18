<?php
header('Content-type: text/html; charset=utf-8');


//接收來自sox_client.php的資訊

$name = $_POST["name"];
$mail = $_POST["mail"];

if ($_POST['action'] == '送出') {
$title = $_POST["title"];
$mytitle = implode(",",$title);

$ticket = $_POST["ticket"];
$myticket = implode(",",$ticket);


$myall = $mytitle . "'" . $myticket . "'" . $name . "," . $mail;

}
else{
$myall = "'" . "'" . $name . "," . $mail;

}
//準備socket工作了
$host = "localhost";
$port = 12345;

// 創建 socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("Could not create socket\n");

// 連結到server
$con = socket_connect($socket, $host, $port) or die("Can't Connect!");

//之前debug確認用:if($con) echo "太帥了吧！成功建立連線了!!" ;

// 送出資訊給 server
socket_write($socket, $myall, strlen($myall)) or die("Could not send data to server\n");
// 關閉 socket
socket_close($socket);
if ($_POST['action'] == '送出') {
echo "<script>
alert('傳送完成');
history.back();
</script>";
}
else{
echo "<script>alert('傳送完成');</script>";
header("location:sox_client.php");
}
?>
