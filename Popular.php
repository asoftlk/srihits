<?php include "header.php"; ?>
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
<?php
 if(isset($_SESSION['userid'])){
        $wish_url = 'https://srihits.veramasait.com/App/wishlist.php';
        $wish_myvars = 'type=list&userid=9&kids=0';
        $wish_ch = curl_init($wish_url);
        curl_setopt( $wish_ch, CURLOPT_POST, 1);
        curl_setopt( $wish_ch, CURLOPT_POSTFIELDS, $wish_myvars);
        curl_setopt( $wish_ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $wish_ch, CURLOPT_HEADER, 0);
        curl_setopt( $wish_ch, CURLOPT_RETURNTRANSFER, 1);
        $wish=curl_exec($wish_ch);
        curl_close($wish_ch);
        $wishlist = json_decode($wish);
        }
        $watchlist = array();
        $navlist = array();
        for($i=0; $i<count($wishlist->thumbnail); $i++){
           array_push($watchlist,  $wishlist->thumbnail[$i]->videoid);  
           array_push($navlist, $wishlist->thumbnail[$i]->nav);
        }
        //$category = file_get_contents('https://srihits.veramasait.com/App/dashboardlist.php');
        $url = 'https://srihits.veramasait.com/App/dashboardlist.php';
        $myvars = 'kids='.$_SESSION['kids'];
        $ch = curl_init($url);
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $category=curl_exec($ch);
        curl_close($ch);
        $categoryjson = json_decode($category);
        //echo $category;
        $data =$_GET['type'];
        //echo count($categoryjson->$type);
        
         echo '<div class="container-fluid ">
                <div class="list mb-3 d-flex flex-wrap ms-2">
                <h5 class="text-light  ms-2 mt-2">'.$_GET['type'].'</h5>
                <div  class="container-fluid p-0">
                <section class="list'.$i.' mb-3 d-flex flex-wrap ">';
            for($j=0; $j<count($categoryjson->$data); $j++){
                $genre= str_replace(' |', ',',$categoryjson->$data[$j]->genre);
                $actualname = $categoryjson->$data[$j]->nav;
                if($actualname == 'vsc'){
                    $pagename = "originals";
                    $status = 2;
                }
                if($actualname == 'series'){
                    $pagename = "series";
                    $status = 1;
                }
                if($actualname == 'movie'){
                    $pagename = "movie";
                    $status = 0;
                }
                echo '  <a href="'.$pagename.'?id='.$categoryjson->$data[$j]->videoid.'"><div class="thumbnail position-relative pt-4 pb-2">
                        <img src="'.$categoryjson->$data[$j]->url.'" class="thumbimage me-3 mb-3">
                        <div class="thumbnailcontent position-absolute p-1 " >
                            <p class="thumbtitle fw-bold text-light mb-0 text-capitalize ps-1">'.$categoryjson->$data[$j]->title.'</p>
                            <p class="thumbgenre text-light mb-0 text-capitalize ps-1">'.$genre.'</p>
                            <button class="play" href="#"><i class="bi bi-play-fill"></i>&nbsp;Play</button>';
                            if(isset($_SESSION['userid'])){
                                if(in_array($categoryjson->$data[$j]->videoid, $watchlist) && in_array($pagename,$navlist)){
                                    echo '<button class="watchlist text-uppercase" value="'.$categoryjson->$data[$j]->videoid.', '.$status.'" href="#">&#x2713; REMOVE FROM WISHLIST</button>';
                                }
                                else{
                                    echo '<button class="watchlist text-uppercase" value="'.$categoryjson->$data[$j]->videoid.', '.$status.'" href="#">+ ADD TO WATCHLIST</button>';
                                }
                            }
                            else{
                                echo '<button class="watchlist text-uppercase" value="'.$categoryjson->$data[$j]->videoid.', '.$status.'" href="#">+ ADD TO WATCHLIST</button>';
                            }
                      echo  '</div>
                    </div></a>';
            }
            echo '</div>
                </div>';
?>
<script>
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
</script>
<?php include "footer.php" ?>