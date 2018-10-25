<?php 
    $totalRows = $Post->PostPagination();
    $totalRows = $totalRows[0]['total'];
    $class = "inactive";
    $paginationHtml = '<form method="post" action="" class="pagination">';
    $pages =  (int)$totalRows/$content->limit;
    $pages = ceil($pages);
    for($i=1; $i<=$pages;$i++) {
        if($i==$content->page){
            $class="active";
        }else{
            $class="inactive";
        }
        $paginationHtml.='<input type="submit" class="'.$class.'" name="page" value="'.$i.'">';
    }
    $paginationHtml =  $paginationHtml.'</form>';
?>