<?php 
    require_once("pagination.php");     
    $post = $Post->GetPost($content->page,$content->limit,$content->randPage);
    $posts = $post['post'];
    if(!$post){return false;}
    $contentHome = '<div class="col-1 col-rb" id="post-col"><a href="'.$tutorialLink.'"><div class="ads ads-head">'.$ads.'</div></a>'; 
    if($post)
    {
        for($i=0; $i < sizeof($posts); $i++)
        {
            $contentHome .=  '<div class="grid-box">
                <a href="'.$posts[$i]['Url'].'">
                    <img src="'.$uploadImgPath.$posts[$i]['ImageUrl'].'" alt="'.$posts[$i]['Title'].'" />
                    <span class="views">view '.$posts[$i]['View'].'</span>
                    <span class="title" title="'.$posts[$i]['Title'].'">'.$posts[$i]['Title'].'</span>
                </a>
            </div>';
        }
    }
    else 
    {
        $contentHome .= 'Coming Soon.... .';
    }
    $html->content = $contentHome.$paginationHtml.'<div class="ads">'.$ads.'</div></div>';
?>