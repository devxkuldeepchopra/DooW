<?php
$arrRN = array();
function chkDN($arrR,$n){
    global $arrRN;
    $arrSize = sizeof($arrRN);
    for($i=0; $i<$arrSize; $i++){
	if($arrR[$i] == $n) {
	    return true;
	}			
    }
    array_push($arrRN,$n);
    return false;
}

function sidebar($httpRequest, $totalRows, $Post, $uploadImgPath){
global $arrRN;
for($pg=0; $pg<3; $pg++){
	$rN = rand(0,$totalRows-1);
	if(empty($arrRN)){
	array_push($arrRN,$rN);
	}
	else if(sizeof($arrRN)>=1) {
		while(chkDN($arrRN,$rN)){
			$rN = rand(0,$totalRows-1);
		}
	}
}

    $sidebar='';
foreach($arrRN as $randPage){
    $Data = $Post->GetPost(0,1, $randPage);
    if($Data) {
   
            foreach($Data['post'] as $post){
                $sidebar.='<div class="side-box">
                                <a href="'.$post['Url'].'">
                                <img src="'.$uploadImgPath.$post['ImageUrl'].'" alt="'.$post['Title'].'"/>
                                <li class="title" title="'.$post['Title'].'">'.$post['Title'].'</li>
                            </a></div>';
            }
        }
}
    return  $sidebar;
}
$tutorial = '<div class="side-box tutorials"><a href="http://tutorial.doomw.com"><div class="tutorial"></div></a></div>';
$html->sidebar = '<ul class="col-2" id="col-2">'.$tutorial.'<div class="ads" id="ads">'.$ads.'</div>'.sidebar($httpRequest, $totalRows, $Post,$uploadImgPath).'<div class="ads">'.$ads.'</div></ul>';

?>