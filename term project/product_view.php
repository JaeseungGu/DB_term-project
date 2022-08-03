﻿<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수

$conn = dbconnect($host, $dbid, $dbpass, $dbname);

mysqli_query( $conn, "set autocommit = 0");
mysqli_query( $conn, "set session transaction isolation level serializable");
mysqli_query( $conn, "start transaction");
if (array_key_exists("Title", $_GET)) {
    $Title =$_Get["Title"];
    $query = "select * from Novel natural join Writer where Title = $Title";
    $res = mysqli_query($conn, $query);
    if(!$res){
        mysqli_query($conn,"rollback");
        s_msg("데이터 베이스 접근 실패");
    }
    else{
        mysqli_query($conn,"commit");
        s_msg("데이터베이스 접근 성공");
    }
    $Novel = mysqli_fetch_assoc($res);
    if (!$Novel) {
        msg("작품이 존재하지 않습니다.");
    }
}
?>
    <div class="container fullwidth">

        <h3>작품 정보 상세 보기 </h3>

        <p>
            <label for="Title">작품 제목</label> 
            <input readonly type="text" id="Title" name="Title" value="<?= $Novel['Title'] ?>"/>
        </p>

        <p>
            <label for="Writer">작가</label>
            <input readonly type="text" id="Writer" name="Writer" value="<?= $Novel['Nickname'] ?>"/>
        </p>

        <p>
            <label for="Genre">장르</label>
            <input readonly type="text" id="Genre" name="Genre" value="<?= $Novel['Genre'] ?>"/>
        </p>

        <p>
            <label for="Star_average">별점</label>
            <input readonly type="text" id="Star_average" name="Star_average" value="<?= $Novel['Star_average'] ?>"/>
        </p>

        <p>
            <label for="Novel_state">연재여부</label>
            <textarea readonly id="Novel_state" name="Novel_state" rows="10"><?= $Novel['Novel_state'] ?></textarea>
        </p>

        <p>
            <label for="Number_of_view">조회수</label>
            <input readonly type="number" id="Number_of_view" name="Number_of_view" value="<?= $Novel['Number_of_view'] ?>"/>
        </p>
    </div>
<? include("footer.php") ?>