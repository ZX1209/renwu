var collegeName;
var className;
var userName;
var userCode;
var userPassward;
var userInfo;

function createQuestion(code,describes,answers)
{
  /*
  questionNode
    describeNode
      describeTest
    answersNode
      answerNode
        radio name id
        answertext
  */
  var questionNode = document.createElement("div");
  questionNode.setAttribute("class","question");
  questionNode.setAttribute("id",code);

  var describeNode = document.createElement("div");
  describeNode.setAttribute("class","describe");
  describeNode.innerText=describes;

  var answersNode=document.createElement("div");
  answersNode.setAttribute("class","answers");

  var codeArray = new Array("A","B","C","D");

  for(var i=0;i<answers.length;i++)
  {
    //需要加空值判断...
    var tmp_choise=document.createElement("input");
    tmp_choise.setAttribute("type","radio");
    tmp_choise.setAttribute("name",code);
    tmp_choise.setAttribute("id",""+code+codeArray[i]);
    answersNode.append(tmp_choise);
    answersNode.append(codeArray[i]+" : "+answers[i]+"   ");
  }

  questionNode.append(describeNode);
  questionNode.append(answersNode);

  return questionNode;

}


function setTiMu(result)
{
  var questions = document.createElement("div");
  questions.setAttribute("class","questions");

  for(var i=0;i<result.length;i++)
  {
    /*这种调用方式...
    result[i]["题号"];
    result[i]["题目描述"];
    result[i]["选项"];
    */
    var tmpQuestionNode = createQuestion(result[i]["题号"],result[i]["题目描述"],[result[i]["A"],result[i]["B"],result[i]["C"],result[i]["D"]]);
    questions.append(tmpQuestionNode);
  }
  
  $(".main_area").empty();
  $(".main_area").append(questions);

  var result_button=$("<div class='submit_result'><input type='submit' id='result_submit' value='提交' onclick='getResult();' /></div>");
  $(".questions").append(result_button);

}


function start(){
  $.ajax({url:"./getTiMu.php",type:"get",dataType:"json",success:function(result){setTiMu(result);}})

}


function login()
{
  /*
  提取表单值
  */
  collegeName = $("#college_name")[0].value;
  className=$("#class_name")[0].value;
  userName=$("#user_name")[0].value;
  userCode=$("#user_code")[0].value;
  userPassward=$("#user_passward")[0].value;
  
  //做成json格式
  userInfo={"院系":collegeName,"班级":className,"姓名":userName,"学号":userCode,"密码":userPassward};
  //发送
  $.ajax({url:"./login.php",type:"post",data:userInfo,dataType:"json",success:function(result){
    if(result["status"] =="OK")
      {
        start();
      }
    }});

  //等待回应跳转...
  






}


function showResult(result)
{

  $("<table class='user_info'><tr><td>院系:<p>tmp</p></td><td>班级<p>tmp</p></td><td>学号<p>tmp</p></td><td>姓名<p>tmp</p></td></tr></table>");
}


function getResult()
{
  //取得全部的选项节点
  var answerList=$(".questions .question .answers").children();
  //筛选出被选中的选项
  answerList=answerList.filter(":checked");

  var answersArray = [];

  for(var i=0;i<answerList.length;i++)
  {
    //被checked的radio,,的id就是题号加答案
    var tmpStr=answerList[i].id;
    var strLen=tmpStr.length;
    var tmpTiHao=tmpStr.substr(0,strLen-1);
    var tmpDaAn=tmpStr.substr(strLen-1,strLen);

    var tmpAnswer ={"题号":tmpTiHao,"答案":tmpDaAn};

    answersArray.push(tmpAnswer);
  }
  //加入json列表
  var jsonAnswers = {};
  jsonAnswers["回答"]=answersArray;
  jsonAnswers["用户"]=userInfo;

  //传值
  $.ajax({url:"./getResult.php",type:"post",data:jsonAnswers,success:function(result){alert(result);}})
  //获取结果并显示


}







function test(){
  var question_code=2017;
  var questino_describe = "“爱国教战”，“崇尚武德”是属于：（     ）";
  var answers_describe=["国防指导思想","国防建设思想 ","国防教育思想","国防斗争思想"];

  var questions = document.createElement("div");
  questions.setAttribute("class","questions")

  var question = document.createElement("div");
  question.setAttribute("class","question");
  question.setAttribute("id",question_code);

  var describe = document.createElement("div");
  describe.setAttribute("class","describe");
  describe.innerText=questino_describe;

  var answers=document.createElement("div");
  answers.setAttribute("class","answers");

  for(var i=0;i<answers_describe.length;i++)
  {
    var tmp_choise=document.createElement("input");
    tmp_choise.setAttribute("type","radio");
    answers.append(tmp_choise);
    answers.append(answers_describe[i]);
  }

  question.append(describe);
  question.append(answers);

  questions.append(question);
  $(".main_area").empty();
  $(".main_area").append(questions);

   // 开始写 jQuery 代码...
 
}