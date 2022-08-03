﻿<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수


$conn = dbconnect($host, $dbid, $dbpass, $dbname);
mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");

$mode = "입력";
$action = "product_insert.php";

if (array_key_exists("Title", $_GET)) {
    $product_id = $_GET["Title"];
    $query =  "select * from Novel where Title = $product_id";
    $res = mysqli_query($conn, $query);
    if($res){
        mysqli_query($conn,"commit");
        s_msg("Query Success");
    }
    else{
        mysqli_query($conn,"rollback");
        s_msg("Query Fail");
    }
    $product = mysqli_fetch_array($res);
    if(!$product) {
        msg("물품이 존재하지 않습니다.");
    }
    $mode = "수정";
    $action = "product_modify.php";
    
    //echo json_encode($product);
}

$manufacturers = array();

$query = "select * from Novel";
$res = mysqli_query($conn, $query);
if($res){
    mysqli_query($conn,"commit");
    s_msg("Query Success");
}
else{
    mysqli_query($conn,"rollback");
    s_msg("Query Fail");
}
while($row = mysqli_fetch_array($res)) {
    $manufacturers[$row['Genre']] = $row['Genre'];
}

$manufacturers[6] = 'romance';
$manufacturers[7] = 'marital art';
echo json_encode($manufacturers);

?>
    <div class="container">
        <form name="product_form" action="<?=$action?>" method="post" class="fullwidth">
            <input type="hidden" name="Title" value="<?=$product['Title']?>"/>
            <h3>작품<?php echo $mode; ?></h3>
            <p>
                <label for="Genre">장르</label>
                <select name="Genre" id="Genre">
                    <option value="-1">선택해 주십시오.</option>
                    <?
                        foreach($manufacturers as $id => $name) {
                            if($id == $product['Genre']){
                                echo "<option value='{$id}' selected>{$name}</option>";
                            } else {
                                echo "<option value='{$id}'>{$name}</option>";
                            }
                        }
                    ?>
                </select>
            </p>
            <p>
                <label for="Title">제목</label>
                <input type="text" placeholder="제목" name="Title" value="<?=$product['Title']?>"/>
            </p>
            <p>
                <label for="product_desc">작가</label>
                <textarea placeholder="작가" id="Nickname" name="Nickname" value="10"><?=$product['Nickname']?></textarea>
          </p>
            <p>
                <label for="price">연재여부</label>
                <input type="text" placeholder="default Publishing" id="Novel_state" name="Novel_state" value="<?=$product['Novel_state']?>" />
            </p>

            <p align="center"><button class="button primary large" onclick="javascript:return validate();"><?=$mode?></button></p>

            <script>
                function validate() {
                    if(document.getElementById("Nickname").value == "-1") {
                        alert ("작가를 선택해 주십시오"); return false;
                    }
                    else if(document.getElementById("Title").value == "") {
                        alert ("제목을 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("Genre").value == "") {
                        alert ("장르를 입력해 주십시오"); return false;
                    }
                    else if(document.getElementById("Novel_state").value == "") {
                        alert ("연재 여부를 입력해 주십시오"); return false;
                    }
                    return true;
                }
            </script>

        </form>
    </div>
<? include("footer.php") ?>
