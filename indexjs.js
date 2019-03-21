searchBack();
var timeout;
var searchcon = "";
function Search(search) {
    if(document.getElementById("search-content") && search=="") {
        var element = document.getElementById("search-content");
        element.parentNode.removeChild(element);
    }
    searchcon = search;
    clearTimeout(timeout);
    timeout = setTimeout(livesearch.bind(this), 2000); 
}
function livesearch() {
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
    isSearchContent();
    var x = document.getElementById("search-tab");
    var searchSpan = document.createElement('span');
    searchSpan.className ="search-results"
    searchSpan.setAttribute("id", "search-content");
    x.appendChild(searchSpan);
    if(data.length>0) {
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
function searchBack(){
    isSearchContent();
    var searchInput = document.getElementById("searchInput");
    searchInput.value = "";
    var searchTab = document.getElementById("search-tab");
    searchTab.style.display = "none";
}
function showSearch(){
    var searchTab = document.getElementById("search-tab");
    searchTab.style.display = "block";
}
function isSearchContent(){
    if(document.getElementById("search-content")) {
        var element = document.getElementById("search-content");
        element.parentNode.removeChild(element);
    }
}
function getCurrentIPVisitPage() {
    try {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log('this.responseText');
            }
        };
        xhttp.open("GET", "tutorial/wp-content/themes/twentysixteen/ad.php", true);
        xhttp.send();
    }
    catch(err) {
        console.log(err);
    }
}
getCurrentIPVisitPage();