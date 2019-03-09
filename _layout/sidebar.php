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
function blogCleanLink($title) {
    $strLower =strtolower($title); 
    $strClean =preg_replace("/[^a-z0-9_\s-]/", " ", $strLower);
    $strClean =preg_replace("/\s\s+/", " ", $strClean);
    $strClean = preg_replace("/[\s-]+/", "-", $strClean);
    $strLength=strlen($strClean);
    $cleanedLink="";
    for($i=0; $i<$strLength-1; $i++)
    {
         $cleanedLink = $cleanedLink.$strClean[$i];
    }
    return $cleanedLink;
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
        $blog = $Post->GetBlogRandom();
        while(empty($blog)) {
            $blog = $Post->GetBlogRandom();
        }
        $blog = $blog[0]['blog'];
        $blogSplit = explode("\n",$blog);
        $link =  blogCleanLink($blogSplit[0]);
        $sidebar.='
        <div class="side-box">
                <a href="/blog/'.$link.'" target="_blank">
                    <img src="/blog/img/'.$blogSplit[1].'" alt="'.$blogSplit[0].'"/>
                    <span class="title" title="'.$blogSplit[0].'">'.str_replace("////", "'", $blogSplit[0]).'</span>
                </a>
        </div>';
        $Data = $Post->GetPost(0,1, $randomNumber);
        if($Data['post']){        
            foreach($Data['post'] as $post){
                $sidebar.='<div class="side-box">
                                <a href="/'.$post['Url'].'">
                                    <img src="/'.$uploadImgPath.$post['ImageUrl'].'" alt="'.$post['Title'].'"/>
                                    <span class="side-view">view '.$post['View'].'</span>
                                    <span class="title" title="'.$post['Title'].'">'.$post['Title'].'</span>
                                </a>
                            </div>';
            }
            array_push($arrRandIds,$randomNumber);
            $sidePostCount++;
        }
    }
    return  $sidebar;
}
$tutorial = '<div class="side-box tutorials"><a href="'.$tutorialLink.'"><div class="tutorial"></div></a></div>';
$html->sidebar = '<div class="col-2 col-lb" id="col-2"><span id="fbk" class="fblikeshare">'.$fb.'</span>'.$tutorial.'<div class="left-ads ads" id="ads">'.$ads.'</div>'.sidebar($httpRequest, $totalRows, $Post,$uploadImgPath).'<div class="left-ads ads">'.$ads.'</div></div>';

?>