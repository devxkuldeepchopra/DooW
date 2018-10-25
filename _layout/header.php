<?php

    $html->header  =  '<div class="header" id="test">

        	<a href="'.$headContent->baseUrl.'"><div class="logo"></div></a>
        	<div class="nav">
                <div class="menu" id="menu" onClick="showMenu()"></div>
                <div class="close"  onClick="showMenu()" id="close">
                    <svg viewbox="0 0 40 40">
                        <path class="close-x" d="M 10,10 L 30,30 M 30,10 L 10,30" />
                    </svg>

                </div>

        		<div class="nav-content" id="menu-list">

                    <ul>

                    <a href="'.$headContent->baseUrl.'"><li>Home</li></a>

                        <li>Category</li>

                        <li>About</li>

                        <li>Register</li>

                    </ul>

                </div>

        		<form class="search" action="searchContent" method="post">
                    <input class="input-search" type="text" placeholder="Search" name="search" onkeyup="Search(this.value)"/>
                    <input class="search-submit" type="submit" value="" />
                </form>
                <div class="search-content" id="search-content"></div>
        	</div>

        </div>'

?>