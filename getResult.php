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
$result=0;

//获取 post 的登陆信息
//并转换成json格式
//还是要注意下注入问题..
switch($_SERVER['REQUEST_METHOD'] ) {
        case 'POST':
            $input = file_get_contents("php://input");
            if($temp_input = json_decode($input,true)){
                $input = $temp_input;
            }else {
                $input = $_POST;//解决注意事项里的问题
            }
            //测试可行
            //print_r($input);// 这里测试下输出
            break;
        default:
            $input = $_GET;
    }

$院系=$input["用户"]["院系"];
$班级=$input["用户"]["班级"];
$姓名=$input["用户"]["姓名"];
$学号=$input["用户"]["学号"];
$密码=$input["用户"]["密码"];


$conn=connect_mysql();

$arraylen=count($input["回答"]);

for($i=0;$i<$arraylen;$i++)
{
  //$input["回答"][$i]["题号"];
  //$input["回答"][$i]["答案"];

  //判断答案是否正确
  $iscorrect = "SELECT `题号` FROM `testDB`.`TiMu` WHERE `题号` = '" . $input["回答"][$i]["题号"]."' AND `正答` = '" . $input["回答"][$i]["答案"] . "'; ";

  $qresult=$conn->query($iscorrect);

  if($qresult->num_rows==1)
  {
    $result++;
  }

}

' ".$院系 ."', '".$班级 ."', '".$学号 ."', '".$姓名 ."',
`院系`, `班级`, `学号`, `姓名`,

$update ="UPDATE `testDB`.`YonHu` SET `成绩` = ' ". $result ." ' , `提交时间` = now() WHERE `院系`='". $院系 ." ' AND `班级`=' ". $班级 ." ' AND `学号`=' ". $学号 ." ' AND `姓名`=' ". $姓名 ." ';"

$conn->query($update);

$response = ["成绩"=>$result];

echo json_encode($response,JSON_UNESCAPED_UNICODE);

$conn->close();

?>