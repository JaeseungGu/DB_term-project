﻿<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수


$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");
$product_name = $_POST['Genre'];
$product_desc = $_POST['Title'];
$manufacturer_id = $_POST['Nickname'];
$price = $_POST['Novel_state'];

echo "insert into Novel (Genre, Title,  Novel_state) values('$product_name', '$product_desc', '$price')";
//echo "insert into Writer (Nickname,Writer_Email, Phone, Contract_end, Employ_ID) values('$manufacturer_id','ewWriter@korea.ac.kr',01011111111,2022-09-09,240339)";
$ret = mysqli_query($conn, "insert into Novel (Genre, Title,  Novel_state, Star_average, Number_of_view, Nickname) values('$product_name', '$product_desc', '$price',0,0,'$manufacturer_id')");
//$ret2 = mysqli_query($conn,"echo insert into Writer (Nickname,Writer_Email, Phone, Contract_end, Employ_ID) values('$manufacturer_id','ewWriter@korea.ac.kr',01011111111,2022-09-09,240339)");
if(!$ret)
{
	mysqli_query($conn,"rollback");
    echo mysqli_error($conn);
    msg('Query Error : '.mysqli_error($conn));
}
else
{
    mysqli_query($conn,"commit");
    s_msg ('성공적으로 입력 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=product_list.php'>";
}

?>


