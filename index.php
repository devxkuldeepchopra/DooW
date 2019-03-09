<?php 
include 'common.php';
include '_layout/header.php';
include '_layout/sidebar.php';
include '_layout/footer.php';
    if(isset($_POST['page'])){
        $content->page = $_POST['page'];
    }
    //$url = $_SERVER["REQUEST_URI"];
    if (strpos($url, '?') !== false) {
      $url = str_replace("?","/",$url);
    }
    $urlExplode = explode("/",$url);
    $urlLength = sizeof($urlExplode);
    $path = $urlExplode[1];
    if($path !="admin" && $path != "" && $path != "searchContent" && $path != "category"){ 
        require_once("postview.php");
    }   
    // else if($path == "admin"){
    //     include 'admin.php';
    // }
    else if(!$path) {
        require_once("home.php");  
    }
    else if($path == "searchContent"){
        require_once("search.php");  
    }
    else if($path == "category"){
        require_once("categoryview.php");  
    }
    else{    
      //  echo 'Not Found.........';
       header('Location: /');
    }
if($path != "admin"){
echo '<!DOCTYPE html>
    <html>
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <html lang="en-US" prefix="og: http://ogp.me/ns#">   
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
<script>
     (adsbygoogle = window.adsbygoogle || []).push({
          google_ad_client: "ca-pub-5876716835770345",
          enable_page_level_ads: true
     });
</script>
<script> 
        window._izq = window._izq || []; window._izq.push(["init"]); 
</script>
<script src="https://cdn.izooto.com/scripts/1d7e4b9e726d9ad2df20f240852ec1a6f60e4d78.js"></script>      
        <meta name="viewport" content="width=device-width, initial-scale=1">
           '.head($headContent).' 
        <link rel="stylesheet" href="/css/style.css">
        <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Rubik:500|Roboto:100,400,500,900|Sawarabi+Gothic|Economica:700|Yanone+Kaffeesatz" rel="stylesheet">
       <script>
       function showMenu() {        
            var x = document.getElementById("menu-content").style ;
            var m = document.getElementById("menu-btn").style;
            var c = document.getElementById("close").style;
            var bb = document.getElementById("blackBc").style ;
            x.display == "block" ? (x.display = "none",c.display = "none", m.display = "block", bb.display = "none") : (x.display = "block", c.display = "block", m.display = "none",  bb.display = "block");
        } 
        </script>
        <script>
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
<script> 
function screenResolution(prop) { 
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
    let adload = setInterval(function() {
        let ads = document.getElementById("ads"); 
        if(ads.getElementsByTagName("script")){
            let script = ads.getElementsByTagName("script"); 
            if (script) {
                var postColHeight = document.getElementById("post-col").clientHeight;
                var colHeight = document.getElementById("col-2").clientHeight;
                if(postColHeight > colHeight) document.getElementById("col-2").style.height = postColHeight.toString()+"px";
                else document.getElementById("post-col").style.height = colHeight.toString()+"px";
                clearInterval(adload);
            } else { 
            console.log("screenreslutin");
            }
        }
      }, 1000);
    }
    var timeout;
    var searchcon = "";
function Search(search) {
    if(document.getElementById("search-content") && search==""){
        var element = document.getElementById("search-content");
        element.parentNode.removeChild(element);
    }
    searchcon = search;
    clearTimeout(timeout);
    timeout = setTimeout(livesearch.bind(this), 2000); 

}
function livesearch(){
    var xhr = new XMLHttpRequest();
    xhr.open('POST', '/server/Post.php', true);
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

    if(document.getElementById("search-content")){
        var element = document.getElementById("search-content");
    element.parentNode.removeChild(element);
    }
    var x = document.getElementById("search-tab");
    var searchSpan = document.createElement('span');
    searchSpan.className ="search-list"
    searchSpan.setAttribute("id", "search-content");
    x.appendChild(searchSpan);
    if(data.length>0){
        data.forEach(function(item){
        var createA = document.createElement('a');
        var createAText = document.createTextNode(item.Title);
        createAText.className ='search-item';
        var link = '/searchContent/?q='+item.Title;
        createA.setAttribute('href', link);
        createA.appendChild(createAText);
        searchSpan.appendChild(createA);
        });
    }  
}   
    getCurrentIPVisitPage();
     function getCurrentIPVisitPage() {
		try {
			var xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (this.readyState == 4 && this.status == 200) {
					console.log(this.responseText);
				}
			};
			xhttp.open("GET", "tutorial/wp-content/themes/twentysixteen/ad.php", true);
			xhttp.send();
		}
		catch(err) {
			console.log(err);
		}
     }
</script>