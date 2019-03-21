<?php 
    class Route {
        public $Url;
        public $Route;
        function __Construct($url)
        {
            $this->Url = $url;
        }

        function GetRoute()
        {
            $this->Route = strpos($this->Url, '?') ? str_replace("?", "/", $this->Url) : $this->Url;
            $urlExplode = explode("/", $this->Route);
            $urlLength = sizeof($urlExplode);
            $this->Route = $urlExplode[1];
            return $this->Route;
        }
        function GetPredefinedRoutes()
        {
            return array("","admin", "searchContent", "category");
        }
        function NavigateRoute($route,$predefinedRoute)
        {  
            if (!in_array($route, $predefinedRoute)) 
            { 
                require_once("postview.php");
            } 
            else if(!$route)
            {
                require_once("home.php");  
            }
            else if($route == $predefinedRoute[2])
            {
                require_once("search.php");  
            }
            else if($route == $predefinedRoute[3])
            {
                require_once("categoryview.php");  
            }
            else
            {    
               header('Location: /');
            }
        }
    }
?>