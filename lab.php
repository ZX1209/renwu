<?php
// Tell PHP that we're using UTF-8 strings until the end of the script
mb_internal_encoding('UTF-8');

// Tell PHP that we'll be outputting UTF-8 to the browser
mb_http_output('UTF-8');

$str = json_encode($arr, JSON_UNESCAPED_UNICODE);   //这样我们存进去的是就是中文了,那么取出的也就是中文了


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

//登陆数据库并
$servername = "localhost";
$username = "test2";
$password = "TESTINININ";
$dbname = "testDB";

// 创建连接
$conn = new mysqli($servername, $username, $password, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
} 

$conn->set_charset("utf8");

$sql = "INSERT INTO MyGuests (firstname, lastname, email)
VALUES ('John', 'Doe', 'john@example.com');";

if ($conn->query($sql) === TRUE) {
    echo "新记录插入成功";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>