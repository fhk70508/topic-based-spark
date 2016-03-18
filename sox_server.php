<?php
//設定沒有時間限制，不會time out
set_time_limit(0);

// 建立 socket
$socket = socket_create(AF_INET, SOCK_STREAM, 0) or die("無法建立socket");
$socketend = @socket_create_listen("1234");
//設定Server IP及1234 port

// 綁定 socket
$result = socket_bind($socket, "localhost", 12345) or die("沒有辦法綁定socket");

//接收Client連線

$connection = socket_accept($socketend);

// start listening for connections 第一個是監聽通道
$result = socket_listen($socket, 3) or die("無法設定socket監聽器");
while(true){
// accept incoming connections
// spawn another socket to handle communication 另一個通道來做通訊處理
$spawn = socket_accept($socket) or die("Could not accept incoming connection");

// read client input 獲取client資訊
$input = socket_read($spawn, 1024) or die("無法讀取input");
print($input . "\n");
    //將資料寫入到socket暫存
    socket_write($connection,$input . "\n");
//    sleep(1.5);
//socket_write($connection,"east,west'food,teavel'2015-03-16,user1,ip1'\n");


}
// close sockets 既然永遠在連線工作，也不用關閉了
//socket_close($spawn);
//socket_close($socket);

?>
