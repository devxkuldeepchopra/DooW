<?php 
   if(isset($_GET['c']) && $_GET['c']!="") 
   {
        $category = $_GET['c'];
        $contentHome = '<div class="col-1" id="post-col"><h2>Category &raquo; '.$category.'</h2><div class="grid-bd"></div>'; 
        $post = $Post->GetPostByCategoryName($category);
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
            $contentHome .= '<h3> &#x261B; No Result Found</h3>';
            $html->content = $contentHome.'<div class="ads">'.$ads.'</div></div>';
        }                
    }
    else
    {
      // header('Location: /');
    }
?>