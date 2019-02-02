<?php
$categoriesDiv = "";
$closeIcon = '<svg viewbox="0 0 40 40">
<path class="close-x" d="M 10,10 L 30,30 M 30,10 L 10,30" />
</svg>';
$categories = $Post->GetCategory();
if($categories){
    $categoriesDiv .= '<div class="categories" id="categoriesid"><div class="close-cat" onClick="hideCategory()">'.$closeIcon.'</div><ul>';
    foreach($categories as $category){
        $categoriesDiv .= '<li><a href="/category/?c='.$category["Name"].'">'.$category["Name"].'</a></li>';
    }
    $categoriesDiv .= '</ul></div>';
}
    $html->header  =  '<div class="black-bc" id="blackBc"></div>
    <div class="header-doom">
        <div class="logo-1 pb-1-4">
            <a href="'.$headContent->baseUrl.'" class="doomw-link-1">
            </a>
        </div>
        <div class="search-content-1 pb-1-4" id="search-tab">
            <form class="search-form" action="searchContent/" method="get" autocomplete="off">            
                <input class="cs-input-1" type="text" placeholder="Search" name="q" onkeyup="Search(this.value)"/>
                <input class="search-icon" type="submit" value="" />               
            </form>
            <div class="search-content-form" id="search-content"></div>           
        </div>
        <div class="menu-1" id="menu-btn" onClick="showMenu()">
        <i class="fas fa-ellipsis-v"></i>
        </div>
        <div class="close"  onClick="showMenu()" id="close">
            '.$closeIcon.'
        </div>
        <div class="left-content-1 pb-1-4" id="menu-content">
            <ul class="nav-content-1">
                <li class="nav-list-1"><a href="'.$headContent->baseUrl.'">Home</a></li>
                <li class="nav-list-1 category-dd" onClick="showCategory()">Category&#9662;</li>
                <li class="nav-list-1">Contact</li>
                <li class="nav-list-1">About</li>
            </ul>
            '.$categoriesDiv.'
        </div>
    </div>
'
?>