<!DOCTYPE html>

<html>

<head>

    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <html lang="en-US" prefix="og: http://ogp.me/ns#">   

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="assets/css/style.css">

    <script src="assets/js/jquery.js"></script>

    <script src="assets/js/common.js"></script>  

	  <script src="assets/js/jquery.validate.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->

    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="  crossorigin="anonymous"></script> -->

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <!-- <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script> -->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css?family=Bree+Serif|Rubik:500|Roboto:100,400,500,900|Sawarabi+Gothic|Economica:700|Yanone+Kaffeesatz" rel="stylesheet">

</head>

<body>



<div class="container">

  <h2>Add Post</h2>

  <form class="form-horizontal" id="postForm" method="Post" action="">

<input type="hidden" id="lastid" />

    <div class="form-group">

      <label class="control-label col-sm-2" for="title">Title:</label>

      <div class="col-sm-10">

      <input type="text" maxlength="500" class="form-control" id="title" placeholder="Enter title"  name="title">

    </div>

    </div>



    <div class="form-group">

      <label class="control-label col-sm-2" for="description">Description:</label>

      <div class="col-sm-10">

      <input type="text"  maxlength="500"  class="form-control" id="description" placeholder="Enter description" name="description">

    </div>

    </div>



     <div class="form-group">

      <label class="control-label col-sm-2" for="video">Embed Video (youtube):</label>

      <div class="col-sm-10">

      <input type="text"  maxlength="1000"  class="form-control" id="video" placeholder="Enter description" name="video">

    </div>

    </div>





    <div class="form-group group">
      <label class="control-label col-sm-2" for="description">Upload Image:</label>
      <div class="col-sm-10 col-img">
        <input type="file" name="logo" id="pic" class="styled">
        <img src="" class="uploaded-img" id="uploaded-img"/>
      </div>
    </div>







   

    <div class="form-group">

      <label class="control-label col-sm-2" for="mypost">Post:</label>

      <div class="col-sm-10">

      <textarea class="form-control" id="mypost" placeholder="Enter Post" name="mypost">

</textarea>

    </div>

    </div>



    <button type="submit" class="btn btn-default">Add Post</button>

  </form>

</div>

</body>

</html>







<script src="assets/js/admin.js"></script>















