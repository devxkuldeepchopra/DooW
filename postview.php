<?php 
function youtubeConfig($content) {
    $newContent = "";
    $youtubeEmbed = 'https://www.youtube.com/embed/';
    $attribute = '<iframe  allowfullscreen allow="accelerometer; encrypted-media; gyroscope; picture-in-picture"';
    if(strpos($content, $youtubeEmbed) !== false) {
        $newContent = str_replace("<iframe",$attribute,$content);
    }
    return $newContent;
}
  //  include "ip.php";
    $post = $Post->GetPostByPath($path);
    $post = json_encode($post);
    $post = json_decode($post);
    $categories = $Post->GetCategory();
    $categoriesDiv = "";
    if($categories){
        $i = 0;
        $colorClass = array("blue", "purple", "green","yellow","dcyan","dred"); 
        $categoriesDiv .= '<div class="blog-categories" id="blogCategoriesid"><ul>';
        foreach($categories as $category){
            $rclass = rand(0,5);
            $categoriesDiv .= '<li  class="'. $colorClass[$rclass].'"><a href="/category/?c='.$category["Name"].'">'.$category["Name"].'</a></li>';
            $i++;
        }
        $categoriesDiv .= '</ul></div>';
    }
    if($post){
        $views = $post[0]->View;
        //if(!$isIpExist) {
            $views = $views+1;
            $UpdateView = $Post->AddView($views,$post[0]->PostId);
       // }
        $headContent->title = $post[0]->Title;
        $headContent->description = RemoveNull($post[0]->Description);
        $headContent->url = RemoveNull($post[0]->Url);
        $headContent->thumbImage = 'web/assets/images/uploads/'.RemoveNull($post[0]->ImageUrl);           
        $postContent = RemoveNull($post[0]->Post);
        $postViewConntent = '<div class="post-col" id="post-col"><a href="'.$tutorialLink.'"><div class="ads ads-head">'.$ads.'</div></a>
            <h2><a href="/">Home</a> &raquo; <a href="'.$catlink.$post[0]->CatName.'">'.$post[0]->CatName.'</a></h2>
            <h1>'.$post[0]->Title.'</h1>
            <div class="post-article post-des">'.RemoveNull($post[0]->Description).'</div>
            <div class="views">view :'.$views.'</div>
            <div class="post-article">'.youtubeConfig($postContent).'</div>'; 

            if(sizeof(explode( "\n", $post[0]->Post))>9){
                 $postViewConntent.='<div class="ads ">'.$ads.'</div>';
                 $postViewConntent.= $categoriesDiv;
                }
                else{
                    $postViewConntent.= $categoriesDiv;
                }
                $postViewConntent.='</div>';
        $html->content =  $postViewConntent;   
    }
    else{
        header('Location: /');
    }
?>