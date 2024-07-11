<?php include "header.php" ?>
    <div class="container-fluid p-0 carouselSlider">
        <?php 
        if(isset($_SESSION['userid']) && $_SESSION['userid']!='') $userid = $_SESSION['userid'];
        else $userid='';
        $url = 'https://srihits.veramasait.com/App/slider_images.php';
        $myvars = 'kids='.$_SESSION['kids'].'&userid='.$userid;
        $ch = curl_init($url);
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $result=curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($result);
        ?>
        <section class="top_slider">
            <?php for($i=0; $i<count($obj->data); $i++){
                $countcarousal = count($obj->data);
            $pagename = $obj->data[$i]->category;
            if($pagename == 'vsc'){
                $pagename = "short-film";
            }
            echo '<div>
                <a href="'.$pagename.'?id='.$obj->data[$i]->videoid.'"><img src="'.$obj->data[$i]->url.'" class="slick-image"></a>
            </div>';
        }
        ?>

        </section>
    </div>
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
        $myvars = 'kids='.$_SESSION['kids'].'&userid='.$userid;
        $ch = curl_init($url);
        curl_setopt( $ch, CURLOPT_POST, 1);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
        curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt( $ch, CURLOPT_HEADER, 0);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
        $category=curl_exec($ch);
        curl_close($ch);
        $categoryjson = json_decode($category);
        //print_r($categoryjson->names);
        $categorylist = array();
        for($i=0; $i<count($categoryjson->names); $i++){
           array_push($categorylist,  $categoryjson->names[$i]);    
        }
        for($i=0;$i<count($categorylist); $i++){
            $data= $categorylist[$i];
            if(count($categoryjson->$data)){
                $count=0;
                //print_r($categoryjson->$data);
                echo '<a class="text-decoration-none" href="Popular?type='.$categorylist[$i].'"><h5 class="text-light  ms-4 mt-2">'.$categorylist[$i].'</h5></a>
                <div  class="container-fluid ps-3">
                <section class="contentlist list'.$i.' mb-3 d-flex flex-wrap ">';
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
                            <p class="thumbgenre text-light mb-0 text-capitalize ps-1">'.$genre.'</p>';
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
                            <p class="thumbgenre text-light mb-0 text-capitalize ps-1">'.$genre.'</p>';
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
                            <p class="thumbgenre text-light mb-0 text-capitalize ps-1">'.$genre.'</p>';
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
                            <p class="thumbgenre text-light mb-0 text-capitalize ps-1">'.$genre.'</p>';
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
                            <p class="thumbgenre text-light mb-0 text-capitalize ps-1">'.$genre.'</p>';
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
            $countdata = count($categoryjson->$data)*5*140;
            $countslides = count($categoryjson->$data)*5;
            echo '</section></div>';
           // if(count($categoryjson->$data)>1){
            echo '<script>
            var width = $(window).width();
            if(width < '.$countdata.'){
            $(".list'.$i.'").slick({
                slidesToShow:(width+75)/160,
                slidesToScroll:(width/160),
                dots: false,
                infinite: false,
                speed: 1000,
                arrows: true,
            });
            }
            </script>';
            }
        }
        
    ?>
    
    <script>
        $(document).ready(function () {
            var numOfCurosal = <?php echo $countcarousal ?>;
            if(numOfCurosal >1)
            $('.top_slider').slick({
                dots:true,
                centerMode: true,
                centerPadding: '40px',
                slidesToShow: 1,
                autoplay: true,
                autoplaySpeed: 4000,
                responsive: [{
                        breakpoint: 768,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '30px',
                            slidesToShow: 1
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            arrows: false,
                            centerMode: true,
                            centerPadding: '20px',
                            slidesToShow: 1
                        }
                    }
                ]
            });
            

        });


//         $('#searchHospital').keyup(function(){
// 			  var query = $('#searchHospital').val();
// 			  if(query.length >= 1){
// 				load_data(($('#searchHospital').val()));
// 			  }
// 			  if(query.length == 0){
// 				  $("#suggesstion-box").hide();
// 			  }
// 			  function load_data(value)
// 				{
// 				  $.ajax({
// 					url:"ajax/searchhospital",
// 					method:"POST",
// 					data:{search:"search", value:value},
// 					success:function(data)
// 					{
// 						$("#suggesstion-box").show();
// 					    $("#suggesstion-box").html(data);
// 					}
// 				  });
// 				}

// 		   });
// 		$('#search').on('search', function () {
// 			$('#suggestion-box').hide()
// 		});
// 		$('#search').on('focus', function () {
			
// 		});
// 		$("#search").focusout(function(){
// 			/*
// 			window.setTimeout(function() {  }, 1000);*/
// 		    $('#suggestion-box').hide();
//             $('#search').val('');

// 		});
// 		$("#suggestion-box li").mousedown(function(){
// 			jQuery('.title-list').click(function () {
// 				window.location.href = $(this).attr('href');
// 			});
// 			//$("#suggesstion-box").hide();
// 		});

// 		$("#search").focus(function(){
// 			if($('#search').val().length == 0){
// 			$('#suggestion-box').hide()
// 			}
// 		});

    $(document).on('mouseover', '.thumbnail', function(){
    var offsets = $(this).offset();
    var width = $(window).width();
    if (width > 992) {
        if (offsets.left < 150) {
            $(this).addClass("increase-left");
        } else if ((width - offsets.left) < 240) {
            $(this).addClass("increase-right");
        } else {
            $(this).addClass("increase");
        }
    } else if (width < 992 && width > 560) {
        if (offsets.left < 130) {
            $(this).addClass("increase-left");
        } else if ((width - offsets.left) < 220) {
            $(this).addClass("increase-right");
        } else {
            $(this).addClass("increase");
        }
    }
    })
    $(document).on('mouseout', '.thumbnail', function () {
    var offsets = $(this).offset();
    $(this).removeClass("increase-left increase increase-right");
    });
    // async function update_watchlist(component, status, id){
    //     let result = await $.ajax({
    //             url:"https://srihits.veramasait.com/App/wishlist.php",
    //             method:"POST",
    //             data:{kids:"<?php echo $_SESSION['kids'] ?>", userid:"<?= $_SESSION['userid'] ?>", status:status, id:id},
    //             success:function(data)
    //             {
    //                 if(data.status="true"){
    //                     if(data.message.includes('Added')){
    //                         component.text('\u2713 Remove from Watchlist');
    //                     }
    //                     else{
    //                         component.text('+ Add to Wishlist');
    //                     }
    //                     snackMsg(data.message);
    //                 }
    //             }
    //         });return 0; 
    // }
    // $(document).on('click', '.watchlist', function(e){
    //     var userid = "<?php echo isset($_SESSION['userid'])?$_SESSION['userid']:'' ?>"
    //     if(userid != ''){
    //         var component = $(this);
    //         component.prop("disabled", true);
    //         var values = $(this).attr('value');
    //         var valuessplit =  values.split(', ');
    //         var id = valuessplit[0];
    //         var status = valuessplit[1];
    //         async function main() {
	   //     var response = await  update_watchlist(component, status, id);
    //         }
    //         main();
    //         component.prop("disabled", false);
    //     }
    //     else{
    //         $('#loginModal').modal('show');
    //     }      
    //     e.preventDefault();
    // });
    </script>
    <?php include "footer.php"; ?>
</body>

</html>