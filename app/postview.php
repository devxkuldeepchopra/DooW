<?php  echo '<input type="hidden" id="post-path" value ="'.$path.'">'; ?>

<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="collapsibleNavbar">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Link</a>
      </li>    
    </ul>
  </div>  
</nav>

<div class="container" style="margin-top:30px">
  <div class="row">    
    <div class="col-sm-8">
      <h1 id="post-title"></h1>
      <h5>Title description, Dec 7, 2017</h5>
      <div ><img src="" class="post-image" id="post-image"></div>
      <p id="post-post"></p>
    </div>
    <div class="col-sm-4">
      <h2>About Me</h2>
      <h5>Photo of me:</h5>
      <div class="fakeimg"></div>
      <p>Some text about me in culpa qui officia deserunt mollit anim..</p>
      <h3>Some Links</h3>
      <p>Lorem ipsum dolor sit ame.</p>
      <ul class="nav nav-pills flex-column">
        <li class="nav-item">
          <a class="nav-link active" href="#">Active</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled" href="#">Disabled</a>
        </li>
      </ul>
      <hr class="d-sm-none">
    </div>
  </div>
</div>

<div class="jumbotron text-center" style="margin-bottom:0">
  <p>Footer</p>
</div>

<script src="assets/js/post.js"></script>