﻿<?php
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host,$dbid,$dbpass,$dbname);
mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");
$product_id = $_POST['Title'];
$product_name = $_POST['Genre'];
$product_desc = $_POST['Novel_state'];
//$manufacturer_id = $_POST['manufacturer_id'];
//$price = $_POST['price'];

$ret = mysqli_query($conn, "update Novel set Genre = '$product_name', Novel_state = '$product_desc', where Title = $product_id");

if(!$ret)
{   mysqli_query($conn,"rollback");
    msg('Query Error : '.mysqli_error($conn));
}
else
{   mysqli_query($conn,"commit");
    s_msg ('성공적으로 수정 되었습니다');
    echo "<meta http-equiv='refresh' content='0;url=product_list.php'>";
}

?>

