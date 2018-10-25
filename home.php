<?php 
    require_once("pagination.php");     
    $post = $Post->GetPost($content->page,$content->limit,$content->randPage);
    if(!$post){return false;}
    $post = json_encode($post);
    $post = json_decode($post);
    $contentHome = '<ul class="col-1" id="post-col"><div class="ads">'.$ads.'</div>'; 
    if($post){
    foreach($post->post as $post){
        $contentHome .=  '<div class="grid-box">
                                <a href="'.$post->Url.'">
                                    <img src="'.$uploadImgPath.$post->ImageUrl.'" alt="'.$post->Title.'" />
<span class="views">view '.$post->View.'</span>
                                    <li class="title" title="'.$post->Title.'">'.$post->Title.'</li>
                                </a>
                            </div>';
    }
    $html->content = $contentHome.$paginationHtml.'<div class="ads">'.$ads.'</div></ul>';
}
?>