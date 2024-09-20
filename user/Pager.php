<?php
class Pager
{
    function findStart($limit)
    {
        if((!isset($_GET['page']))  || ($_GET['page']=="1"))
        {
            $start = 0;
            $_GET['page'] = 1 ;
        }
        else
        {
            $start = ($_GET['page'] - 1) * $limit;
        }
        return $start;
    }
    
    function findPages($count, $limit)  
    {
        $pages = (($count % $limit)== 0) ? $count / $limit : floor($count / $limit) + 1;
        return $pages;
    }
    
    function pageList ($curPage, $pages,  $param=NULL)
    {
        $page_list = '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">';
        
        // First and Previous buttons
        if(($curPage !=1) &&($curPage))
        {
            $page_list .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'."page=1$param".'" title="Trang đầu"><<</a></li>';
        }
        if(($curPage - 1) >0)
        {
            $page_list .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'."page=".($curPage-1)."$param".'" title="Về trang trước"><</a></li>';   
        }

        // Page numbers
        $vtdau = max($curPage-2,1);
        $vtcuoi = min($curPage+2,$pages);
        
        for($i = $vtdau; $i <= $vtcuoi; $i ++)
        {
            if($i == $curPage)
            {
                $page_list .= '<li class="page-item active"><span class="page-link">'.$i.'</span></li>';
            }
            else
            {
                $page_list .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'."page=".$i."$param".'" title="Trang '.$i.'">'.$i.'</a></li>';
            }
        }

        // Next and Last buttons
        if($curPage + 1 <= $pages)
        {
            $page_list .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'."page=".($curPage+1)."$param".'" title="Đến trang sau">></a></li>';
            $page_list .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'."page=".$pages."$param".'" title="Đến trang cuối">>></a></li>';
        }

        $page_list .= '</ul></nav>';
        return $page_list;
    }
    
    function nextPrev($curpage, $pages) // Hiển thị 2 nút trước sau
    {
        $next_prev = "";
        if($curpage-1 < 0)
        {
            $next_prev .= '<li class="page-item disabled"><span class="page-link">Về trang trước</span></li>';
        }
        else
        {
            $next_prev .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'."page=".($curpage-1).'">Về trang trước</a></li>';
        }

        $next_prev .= "  |  ";

        if(($curpage + 1) > $pages)
        {
            $next_prev .= '<li class="page-item disabled"><span class="page-link">Đến trang sau</span></li>';
        }
        else
        {
            $next_prev .= '<li class="page-item"><a class="page-link" href="'.$_SERVER['PHP_SELF'].'?'."page=".($curpage+1).'">Đến trang sau</a></li>';
        }

        return '<nav aria-label="Page navigation"><ul class="pagination justify-content-center">' . $next_prev . '</ul></nav>';
    }
}
?>