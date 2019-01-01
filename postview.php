<?php 
    $post = $Post->GetPostByPath($path);
    $post = json_encode($post);
    $post = json_decode($post);
    if($post){
    $views = $post[0]->View+1;
   	$UpdateView = $Post->AddView($views,$post[0]->PostId);
        $headContent->title = $post[0]->Title;
        $headContent->description = RemoveNull($post[0]->Description);
        $headContent->url = RemoveNull($post[0]->Url);
        $headContent->thumbImage = 'web/assets/images/uploads/'.RemoveNull($post[0]->ImageUrl);           
        // $VideoImage =  '<img src="web/assets/images/uploads/'.RemoveNull($post[0]->ImageUrl).'">';
        // if($post[0]->Video && $post[0]->Video != "null") {
        //     $VideoImage = '<div class="video">'.RemoveNull($post[0]->Video).'</div>';
        // }
        $postContent = RemoveNull($post[0]->Post);
        //$postContent = $post[0]->Post != "null" ? $post[0]->Post : "";
        $postViewConntent = '<div class="post-col" id="post-col"><h2>Home &raquo; '.$post[0]->CatName.'</h2><h1>'.$post[0]->Title.'</h1>
            <div class="post-article post-des">'.RemoveNull($post[0]->Description).'</div>
            <div class="ads">'.$ads.'</div>
            <div class="views">view :'.$views.'</div>
            <div class="post-article">'.$postContent.'</div>'; 

            if(sizeof(explode( "\n", $post[0]->Post))>5){
                 $postViewConntent.='<div class="ads">'.$ads.'</div>';
                }
                $postViewConntent.='</div>';
        $html->content =  $postViewConntent;   
    }
    else{
        header('Location: /');
    }
?>