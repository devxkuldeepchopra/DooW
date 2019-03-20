<?php
    require_once('server/PostClass.php');
    require_once('server/conn.php');
    $baseUrl = 'https://doomw.com';
    $url = $_SERVER["REQUEST_URI"];
    $pageUrl =  $baseUrl.$url;
    $tutorialLink = 'http://tutorial.doomw.com';
    $ads = '<script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
    <!-- devx -->
    <ins class="adsbygoogle"
         style="display:block"
         data-ad-client="ca-pub-5876716835770345"
         data-ad-slot="3438846476"
         data-ad-format="auto"></ins>
    <script>
    (adsbygoogle = window.adsbygoogle || []).push({});
    </script>';
    $uploadImgPath = "web/assets/images/thumbnail/";
	$Post = new Post($conn);
    $httpRequest= (object) array(
        'apiUrl'=>'https://doomw.com/server/post.php',
        'Post'=>'POST', 'Get'=>'GET'
    );
    $content= (object) array(
        'page'=>1,
        'limit'=>18,
        'randPage'=>''
    );
    $headContent = (object) array(
        'title'=>'DoomW',
        'websiteName'=>'doomw.com',
        'description'=>'',
        'keyword'=>'',
        'baseUrl'=> $baseUrl.'/',
        'favicon'=>'',
        'thumbImage'=>'doomwthumb.jpg',
        'url'=>''
    ); 
    $html = (object) array(
        'head'=>'',
        'header'=>'',
        'content'=>'',
        'sidebar'=>'',
        'footer'=>'',
    );
    function Head( $headContent) {
        return $head = '   <title>'.$headContent->title.'</title>
        <meta name="description" content="'.$headContent->description.'"/>
        <meta name="title" content="'.$headContent->title.'"/>
        <meta property="og:type" content="blog.video" />
        <meta property="og:url" content="'.$headContent->baseUrl.$headContent->url.'"/>
        <meta property="og:site_name" content="'.$headContent->websiteName.'"/>
        <meta property="og:locale" content="en_US" />                
        <meta property="og:title" content="'.$headContent->title.'"/>
        <meta property="og:description" content="'.$headContent->description.'"/>
        <meta property="og:image" content="'.$headContent->baseUrl.$headContent->thumbImage.'"/>
        <link rel="alternate" href="'.$headContent->baseUrl.$headContent->url.'" hreflang="en-us" />
        <link rel="canonical" href="'.$headContent->baseUrl.$headContent->url.'"/>
        <meta property="og:image:alt" content="'.$headContent->url.'"/>
        <meta name="robots" content=" index, follow "/>
        <link rel="icon" href="/images/favicon.png" sizes="16x16 32x32" type="image/png"> 
    ';
    }
    $totalRows = $Post->PostPagination();
    $totalRows = $totalRows[0]['total'];

    function RemoveNull($value) {
        return $value != "null" ? $value : "";
    }
    $catlink = "/category/?c=";
    $fb = '<iframe src="https://www.facebook.com/plugins/like.php?href='.$pageUrl.'&width=124&layout=button_count&action=like&size=small&show_faces=true&share=true&height=46&appId" width="124" height="46" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowTransparency="true" allow="encrypted-media"></iframe>';
    $disqus = '<script>
    var disqus_config = function () {
    this.page.url = "'. $pageUrl.'"; 
    this.page.identifier = "'. $pageUrl.'"; 
    };
    (function() {'."
    var d = document, s = d.createElement('script');
    s.src = 'https://doomw-com.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
    </script>".'
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
    ';
?>