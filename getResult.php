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

$conn=connect_mysql();

//判断答案是否正确
$isin = "SELECT `学号` FROM `testDB`.`YonHu` WHERE `学号` = '${学号}' AND `密码` = '${密码};' ";


explode("-",$str);

$result++;



?>