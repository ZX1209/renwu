<?php
function connect_mysql(){
    //登陆数据库并
  $servername = "localhost";
  $username = "test2";
  $password = "TESTINININ";
  $dbname = "testDB";

  // 创建连接
  $success_connect = new mysqli($servername, $username, $password, $dbname);
  // 检测连接
  if ($success_connect->connect_error) {
      die("连接失败: " . $success_connect->connect_error);
  } 
  $success_connect->set_charset("utf8");

  return $success_connect;

}

function utf8init()
{
    // Tell PHP that we're using UTF-8 strings until the end of the script
  mb_internal_encoding('UTF-8');

  // Tell PHP that we'll be outputting UTF-8 to the browser
  mb_http_output('UTF-8');

  //$str = json_encode($arr, JSON_UNESCAPED_UNICODE);   //这样我们存进去的是就是中文了,那么取出的也就是中文了

}

utf8init();

$conn=connect_mysql();


//将五类分别20道题放进questions中
$questions = array();

for($i=1;$i<=5;$i++)
{
  for($j=0;$j<20;$j++)
  {
    $selectTiMu = "SELECT * FROM `testDB`.`TiMu`  WHERE `题号` = '".$i."_". (random_int(1,20)+20*$j) ."';";

    $result=$conn->query($selectTiMu);
    if ($result->num_rows > 0)
    {
      // 输出数据
      while($row = $result->fetch_assoc())
      {
        array_push($questions,$row);
      }
    }
  }
}

echo json_encode($questions,JSON_UNESCAPED_UNICODE);



$conn->close();

?>