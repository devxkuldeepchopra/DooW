<?php 
include 'common.php';
include '_layout/header.php';
include '_layout/sidebar.php';
include '_layout/footer.php';
include 'route.php';

    if(isset($_POST['page'])){
        $content->page = $_POST['page'];
    }
    $route = new Route($url);
    $path = $route->GetRoute();
    $pdfRoutes = $route->GetPredefinedRoutes();
    $route->NavigateRoute($path,$pdfRoutes);
    // if (strpos($url, '?') !== false) 
    // {
    //   $url = str_replace("?","/",$url);
    // }
    // $urlExplode = explode("/",$url);
    // $urlLength = sizeof($urlExplode);
    // $path = $urlExplode[1];

    // if($path !="admin" && $path != "" && $path != "searchContent" && $path != "category")
    // { 
    //     require_once("postview.php");
    // }   
    // else if(!$path)
    // {
    //     require_once("home.php");  
    // }
    // else if($path == "searchContent")
    // {
    //     require_once("search.php");  
    // }
    // else if($path == "category")
    // {
    //     require_once("categoryview.php");  
    // }
    // else
    // {    
    //    header('Location: /');
    // }
if($path != "admin"){
echo '<!DOCTYPE html>
    <html>
    <head>
           '.consMeta().head($headContent).' 
       <script>
            function showMenu() {        
                var x = document.getElementById("menu-content").style ;
                var m = document.getElementById("menu-btn").style;
                var c = document.getElementById("close").style;
                var bb = document.getElementById("blackBc").style ;
                x.display == "block" ? (x.display = "none",c.display = "none", m.display = "block", bb.display = "none") : (x.display = "block", c.display = "block", m.display = "none",  bb.display = "block");
            } 
            function showCategory() {
                var x = document.getElementById("categoriesid").style ;
                var bb = document.getElementById("blackBc").style ;
                var c = document.getElementById("close").style
                if(c.display=="block" || c.display=="none" || c.display == ""){ bb.display = "block";}
                x.display = "block";
            }
            function hideCategory() {
                var x = document.getElementById("categoriesid").style ;
                var bb = document.getElementById("blackBc").style ;
                var c = document.getElementById("close").style
                if(c.display=="block"){ bb.display = "block";}
                else if( c.display == "" || c.display == "none"){bb.display = "none";}
                x.display = "none";
            }
        </script>
        </head>
    <body>
        <div class="container">';
                if($html->content) {
                    echo $html->header.'<div class="row">'.
                        $html->content.
                        $html->sidebar.'</div>'.
                        $html->footer;
                }        
       echo' </div>
    </body>
    </html>';
}
?>
<script src="https://www.gstatic.com/firebasejs/5.9.0/firebase.js"></script>
<script src="/push.js"></script>
<script src="/indexjs.js"></script>