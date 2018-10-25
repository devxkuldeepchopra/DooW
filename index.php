<?php 
include 'common.php';
include '_layout/header.php';
include '_layout/sidebar.php';
include '_layout/footer.php';
    if(isset($_POST['page'])){
        $content->page = $_POST['page'];
    }
    $url = $_SERVER["REQUEST_URI"];
    $urlExplode = explode("/",$url);
    $urlLength = sizeof($urlExplode);
    $path = $urlExplode[1];
    if($path !="admin" && $path != "" && $path != "searchContent"){ 
        require_once("postview.php");
    }   
    else if($path == "admin"){
        include 'admin.php';
    }
    else if(!$path) {
        require_once("home.php");  
    }
    else if($path == "searchContent"){
        
        require_once("search.php");  
    }
    else{    
        echo 'Not Found.........';
      // header('Location: /');
    }
if($path != "admin"){
echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <html lang="en-US" prefix="og: http://ogp.me/ns#">   
        <meta name="viewport" content="width=device-width, initial-scale=1">
           '.head($headContent).' 
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Rubik:500|Roboto:100,400,500,900|Sawarabi+Gothic|Economica:700|Yanone+Kaffeesatz" rel="stylesheet">
       <script>
        function showMenu() {
            var x = document.getElementById("menu-list").style ;
            var m = document.getElementById("menu").style;
            var c = document.getElementById("close").style;
            x.display == "block" ? (x.display = "none",c.display = "none", m.display = "block") : (x.display = "block", c.display = "block", m.display = "none");
        } 
        </script>
        </head>
    <body>
        <div class="container">';
                if($html->content) {
                    echo $html->header.
                        $html->content.
                        $html->sidebar.
                        $html->footer;
                }        
       echo' </div>
    </body>
    </html>';
}
?>
<script> 
var screenResolution = (prop) =>{ 
        var w = window,
        d = document,
        e = d.documentElement,
        g = d.getElementsByTagName("html"),
        x = w.innerWidth || e.clientWidth || g.clientWidth,
        y = w.innerHeight|| e.clientHeight|| g.clientHeight;
        if(prop == "height")  return  y;
        if(prop == "width") return x;
        
    }   
    if(screenResolution("width")>747) {
    let adload = setInterval(() => {
        let ads = document.getElementById("ads"); 
        let script = ads.getElementsByTagName("script"); 
        if (script) {
            var postColHeight = document.getElementById("post-col").clientHeight;
            var colHeight = document.getElementById("col-2").clientHeight;
            if(postColHeight > colHeight) document.getElementById("col-2").style.height = postColHeight.toString()+"px";
            else document.getElementById("post-col").style.height = colHeight.toString()+"px";
            clearInterval(adload);
        } else { 
          console.log("Waiting for onloadDoSomething to load");
        }
      }, 100);
    }
    var timeout;
    var searchcon = "";
function Search(search) {
    searchcon = search;
    clearTimeout(timeout);
    timeout = setTimeout(livesearch.bind(this), 2000); 

}
function livesearch(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'server/Post.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
    if(this.responseText) {
        var myArr = JSON.parse(this.responseText);
        SearchResult(myArr);
    }
   
};
xhr.send('search='+searchcon+'&action=SearchPost');
}    
function SearchResult(data) {
    if(document.getElementById("search-form")){
        var element = document.getElementById("search-form");
    element.parentNode.removeChild(element);
    }
    var x = document.getElementById("search-content");
    var my_form = document.createElement('FORM');
    my_form.name='myForm';
    my_form.method='POST';
    my_form.setAttribute("id", "search-form");
    my_form.className ='search-form';
    my_form.action='searchContent';
    x.appendChild(my_form);
    if(data.length>0){
        data.forEach(function(item){
            my_tb=document.createElement('INPUT');
            my_tb.type='submit';
            my_tb.name='search';
            my_tb.className ='search-item';
            my_tb.setAttribute("id", "search-item");
            my_tb.value= item.Title;
            my_form.appendChild(my_tb);
        });
    }  
}      
</script>




