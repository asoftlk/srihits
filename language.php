<?php include "header.php";
if(isset($_GET['name'])){
        $json = file_get_contents('https://srihits.veramasait.com/App/listbylan.php');
        $obj = json_decode($json);        
}
?>
<style>
    /* .content{
        max-width: calc(100vw - 105px);
    } */
    .thumbnail{
        transition: 0.3s all ease-in-out;
    }
    .thumbnailcontent{
        background-image: linear-gradient(to bottom, rgba(4,8,15,0.3), #192133, #192133);
        opacity:0;
        width:230px;
        bottom: 15px;
        border-bottom-right-radius: 5px;
        border-bottom-left-radius: 5px;
    }
    .increase{
        transform:scale(1.3);
        z-index:2;
    }
    .increase-left{
        transform:scale(1.3);
        transform-origin: left;
        z-index:2;
    }
    .increase-right{
        transform:scale(1.3);
        transform-origin: right;
        z-index:2;
    }
    .thumbnail:hover .thumbnailcontent{
        opacity: 1;
    }
    .thumbimage{
        width:230px;
        height:130px;
        margin-right:5px;
        border-radius:5px;
    }
    .thumbtitle{
        font-size:10px;
    }
    .thumbgenre{
        font-size:9px;
    }
    .watchlist, .play{
        padding-left:0;
        font-size:9px;
        color:#fff;
        background-color: transparent;
        border: none;
        width: 100%;
        border-radius: 3px;
        text-align: left;
    }
    .watchlist:hover, .play:hover{
        text-decoration:none;
        color:#fff;
        background-color: #ffffff26;
        border: 1px solid #ffffff26;
    }
    @media only screen and (max-width:992px){
        .thumbimage{
            width:200px;
            height:110px;
            margin-right:5px;
            border-radius:5px;
        }
        .thumbnailcontent{
            width:200px;
        }
    }
    @media only screen and (max-width:786px){
        .thumbimage{
            width:180px;
            height:100px;
            margin-right:5px;
            border-radius:5px;
        }
        .thumbnailcontent{
            width:180px;
        }
    }
    @media only screen and (max-width:450px){
        .thumbimage{
            width:140px;
            height:80px;
            margin-right:5px;
            border-radius:5px;
        }
        .thumbnailcontent{
            width:140px;
        }
        .thumbnail:hover .thumbnailcontent{
        opacity: 0;
    }        
    }
    
</style>
<div class="container-fluid ">
    <div class="title"></div>
    <!--<h4 class="title text-light text-capitalize ms-3 mt-2"><?= $_GET['name'] ?></h4>-->
    <div class="list mb-3 d-flex flex-wrap ms-3"></div>
</div>
<script>
function load_content(offset){
$.ajax({
    url:"https://srihits.veramasait.com/App/listbylan.php",
    method:"POST",
    data:{lan:"<?= $_GET['name'] ?>", kids:'<?php echo $_SESSION["kids"] ?>', offset:offset},
    success:function(data)
    {
        var userid = "<?= isset($_SESSION['userid'])?$_SESSION['userid']:''?>";
        if(userid != ''){
        $.ajax({
            url:"https://srihits.veramasait.com/App/wishlist.php",
            method:"POST",
            data:{type:"list", kids:'<?php echo $_SESSION["kids"] ?>', userid:userid},
            success:function(datanew){
                var htmldata ='';
                var wishlistid =[];
                var wishlisttype =[];
                for(var j=0; j<datanew.thumbnail.length; j++){
                    wishlistid.push(datanew.thumbnail[j].videoid);
                }
                var json = JSON.parse(data);
                if(json.count>0 && (offset==1)){
                    $(".title").append('<h4 class="title text-light text-capitalize ms-3 mt-2"><?= $_GET['name'] ?></h4>');
                }
                else if(json.count==0 && (offset==1)){
                    $(".title").append('<h4 class="title text-light text-center mt-4 text-capitalize ms-3 mt-2">No Videos Available!</h4>');
                }
                        for(var i=0; i<json.count; i++){
                    htmldata = htmldata + '\
                    <a href="movie?id='+json.poster[i].videoid+'"><div class="thumbnail position-relative">\
                    <img src="'+json.poster[i].url+'" class="thumbimage me-3 mb-3">\
                    <div class="thumbnailcontent position-absolute p-2" >\
                    <p class="thumbtitle fw-bold text-light mb-0 text-capitalize">'+json.poster[i].title+'</p>\
                    <p class="thumbgenre text-light mb-0 text-capitalize">'+json.thumbnail[i].genre+'</p>\
                    <button class="play" href="#"><i class="bi bi-play-fill"></i>&nbsp;Play</button>';
                    if(wishlistid.includes(json.poster[i].videoid)){
                        htmldata = htmldata + '<button class="watchlist text-uppercase" value="'+json.poster[i].videoid+', 0"href="#">\u2713 REMOVE FROM WATCHLIST</button>';
                    }
                    else{
                        htmldata = htmldata + '<button class="watchlist text-uppercase" value="'+json.poster[i].videoid+', 0"href="#">+ ADD TO WATCHLIST</button>';
                    }
                    htmldata = htmldata + '</div>\
                    </div></a>';
                }
                $(".list").append(htmldata);
            }
        });
        }
        else{
        var htmldata ='';
        var json = JSON.parse((data));
        if(json.count>0 && (offset==1)){
            $(".title").append('<h4 class="title text-light text-capitalize ms-3 mt-2"><?= $_GET['name'] ?></h4>');
        }
        else if(json.count==0 && (offset==1)){
            $(".title").append('<h4 class="title text-light text-center mt-4 text-capitalize ms-3 mt-2">No Data Found!</h4>');
        }
        for(var i=0; i<json.count; i++){
            htmldata = htmldata + '\
            <a href="movie?id='+json.poster[i].videoid+'"><div class="thumbnail position-relative">\
            <img src="'+json.poster[i].url+'" class="thumbimage me-3 mb-3">\
            <div class="thumbnailcontent position-absolute p-2" >\
            <p class="thumbtitle fw-bold text-light mb-0 text-capitalize">'+json.poster[i].title+'</p>\
            <p class="thumbgenre text-light mb-0 text-capitalize">'+json.thumbnail[i].genre+'</p>\
            <button class="play" href="#"><i class="bi bi-play-fill"></i>&nbsp;Play</button>\
            <button class="watchlist text-uppercase" value="'+json.poster[i].videoid+', 0"href="#">+ ADD TO WATCHLIST</button>\
            </div>\
            </div></a>';
        }
        $(".list").append(htmldata);
        }
    }
});
}
$(document).ready(function(){
    load_content(1);
    var offsetval=2;
    $(window).scroll(function(){
        if(((window.innerHeight + window.scrollY) >= document.body.offsetHeight)){
            load_content(offsetval);
            offsetval = offsetval+1;
        }
    });
});

  $(document).on('mouseover', '.thumbnail', function(){
    var offsets = $(this).offset();
    var width = $(window).width();
    if(width>992){
       if(offsets.left<220){
           $(this).addClass("increase-left");
       }
       else if((width-offsets.left)<540){
           $(this).addClass("increase-right");
       }
       else{
           $(this).addClass("increase"); 
       }
    }
    else if(width<992 && width>560){
       if(offsets.left<180){
           $(this).addClass("increase-left");
       }
       else if((width-offsets.left)<400){
           $(this).addClass("increase-right");
       }
       else{
           $(this).addClass("increase"); 
       }
    }
    // if(width<450){
    //    if(offsets.left<140){
    //        $(this).addClass("increase-left");
    //    }
    //    else if((width-offsets.left)<300){
    //        $(this).addClass("increase-right");
    //    }
    //    else{
    //        $(this).addClass("increase"); 
    //    }
    // }
  })
  $(document).on('mouseout', '.thumbnail', function(){
    var offsets = $(this).offset();
           $(this).removeClass("increase-left increase increase-right");
  });
  $('#movieDropdown').css({'color':'#ffaa05', 'font-weight':'bold'})
</script>
<?php include "footer.php"; ?>
</body>

</html>
