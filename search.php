<?php 
    //require_once("pagination.php");     
   if(isset($_POST['search']) && $_POST['search']!="") 
   {
        $search = $_POST['search'];
        $contentHome = '<div class="col-1" id="post-col"><h2>Result for: </h2><h1>'.$search.'</h1>'; 
        $post = $Post->Search($search);
        if(sizeof($post)>0) 
        {    
            $post = json_encode($post);
            $post = json_decode($post);
           
            foreach($post as $post)
            {
                $contentHome .=  '<div class="grid-box">
                <a href="'.$post->Url.'">
                <img src="'.$uploadImgPath.$post->ImageUrl.'" alt="'.$post->Title.'" />
                <span class="views">view '.$post->View.'</span>
                <li class="title" title="'.$post->Title.'">'.$post->Title.'</li>
                </a></div>
                ';
            }
            $html->content = $contentHome.'<div class="ads">'.$ads.'</div></div>';
          
        }
        else
        {
            $contentHome .= '<h3>No Result Found.</h3>';
            $html->content = $contentHome.'<div class="ads">'.$ads.'</div></div>';
        }                
    }
    else
    {
        header('Location: /');
    }
?>