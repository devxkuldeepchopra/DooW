$( document ).ready(function() {
    var reqdata = { 
        'action': 'GetPostByPath',
        'post-path' : $("#post-path").val()
    };
	debugger; 	
    $.ajax({
        type: "POST",
        url: "server/Post.php",
        data      : reqdata,
        dataType: "json",
        success: function (data) {
            debugger;
            $("#post-title").text(data[0].Title);
            $("#post-post").text(data[0].Post);
            $("#post-image").attr('src','assets/images/uploads/'+data[0].ImageUrl);

        },
        error: function (request, status, error) {
            console.log('oh, errors here. The call to the server is not working.')
        }
    });
});