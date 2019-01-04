<?php
$arrRandIds = array();

function isElementExist($el,$arrIds){
    if (in_array($el, $arrIds))
      {
          return true;
      }
    else
      {
          return false;
      }
}

function sidebar($httpRequest, $totalRows, $Post, $uploadImgPath){
    global $arrRandIds;
    $sidebar=''; 
    $sidePostCount = 0;
    $totalContent;
    if($totalRows >= 5){
        $totalContent = 4;
    }
    else if($totalRows > 2) {
        $totalContent = 3;
    }
    else {
        $totalContent = 0;
    }
    while($sidePostCount < $totalContent){
        $randomNumber = rand(0,$totalRows-1);
        if(sizeof($arrRandIds)>=1){
            while(isElementExist($randomNumber,$arrRandIds)){
                $randomNumber = rand(0,$totalRows-1);
            }
        }
        $Data = $Post->GetPost(0,1, $randomNumber);
        if($Data['post']){        
            foreach($Data['post'] as $post){
                $sidebar.='<div class="side-box">
                                <a href="/'.$post['Url'].'">
                                <img src="/'.$uploadImgPath.$post['ImageUrl'].'" alt="'.$post['Title'].'"/>
                                <span class="side-view">view '.$post['View'].'</span>
                                <span class="title" title="'.$post['Title'].'">'.$post['Title'].'</span>
                            </a></div>';
            }
            array_push($arrRandIds,$randomNumber);
            $sidePostCount++;
        }
    }
    
    return  $sidebar;
}
$tutorial = '<div class="side-box tutorials"><a href="http://tutorial.doomw.com"><div class="tutorial"></div></a></div>';
$html->sidebar = '<div class="col-2" id="col-2">'.$tutorial.'<div class="left-ads ads" id="ads">'.$ads.'</div>'.sidebar($httpRequest, $totalRows, $Post,$uploadImgPath).'<div class="left-ads ads">'.$ads.'</div></div>';

?>