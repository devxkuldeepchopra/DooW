<?php 
   if(isset($_GET['q']) && $_GET['q']!="") 
   {
        $search = $_GET['q'];
        $contentHome = '<div class="col-1" id="post-col"><h2>'.$search.'</h2><div class="grid-bd"></div>'; 
        $post = $Post->Search($search);
        if(sizeof($post)>0) 
        {    
            $post = json_encode($post);
            $post = json_decode($post);
           
            foreach($post as $post)
            {
                $contentHome .=  '<div class="grid-box">
                <a href="/'.$post->Url.'">
                <img src="/'.$uploadImgPath.$post->ImageUrl.'" alt="'.$post->Title.'" />
                <span class="views">view '.$post->View.'</span>
                <span class="title" title="'.$post->Title.'">'.$post->Title.'</span>
                </a></div>
                ';
            }
            $html->content = $contentHome.'<div class="ads">'.$ads.'</div></div>';
          
        }
        else
        {
            $contentHome .= '<h3> &#x261B; Not Found</h3>';
            $html->content = $contentHome.'<div class="ads">'.$ads.'</div></div>';
        }                
    }
    else
    {
       header('Location: /');
    }
?>