var page = 1;
var content = 15;
$( document ).ready(function() {
    GetPost(page,content);
    Pagination(content);
});


function GetPost(page,content){
  

    var reqdata = { 
        'action': 'GetPost',
        'page': page,
        'content':content
    };
    var body = JSON.stringify(reqdata);
	debugger; 	
    $.ajax({
        type: "POST",
        url: "server/Post.php",
        data      : body,
        dataType: "json",
        success: function (data) {
            debugger;
            $("#post-grid").children().remove();
            $(".page-item").removeClass("active");
            $("#page"+page).addClass("active");
            data.post.forEach(element => {
                $("#post-grid").append('<div class="col-sm-4 grid-gap">'+
                '<div class="grid-box">'+
                '<img src="../../../blogJioFox/assets/images/fake.jpg" />'+
                '<a href="'+element.Url+'">'+
                '<span class="grid-box-title" title="'+
                element.Title+
                '">'+
                element.Title+
                '</span></a></div></div>');
            });
        },
        error: function (request, status, error) {
            console.log('oh, errors here. The call to the server is not working.')
        }
    });
}

function Pagination(content) {
    var reqdata = { 
        'action': 'PostPagination',
    };	
    $.ajax({
        type: "POST",
        url: "../../../blogJioFox/server/Post.php",
        data      : reqdata,
        dataType: "json",
        success: function (data) {
                var total = data[0].total;
                var pagination = parseInt(total/content);
                for(var i = 0 ; i <= pagination; i++)
                {
                    $("#grid-pagination").append(' <li class="page-item" id="page'+(i+1)+'"><a class="page-link" href="#" onClick="GetPostByPage('+(i+1)+')">'+(i+1)+'</a></li>');
                }
        },
        error: function (request, status, error) {
            console.log('oh, errors here. The call to the server is not working.')
        }
    });
}

function GetPostByPage(page){
    debugger;
    GetPost(page,content);

}