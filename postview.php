<?php 
    $post = $Post->GetPostByPath($path);
    $post = json_encode($post);
    $post = json_decode($post);
    if($post){
    $views = $post[0]->View+1;
   	$UpdateView = $Post->AddView($views,$post[0]->Id);
        $headContent->title = $post[0]->Title;
        $headContent->description = $post[0]->Description;
        $headContent->url = $post[0]->Url;
        $headContent->thumbImage = 'web/assets/images/uploads/'.$post[0]->ImageUrl;           
        $VideoImage =  '<img src="images/uploads/'.$post[0]->ImageUrl.'side.jpg">';
        if($post[0]->Video) {
            $VideoImage = '<div class="video">'.$post[0]->Video.'</div>';
        }
        $postViewConntent = '<div class="post-col" id="post-col"><h1>'.$post[0]->Title.'</h1>
            '.$VideoImage.'<div class="views">view :'.$views.'</div>
            <div class="post-article post-des">'.$post[0]->Description.'</div>
            <div class="ads">'.$ads.'</div>
            <div class="post-article">'.$post[0]->Post.'</div>'; 

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