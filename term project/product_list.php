<?
include "header.php";
include "config.php";    //데이터베이스 연결 설정파일
include "util.php";      //유틸 함수
?>
<div class="container">
    <?
    
    $conn = dbconnect($host, $dbid, $dbpass, $dbname);
    mysqli_query( $conn, "set autocommit = 0");
    mysqli_query( $conn, "set session transaction isolation level serializable");
    mysqli_query( $conn, "start transaction");
    $query = "select * from Writer natural join Novel";
    if (array_key_exists("search_keyword", $_POST)) {  // array_key_exists() : Checks if the specified key exists in the array
        $search_keyword = $_POST["search_keyword"];
        $query =  $query . " where product_name like '%$search_keyword%' or manufacturer_name like '%$search_keyword%'";
    
    }
    $res = mysqli_query($conn, $query);
    if (!$res) {
        mysqli_query($conn,"rollback");
        s_msg("Query Error");
         die('Query Error : ' . mysqli_error());
    }
    else{
        mysqli_query($conn,"commit");
        s_msg("Query Success");
    }
    ?>

    <table class="table table-striped table-bordered">
        <thead>
        <tr>
            <th>No.</th>
            <th>작가</th>
            <th>TItle</th>
            <th>장르</th>
            <th>별점</th>
            <th>조회수</th>
            <th>연재여부</th>
            
        </tr>
        </thead>
        <tbody>
        <?
        $row_index = 1;
        while ($row = mysqli_fetch_array($res)) {
            echo "<tr>";
            echo "<td>{$row_index}</td>";
            echo "<td>{$row['Nickname']}</td>";
            echo "<td><a href='product_view.php?Title={$row['Writer']}'>{$row['Title']}</a></td>";
            echo "<td>{$row['Genre']}</td>"; 
            echo "<td>{$row['Star_average']}</td>";
            echo "<td>{$row['Number_of_view']}</td>";
            echo "<td>{$row['Novel_state']}</td>";
            echo "<td width='17%'>
                <a href='product_form.php?Title={$row['Title']}'><button class='button primary small'>수정</button></a>
               <button onclick='javascript:deleteConfirm({$row['product_id']})' class='button danger small'>삭제</button>
               </td>";
            echo "</tr>";
            $row_index++;
        }
        ?>
        </tbody>
    </table>
    <script>
        function deleteConfirm(Novel) {
            if (confirm("정말 삭제하시겠습니까?") == true){    //확인
                window.location = "product_delete.php?Novel=" + Novel;
            }else{   //취소
                return;
            }
        }
    </script>
</div>
<? include("footer.php") ?>
