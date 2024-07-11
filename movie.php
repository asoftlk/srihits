<?php 
// include "header.php"; 
session_start(); 
if(!isset($_SESSION['kids'])){
        $_SESSION['kids']=0;
}
$url = 'https://srihits.veramasait.com/App/moviedetails.php';
$myvars = 'type=details&id='.$_GET["id"].'&kids='.$_SESSION['kids'].'&userid='.$_SESSION['userid'];
$id = $_GET["id"];

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
$response= json_decode($response);
// echo '<pre>';
// print_r($response);
// echo '</pre>';

$curl = curl_init();
$orderid = rand(0000000000,999999999);
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://srihits.veramasait.com/demo/hash',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS => array('orderid' => $orderid,'amount' => $response->data->details[0]->countryprice, 'currency'=>$response->data->details[0]->currency),
));

$hash = curl_exec($curl);
// echo $hash;
curl_close($curl);
?>

<!----------------header --------------->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
    echo $meta= '
          <title>Srihits - '.$response->data->details[0]->title.'</title>
          <meta property="og:url" content="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'">
          <meta property="og:type"  content="Video" />
            <meta property="og:title" content="Srihits -'.$response->data->details[0]->title.'">
              <meta name="og:description" content="'.substr($response->data->details[0]->shortdescription, 0, 100).'">
        
          <meta property="og:image" content="'.$response->data->details[0]->images[1]->url.'">
          <meta name="description" content="'.substr($response->data->details[0]->shortdescription, 0, 100).'">
          <meta name="keywords" content="'.str_replace(' |', ',', $response->data->details[0]->genre).'">';
    ?>
    <link rel="shortcut icon" href="assets/images/Srihits-icon.png">
    <link rel="stylesheet" href="bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <link rel="stylesheet" href="assets/css/style.css">
    <script type="text/javascript" src="https://kenwheeler.github.io/slick/slick/slick.js"></script>
    <style>
    input[name="password"] {
        padding-right: 52px;
    }
    .pwd-icon {
        position: absolute;
        right: 0;
        padding: 8px;
        bottom: 0;
        font-size: 25px;
        cursor:pointer;
    }
    .slick-slide {
        outline: none
    }
    .top_slider {
        opacity: 0;
        visibility: hidden;
        transition: opacity 1s ease;
        -webkit-transition: opacity 1s ease;
    }
    .top_slider.slick-initialized {
        visibility: visible;
        opacity: 1;    
    }
    #loginform{
        display:none;
    }
    .pinBox{
        display: none;
        position: relative;
        width: 200px;
        height: 50px;
        /* background-image: url(https://i.stack.imgur.com/JbkZl.png); */
        background-image: url(https://wemartglobal.in/assets/images/JbkZl.png);
        background-size: 50px;
        left: 50%;
        transform: translateX(-50%);
    }
    .pinEntry{
        position: absolute;
        padding-left: 18px;
        font-size: 32px;
        height: 50px;
        letter-spacing: 32px;
        background-color: transparent;
        border: 0;
        outline: none;
        clip: rect(0px, calc(300px - 12px), 50px, 0px);
    }
    #loginsign, .otpSpinner{
        display:none;
    }
    </style>
    <?php
        if($_SESSION['kids']==1){
        echo '<style>
                body, .navbar{
                    //background: linear-gradient(to bottom, #0f6dcb, #062764 300px);
                }
                .top_slider {
                    opacity: 1;
                    visibility: visible;
                    transition: opacity 1s ease;
                    -webkit-transition: opacity 1s ease;
                }
              </style>';
    }
    ?>

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark pb-1">
        <div class="container-fluid">
            <a class="navbar-brand" href="index">
                <img src="assets/images/Srihits-website-logo1.png" alt="" width="160" height="32"
                    class="d-inline-block align-text-top">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse w-100 order-1 order-md-0 dual-collapse2" id="navbarNav">

                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link active " href="#" id="movieDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Movie</a>
                        <ul class="dropdown-menu" aria-labelledby="movieDropdown">
                            <li><a class="dropdown-item" href="language?name=sinhala">Sinhala</a></li>
                            <li><a class="dropdown-item" href="language?name=Tamil">Tamil</a></li>
                            <li><a class="dropdown-item" href="language?name=English">English</a></li>
                            <li><a class="dropdown-item" href="language?name=Hindi">Hindi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active" href="#" id="seriesDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Series</a>
                        <ul class="dropdown-menu" aria-labelledby="seriesDropdown">
                            <li><a class="dropdown-item" href="series-view?name=tv">TV</a></li>
                            <li><a class="dropdown-item" href="series-view?name=web">Web</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active" href="#" id="srihitsDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Srihits Original</a>
                        <ul class="dropdown-menu" aria-labelledby="srihitsDropdown">
                            <li><a class="dropdown-item" href="Srihits-Originals?type=videoalbum(songs)">Video Album</a></li>
                            <li><a class="dropdown-item" href="Srihits-Originals?type=shortfilm">Short Films</a></li>
                            <li><a class="dropdown-item" href="Srihits-Originals?type=comedydrama">Comedy Drama</a></li>
                        </ul>
                    </li>
                    <?php if($_SESSION['kids']==0){
                    ?>
                    <li class="nav-item">
                        <a class="nav-link active"  class="kids" id="kids" href="#" value="kids">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="15" viewBox="0 0 40 15">
                            <path fill="#FFAA05" fill-rule="evenodd" d="M19.083.884c7.292.115 10.69 2.846 10.192 8.193-.498 5.361-4.211 7.083-11.138 5.165a.512.512 0 01-.372-.437l-.002-.09.8-12.353a.512.512 0 01.52-.478zM8.4.959l.092.014 2.43.617a.512.512 0 01.327.734L8.744 7.087l3.362 5.796a.512.512 0 01-.275.74l-2.708.938a.512.512 0 01-.597-.205l-2.774-4.274-1.197 1.78v2.361a.512.512 0 01-.468.51l-2.565.222a.513.513 0 01-.555-.47L.001 2.253a.512.512 0 01.462-.55l3.02-.284a.512.512 0 01.557.453l.515 4.63 3.38-5.307a.512.512 0 01.558-.22zm7.064 3.453a.512.512 0 01.496.527l-.26 8.682a.512.512 0 01-.512.497h-2.05a.512.512 0 01-.512-.5l-.197-8.683v-.011c0-.283.228-.512.511-.512zM30.11 3.409c1.146-2.477 4.113-3.133 8.9-1.968.274.067.442.34.378.613l-.467 2.015a.512.512 0 01-.682.362c-1.715-.657-3.06-.87-4.034-.64-1.613.38-.983 1.712.563 2.016 1.547.304 5.694.37 5.19 5.112-.327 3.07-3.68 3.93-10.061 2.58a.512.512 0 01-.375-.675l.87-2.402.006-.018a.512.512 0 01.666-.282c2.709 1.096 4.293 1.247 4.755.45.733-1.265-.991-1.239-2.47-1.634-1.48-.395-5.016-1.688-3.239-5.529zm-8.133.826a.512.512 0 00-.556.486l-.299 6.328a.512.512 0 00.427.529c2.782.467 4.253-.584 4.414-3.151.16-2.547-1.168-3.944-3.986-4.192zM14.197 0c.983 0 1.78.79 1.78 1.765 0 .974-.797 1.764-1.78 1.764s-1.78-.79-1.78-1.764c0-.975.797-1.765 1.78-1.765z"/>
                        </svg>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
            </div>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if($_SESSION['kids']==0){
                    ?>
                    <li class="nav-item">
                        <div class="position-relative">
                        <form class="d-flex me-3" id="searchInput">
                            <input class="me-2 mt-2" type="text" id="search" placeholder="Search" aria-label="Search" autocomplete="off">
                            <button type="submit" class="bg-transparent border-0"><i class="bi bi-search"></i></button>
                        </form>
                        <div id="suggestion-box" class="position-absolute mt-1"></div>
                        </div>
                    </li>
                    <?php }if($_SESSION['kids']==1){
                    ?>
                    <li class="nav-item">
                        <button class="kids btn btn-outline-light btn-sm mt-1" value="Exit_Kids">Exit Kids</button>
                    </li>
                    <?php } ?>
                    <?php
                    if(isset($_SESSION['userid'])){
                    echo '<li class="nav-item dropdown">
                         <a class="nav-link active " href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26px" height="26px" viewBox="0 0 38 38" version="1.1">
                        <!-- Generator: sketchtool 41.2 (35397) - http://www.bohemiancoding.com/sketch -->
                        <title>41351265-3188-4B78-B68D-0DA9FF22EEA6</title>
                        <desc>Created with sketchtool.</desc>
                        <defs/>
                        <g id="My-Account" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-1148.000000, -17.000000)" stroke="rgba(200,200,200,0.7)" stroke-width="0.5" fill="rgba(200,200,200,0.7)">
                                <g id="Navigation-Bar" transform="translate(135.000000, 0.000000)">
                                    <g id="Sign-In" transform="translate(1004.000000, 0.000000)">
                                        <path d="M28,18 C18.0674027,18 10,26.037263 10,35.9327522 C10,41.6567002 12.709295,46.7478329 16.9075,50.0323786 C17.1129485,50.1931149 17.3250129,50.3512229 17.5375,50.5031133 C17.5983753,50.5475313 17.6557686,50.5938509 17.7175,50.637609 C17.8072674,50.7000845 17.8965482,50.7560598 17.9875,50.8169365 C18.1796982,50.9475924 18.3727814,51.0738863 18.5725,51.1980075 C18.618755,51.2264216 18.6609693,51.2596631 18.7075,51.2876712 C18.7908429,51.3384016 18.8704353,51.3950246 18.955,51.4445828 C19.1073808,51.5329934 19.2723263,51.6071203 19.4275,51.6911582 C19.6791141,51.8289125 19.9314935,51.9675076 20.1925,52.0946451 C20.4582009,52.2240686 20.7278128,52.3354791 21.0025,52.4533001 C23.2526786,53.4184688 25.7842202,54 28.405,54 C29.7716327,54 31.1686919,53.7239446 32.5,53.3051059 C35.1985895,52.6124999 37.6459271,51.2931601 39.7,49.5392279 C39.7851004,49.4723954 39.8503965,49.4230983 39.925,49.3599004 C39.9690006,49.3211004 40.0163846,49.287041 40.06,49.2478207 C40.0768862,49.2326847 40.0887611,49.2179225 40.105,49.2029888 C40.1917247,49.1244512 40.2673305,49.0366001 40.3525,48.9564134 C43.8260846,45.6860289 46,41.0639194 46,35.9327522 C46,26.037263 37.9325973,18 28,18 L28,18 Z M28,19.4346202 C37.1543637,19.4346202 44.56,26.8125891 44.56,35.9327522 C44.56,40.4586876 42.746225,44.5651387 39.79,47.5442092 C38.3881643,46.489191 36.7137381,45.9171369 35.29,45.3474471 C33.7297125,44.723119 32.6189001,44.1083707 32.275,43.2851806 C32.198505,42.3519451 32.2026472,41.6148688 32.2075,40.7297634 C32.3011158,40.6282791 32.4351323,40.5582366 32.5225,40.4383562 C32.7198203,40.167606 32.9091184,39.8345475 33.085,39.4744707 C33.3917956,38.8463768 33.6128241,38.0930685 33.7375,37.3449564 C33.9638666,37.2285657 34.2039952,37.2001918 34.39,36.9638854 C34.7373258,36.5226307 34.9814296,35.8953775 35.0875,35.0136986 C35.1824054,34.2288603 34.9195931,33.7109459 34.5925,33.3100872 C34.9440335,32.1726048 35.3930579,30.3332274 35.245,28.4458281 C35.1641894,27.4156805 34.8983027,26.3869595 34.2775,25.5317559 C33.7086266,24.7480888 32.7863289,24.1752537 31.6225,23.9402242 C30.866729,22.9633013 29.503617,22.5952677 27.9325,22.5952677 L27.91,22.5952677 C24.5463674,22.65696 22.3986909,24.0116155 21.475,26.1145704 C20.5953062,28.1173582 20.7923457,30.6483632 21.43,33.2652553 C21.0863483,33.6650273 20.8152374,34.2037049 20.9125,35.0136986 C21.0189527,35.8952304 21.262847,36.5226845 21.61,36.9638854 C21.8006697,37.20621 22.0525221,37.2286073 22.285,37.3449564 C22.4126243,38.0951401 22.6224222,38.8477806 22.9375,39.4744707 C23.118598,39.8346752 23.321548,40.168616 23.5225,40.4383562 C23.6114762,40.5577897 23.7431966,40.6291764 23.8375,40.7297634 C23.842252,41.6146436 23.8465648,42.3517127 23.77,43.2851806 C23.4274132,44.1042397 22.3138288,44.7030157 20.755,45.3250311 C19.3187015,45.898154 17.6244126,46.4804534 16.21,47.5442092 C13.2537754,44.5651387 11.44,40.4586876 11.44,35.9327522 C11.44,26.8125891 18.8456363,19.4346202 28,19.4346202 L28,19.4346202 Z M27.9325,24.0298879 C27.9415648,24.0298879 27.9459784,24.0298552 27.955,24.0298879 C29.4046264,24.0351458 30.3427007,24.4587972 30.61,24.9265255 L30.79,25.2179328 L31.1275,25.2627646 C32.1289854,25.4014171 32.7026627,25.8034507 33.1075,26.3611457 C33.5123373,26.9188407 33.7374906,27.6973158 33.805,28.5579078 C33.9400194,30.2790912 33.4431928,32.2820161 33.13,33.2204234 L32.95,33.7808219 L33.445,34.0722291 C33.4139536,34.0534571 33.7195439,34.2610051 33.6475,34.856787 C33.5627704,35.5610808 33.3944942,35.9251501 33.265,36.0896638 C33.1355058,36.2541774 33.0680037,36.2461263 33.0625,36.2465753 L32.455,36.2914072 L32.3875,36.8742217 C32.3207632,37.4949065 32.0702975,38.2525072 31.78,38.8468244 C31.6348516,39.143983 31.4845574,39.40535 31.3525,39.5865504 C31.2204426,39.7677509 31.0809902,39.8691972 31.15,39.8331258 L30.7675,40.0348692 L30.7675,40.4607721 C30.7675,41.4991896 30.7256752,42.3515993 30.835,43.5541719 L30.835,43.6438356 L30.88,43.7334994 C31.4731259,45.3239085 33.1104837,46.0139573 34.75,46.6699875 C36.0952005,47.2082513 37.4519757,47.779984 38.575,48.5305106 C38.3389019,48.7190498 38.252049,48.8299 37.9,49.0684932 C37.1886998,49.5505607 36.2586736,50.1152917 35.2225,50.637609 C34.2124638,51.1467499 33.0980046,51.6112835 31.96,51.9601494 C31.9305506,51.9691775 31.8994739,51.9737023 31.87,51.9825654 C30.6273916,52.2786645 29.3344502,52.4308842 28,52.4308842 C26.4228155,52.4308842 24.8994395,52.2124181 23.455,51.8032379 C21.1417624,51.0905336 19.0525082,49.9291978 17.4475,48.5305106 C18.5785689,47.7804352 19.9446551,47.2088122 21.295,46.6699875 C22.934206,46.0158997 24.5727633,45.3196865 25.165,43.7334994 L25.1875,43.6438356 L25.21,43.5541719 C25.3192996,42.351892 25.2775,41.4995139 25.2775,40.4607721 L25.2775,40.0348692 L24.895,39.8331258 C24.9606784,39.867363 24.805828,39.7688763 24.67,39.5865504 C24.534172,39.4042281 24.369382,39.143945 24.22,38.8468244 C23.9212367,38.2525832 23.6782778,37.4884371 23.6125,36.8742217 L23.545,36.2914072 L22.9375,36.2465753 C22.932028,36.2461292 22.864487,36.254229 22.735,36.0896638 C22.605513,35.9250963 22.4375673,35.5612279 22.3525,34.856787 C22.2809421,34.2608595 22.5860514,34.053399 22.555,34.0722291 L23.0275,33.7808219 L22.8925,33.2652553 C22.2146524,30.6662838 22.0973709,28.3027441 22.8025,26.6973848 C23.505647,25.0965393 24.9386061,24.0903763 27.9325,24.0298879 L27.9325,24.0298879 Z" id="Shape"/>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg></a>
                    <ul class="dropdown-menu dropdown-menu-end end-0" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="watchlist">Watchlist</a></li>
                            <li><a class="dropdown-item" href="profile">My Account</a></li>
                            <li><a class="dropdown-item" href="logout">Logout</a></li>
                        </ul>
                    </li>';
                    }
                    else{
                        echo '<li class="nav-item">
                            <a class="nav-link active" href="#" id="Login" data-bs-toggle="modal" data-bs-target="#loginModal">Login</a>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

<!-- Mobiel side menu -->
<div class="mobileview position-relative justify-content-between mt-1">
<button class="btn btn-dark bg-transparent border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasExample" aria-controls="offcanvasExample">
<i class="bi bi-list fs-4"></i>
</button>
    <div class="d-flex">
    <div class="">
        <form class="d-flex me-3" id="searchInput1">
            <input class="me-2 mt-2" type="text" id="search1" placeholder="Search" aria-label="Search" autocomplete="off">
            <button type="submit" class="bg-transparent border-0"><i class="bi bi-search"></i></button>
        </form>
    <div id="suggestion-box1" class="position-absolute mt-1"></div>
    </div>
    <?php
        if(isset($_SESSION['userid'])){
        echo '
                <a class="nav-link active " href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                aria-expanded="false"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26px" height="26px" viewBox="0 0 38 38" version="1.1">
            <!-- Generator: sketchtool 41.2 (35397) - http://www.bohemiancoding.com/sketch -->
            <title>41351265-3188-4B78-B68D-0DA9FF22EEA6</title>
            <desc>Created with sketchtool.</desc>
            <defs/>
            <g id="My-Account" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                <g transform="translate(-1148.000000, -17.000000)" stroke="rgba(200,200,200,0.7)" stroke-width="0.5" fill="rgba(200,200,200,0.7)">
                    <g id="Navigation-Bar" transform="translate(135.000000, 0.000000)">
                        <g id="Sign-In" transform="translate(1004.000000, 0.000000)">
                            <path d="M28,18 C18.0674027,18 10,26.037263 10,35.9327522 C10,41.6567002 12.709295,46.7478329 16.9075,50.0323786 C17.1129485,50.1931149 17.3250129,50.3512229 17.5375,50.5031133 C17.5983753,50.5475313 17.6557686,50.5938509 17.7175,50.637609 C17.8072674,50.7000845 17.8965482,50.7560598 17.9875,50.8169365 C18.1796982,50.9475924 18.3727814,51.0738863 18.5725,51.1980075 C18.618755,51.2264216 18.6609693,51.2596631 18.7075,51.2876712 C18.7908429,51.3384016 18.8704353,51.3950246 18.955,51.4445828 C19.1073808,51.5329934 19.2723263,51.6071203 19.4275,51.6911582 C19.6791141,51.8289125 19.9314935,51.9675076 20.1925,52.0946451 C20.4582009,52.2240686 20.7278128,52.3354791 21.0025,52.4533001 C23.2526786,53.4184688 25.7842202,54 28.405,54 C29.7716327,54 31.1686919,53.7239446 32.5,53.3051059 C35.1985895,52.6124999 37.6459271,51.2931601 39.7,49.5392279 C39.7851004,49.4723954 39.8503965,49.4230983 39.925,49.3599004 C39.9690006,49.3211004 40.0163846,49.287041 40.06,49.2478207 C40.0768862,49.2326847 40.0887611,49.2179225 40.105,49.2029888 C40.1917247,49.1244512 40.2673305,49.0366001 40.3525,48.9564134 C43.8260846,45.6860289 46,41.0639194 46,35.9327522 C46,26.037263 37.9325973,18 28,18 L28,18 Z M28,19.4346202 C37.1543637,19.4346202 44.56,26.8125891 44.56,35.9327522 C44.56,40.4586876 42.746225,44.5651387 39.79,47.5442092 C38.3881643,46.489191 36.7137381,45.9171369 35.29,45.3474471 C33.7297125,44.723119 32.6189001,44.1083707 32.275,43.2851806 C32.198505,42.3519451 32.2026472,41.6148688 32.2075,40.7297634 C32.3011158,40.6282791 32.4351323,40.5582366 32.5225,40.4383562 C32.7198203,40.167606 32.9091184,39.8345475 33.085,39.4744707 C33.3917956,38.8463768 33.6128241,38.0930685 33.7375,37.3449564 C33.9638666,37.2285657 34.2039952,37.2001918 34.39,36.9638854 C34.7373258,36.5226307 34.9814296,35.8953775 35.0875,35.0136986 C35.1824054,34.2288603 34.9195931,33.7109459 34.5925,33.3100872 C34.9440335,32.1726048 35.3930579,30.3332274 35.245,28.4458281 C35.1641894,27.4156805 34.8983027,26.3869595 34.2775,25.5317559 C33.7086266,24.7480888 32.7863289,24.1752537 31.6225,23.9402242 C30.866729,22.9633013 29.503617,22.5952677 27.9325,22.5952677 L27.91,22.5952677 C24.5463674,22.65696 22.3986909,24.0116155 21.475,26.1145704 C20.5953062,28.1173582 20.7923457,30.6483632 21.43,33.2652553 C21.0863483,33.6650273 20.8152374,34.2037049 20.9125,35.0136986 C21.0189527,35.8952304 21.262847,36.5226845 21.61,36.9638854 C21.8006697,37.20621 22.0525221,37.2286073 22.285,37.3449564 C22.4126243,38.0951401 22.6224222,38.8477806 22.9375,39.4744707 C23.118598,39.8346752 23.321548,40.168616 23.5225,40.4383562 C23.6114762,40.5577897 23.7431966,40.6291764 23.8375,40.7297634 C23.842252,41.6146436 23.8465648,42.3517127 23.77,43.2851806 C23.4274132,44.1042397 22.3138288,44.7030157 20.755,45.3250311 C19.3187015,45.898154 17.6244126,46.4804534 16.21,47.5442092 C13.2537754,44.5651387 11.44,40.4586876 11.44,35.9327522 C11.44,26.8125891 18.8456363,19.4346202 28,19.4346202 L28,19.4346202 Z M27.9325,24.0298879 C27.9415648,24.0298879 27.9459784,24.0298552 27.955,24.0298879 C29.4046264,24.0351458 30.3427007,24.4587972 30.61,24.9265255 L30.79,25.2179328 L31.1275,25.2627646 C32.1289854,25.4014171 32.7026627,25.8034507 33.1075,26.3611457 C33.5123373,26.9188407 33.7374906,27.6973158 33.805,28.5579078 C33.9400194,30.2790912 33.4431928,32.2820161 33.13,33.2204234 L32.95,33.7808219 L33.445,34.0722291 C33.4139536,34.0534571 33.7195439,34.2610051 33.6475,34.856787 C33.5627704,35.5610808 33.3944942,35.9251501 33.265,36.0896638 C33.1355058,36.2541774 33.0680037,36.2461263 33.0625,36.2465753 L32.455,36.2914072 L32.3875,36.8742217 C32.3207632,37.4949065 32.0702975,38.2525072 31.78,38.8468244 C31.6348516,39.143983 31.4845574,39.40535 31.3525,39.5865504 C31.2204426,39.7677509 31.0809902,39.8691972 31.15,39.8331258 L30.7675,40.0348692 L30.7675,40.4607721 C30.7675,41.4991896 30.7256752,42.3515993 30.835,43.5541719 L30.835,43.6438356 L30.88,43.7334994 C31.4731259,45.3239085 33.1104837,46.0139573 34.75,46.6699875 C36.0952005,47.2082513 37.4519757,47.779984 38.575,48.5305106 C38.3389019,48.7190498 38.252049,48.8299 37.9,49.0684932 C37.1886998,49.5505607 36.2586736,50.1152917 35.2225,50.637609 C34.2124638,51.1467499 33.0980046,51.6112835 31.96,51.9601494 C31.9305506,51.9691775 31.8994739,51.9737023 31.87,51.9825654 C30.6273916,52.2786645 29.3344502,52.4308842 28,52.4308842 C26.4228155,52.4308842 24.8994395,52.2124181 23.455,51.8032379 C21.1417624,51.0905336 19.0525082,49.9291978 17.4475,48.5305106 C18.5785689,47.7804352 19.9446551,47.2088122 21.295,46.6699875 C22.934206,46.0158997 24.5727633,45.3196865 25.165,43.7334994 L25.1875,43.6438356 L25.21,43.5541719 C25.3192996,42.351892 25.2775,41.4995139 25.2775,40.4607721 L25.2775,40.0348692 L24.895,39.8331258 C24.9606784,39.867363 24.805828,39.7688763 24.67,39.5865504 C24.534172,39.4042281 24.369382,39.143945 24.22,38.8468244 C23.9212367,38.2525832 23.6782778,37.4884371 23.6125,36.8742217 L23.545,36.2914072 L22.9375,36.2465753 C22.932028,36.2461292 22.864487,36.254229 22.735,36.0896638 C22.605513,35.9250963 22.4375673,35.5612279 22.3525,34.856787 C22.2809421,34.2608595 22.5860514,34.053399 22.555,34.0722291 L23.0275,33.7808219 L22.8925,33.2652553 C22.2146524,30.6662838 22.0973709,28.3027441 22.8025,26.6973848 C23.505647,25.0965393 24.9386061,24.0903763 27.9325,24.0298879 L27.9325,24.0298879 Z" id="Shape"/>
                        </g>
                    </g>
                </g>
            </g>
        </svg></a>
        <ul class="dropdown-menu dropdown-menu-end end-0" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" href="watchlist">Watchlist</a></li>
                <li><a class="dropdown-item" href="profile">My Account</a></li>
                <li><a class="dropdown-item" href="logout">Logout</a></li>
            </ul>';
        }
        else{
            echo '<a class="nav-link active" href="#" id="Login" data-bs-toggle="modal" data-bs-target="#loginModal">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="26px" height="26px" viewBox="0 0 38 38" version="1.1">
                        <!-- Generator: sketchtool 41.2 (35397) - http://www.bohemiancoding.com/sketch -->
                        <title>41351265-3188-4B78-B68D-0DA9FF22EEA6</title>
                        <desc>Created with sketchtool.</desc>
                        <defs/>
                        <g id="My-Account" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <g transform="translate(-1148.000000, -17.000000)" stroke="rgba(200,200,200,0.7)" stroke-width="0.5" fill="rgba(200,200,200,0.7)">
                                <g id="Navigation-Bar" transform="translate(135.000000, 0.000000)">
                                    <g id="Sign-In" transform="translate(1004.000000, 0.000000)">
                                        <path d="M28,18 C18.0674027,18 10,26.037263 10,35.9327522 C10,41.6567002 12.709295,46.7478329 16.9075,50.0323786 C17.1129485,50.1931149 17.3250129,50.3512229 17.5375,50.5031133 C17.5983753,50.5475313 17.6557686,50.5938509 17.7175,50.637609 C17.8072674,50.7000845 17.8965482,50.7560598 17.9875,50.8169365 C18.1796982,50.9475924 18.3727814,51.0738863 18.5725,51.1980075 C18.618755,51.2264216 18.6609693,51.2596631 18.7075,51.2876712 C18.7908429,51.3384016 18.8704353,51.3950246 18.955,51.4445828 C19.1073808,51.5329934 19.2723263,51.6071203 19.4275,51.6911582 C19.6791141,51.8289125 19.9314935,51.9675076 20.1925,52.0946451 C20.4582009,52.2240686 20.7278128,52.3354791 21.0025,52.4533001 C23.2526786,53.4184688 25.7842202,54 28.405,54 C29.7716327,54 31.1686919,53.7239446 32.5,53.3051059 C35.1985895,52.6124999 37.6459271,51.2931601 39.7,49.5392279 C39.7851004,49.4723954 39.8503965,49.4230983 39.925,49.3599004 C39.9690006,49.3211004 40.0163846,49.287041 40.06,49.2478207 C40.0768862,49.2326847 40.0887611,49.2179225 40.105,49.2029888 C40.1917247,49.1244512 40.2673305,49.0366001 40.3525,48.9564134 C43.8260846,45.6860289 46,41.0639194 46,35.9327522 C46,26.037263 37.9325973,18 28,18 L28,18 Z M28,19.4346202 C37.1543637,19.4346202 44.56,26.8125891 44.56,35.9327522 C44.56,40.4586876 42.746225,44.5651387 39.79,47.5442092 C38.3881643,46.489191 36.7137381,45.9171369 35.29,45.3474471 C33.7297125,44.723119 32.6189001,44.1083707 32.275,43.2851806 C32.198505,42.3519451 32.2026472,41.6148688 32.2075,40.7297634 C32.3011158,40.6282791 32.4351323,40.5582366 32.5225,40.4383562 C32.7198203,40.167606 32.9091184,39.8345475 33.085,39.4744707 C33.3917956,38.8463768 33.6128241,38.0930685 33.7375,37.3449564 C33.9638666,37.2285657 34.2039952,37.2001918 34.39,36.9638854 C34.7373258,36.5226307 34.9814296,35.8953775 35.0875,35.0136986 C35.1824054,34.2288603 34.9195931,33.7109459 34.5925,33.3100872 C34.9440335,32.1726048 35.3930579,30.3332274 35.245,28.4458281 C35.1641894,27.4156805 34.8983027,26.3869595 34.2775,25.5317559 C33.7086266,24.7480888 32.7863289,24.1752537 31.6225,23.9402242 C30.866729,22.9633013 29.503617,22.5952677 27.9325,22.5952677 L27.91,22.5952677 C24.5463674,22.65696 22.3986909,24.0116155 21.475,26.1145704 C20.5953062,28.1173582 20.7923457,30.6483632 21.43,33.2652553 C21.0863483,33.6650273 20.8152374,34.2037049 20.9125,35.0136986 C21.0189527,35.8952304 21.262847,36.5226845 21.61,36.9638854 C21.8006697,37.20621 22.0525221,37.2286073 22.285,37.3449564 C22.4126243,38.0951401 22.6224222,38.8477806 22.9375,39.4744707 C23.118598,39.8346752 23.321548,40.168616 23.5225,40.4383562 C23.6114762,40.5577897 23.7431966,40.6291764 23.8375,40.7297634 C23.842252,41.6146436 23.8465648,42.3517127 23.77,43.2851806 C23.4274132,44.1042397 22.3138288,44.7030157 20.755,45.3250311 C19.3187015,45.898154 17.6244126,46.4804534 16.21,47.5442092 C13.2537754,44.5651387 11.44,40.4586876 11.44,35.9327522 C11.44,26.8125891 18.8456363,19.4346202 28,19.4346202 L28,19.4346202 Z M27.9325,24.0298879 C27.9415648,24.0298879 27.9459784,24.0298552 27.955,24.0298879 C29.4046264,24.0351458 30.3427007,24.4587972 30.61,24.9265255 L30.79,25.2179328 L31.1275,25.2627646 C32.1289854,25.4014171 32.7026627,25.8034507 33.1075,26.3611457 C33.5123373,26.9188407 33.7374906,27.6973158 33.805,28.5579078 C33.9400194,30.2790912 33.4431928,32.2820161 33.13,33.2204234 L32.95,33.7808219 L33.445,34.0722291 C33.4139536,34.0534571 33.7195439,34.2610051 33.6475,34.856787 C33.5627704,35.5610808 33.3944942,35.9251501 33.265,36.0896638 C33.1355058,36.2541774 33.0680037,36.2461263 33.0625,36.2465753 L32.455,36.2914072 L32.3875,36.8742217 C32.3207632,37.4949065 32.0702975,38.2525072 31.78,38.8468244 C31.6348516,39.143983 31.4845574,39.40535 31.3525,39.5865504 C31.2204426,39.7677509 31.0809902,39.8691972 31.15,39.8331258 L30.7675,40.0348692 L30.7675,40.4607721 C30.7675,41.4991896 30.7256752,42.3515993 30.835,43.5541719 L30.835,43.6438356 L30.88,43.7334994 C31.4731259,45.3239085 33.1104837,46.0139573 34.75,46.6699875 C36.0952005,47.2082513 37.4519757,47.779984 38.575,48.5305106 C38.3389019,48.7190498 38.252049,48.8299 37.9,49.0684932 C37.1886998,49.5505607 36.2586736,50.1152917 35.2225,50.637609 C34.2124638,51.1467499 33.0980046,51.6112835 31.96,51.9601494 C31.9305506,51.9691775 31.8994739,51.9737023 31.87,51.9825654 C30.6273916,52.2786645 29.3344502,52.4308842 28,52.4308842 C26.4228155,52.4308842 24.8994395,52.2124181 23.455,51.8032379 C21.1417624,51.0905336 19.0525082,49.9291978 17.4475,48.5305106 C18.5785689,47.7804352 19.9446551,47.2088122 21.295,46.6699875 C22.934206,46.0158997 24.5727633,45.3196865 25.165,43.7334994 L25.1875,43.6438356 L25.21,43.5541719 C25.3192996,42.351892 25.2775,41.4995139 25.2775,40.4607721 L25.2775,40.0348692 L24.895,39.8331258 C24.9606784,39.867363 24.805828,39.7688763 24.67,39.5865504 C24.534172,39.4042281 24.369382,39.143945 24.22,38.8468244 C23.9212367,38.2525832 23.6782778,37.4884371 23.6125,36.8742217 L23.545,36.2914072 L22.9375,36.2465753 C22.932028,36.2461292 22.864487,36.254229 22.735,36.0896638 C22.605513,35.9250963 22.4375673,35.5612279 22.3525,34.856787 C22.2809421,34.2608595 22.5860514,34.053399 22.555,34.0722291 L23.0275,33.7808219 L22.8925,33.2652553 C22.2146524,30.6662838 22.0973709,28.3027441 22.8025,26.6973848 C23.505647,25.0965393 24.9386061,24.0903763 27.9325,24.0298879 L27.9325,24.0298879 Z" id="Shape"/>
                                    </g>
                                </g>
                            </g>
                        </g>
                    </svg>
                </a>';
        }
    ?>
    </div>
</div>
<div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
  <div class="offcanvas-header">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">
        <a class="navbar-brand" href="index">
            <img src="assets/images/Srihits-website-logo1.png" alt="" width="160" height="32" class="d-inline-block align-text-top">
        </a>
    </h5>
    <button type="button" class="bg-transparent border-0 text-light" data-bs-dismiss="offcanvas" aria-label="Close"><i class="bi bi-x-lg"></i></button>
  </div>
  <div class="offcanvas-body">
      
  <div class="container-fluid">
            <div class="collapse navbar-collapse w-100 order-1 order-md-0 dual-collapse2 show" id="navbarNav">
                <?php if($_SESSION['kids']==0){
                ?>
                <ul class="navbar-nav me-auto">
                    <li class="nav-item dropdown">
                        <a class="nav-link active " href="#" id="movieDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Movie</a>
                        <ul class="dropdown-menu" aria-labelledby="movieDropdown">
                            <li><a class="dropdown-item" href="language?name=sinhala">Sinhala</a></li>
                            <li><a class="dropdown-item" href="language?name=Tamil">Tamil</a></li>
                            <li><a class="dropdown-item" href="language?name=English">English</a></li>
                            <li><a class="dropdown-item" href="language?name=Hindi">Hindi</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active" href="#" id="seriesDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Series</a>
                        <ul class="dropdown-menu" aria-labelledby="seriesDropdown">
                            <li><a class="dropdown-item" href="#">TV</a></li>
                            <li><a class="dropdown-item" href="#">Web</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link active" href="#" id="srihitsDropdown" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">Srihits Original</a>
                        <ul class="dropdown-menu" aria-labelledby="srihitsDropdown">
                            <li><a class="dropdown-item" href="Srihits-Originals?type=videoalbum(songs)">Video Album</a></li>
                            <li><a class="dropdown-item" href="Srihits-Originals?type=shortfilm">Short Films</a></li>
                            <li><a class="dropdown-item" href="Srihits-Originals?type=comedydrama">Comedy Drama</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" class="kids" id="kids" href="#" value="kids">
                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="15" viewBox="0 0 40 15">
                            <path fill="#FFAA05" fill-rule="evenodd" d="M19.083.884c7.292.115 10.69 2.846 10.192 8.193-.498 5.361-4.211 7.083-11.138 5.165a.512.512 0 01-.372-.437l-.002-.09.8-12.353a.512.512 0 01.52-.478zM8.4.959l.092.014 2.43.617a.512.512 0 01.327.734L8.744 7.087l3.362 5.796a.512.512 0 01-.275.74l-2.708.938a.512.512 0 01-.597-.205l-2.774-4.274-1.197 1.78v2.361a.512.512 0 01-.468.51l-2.565.222a.513.513 0 01-.555-.47L.001 2.253a.512.512 0 01.462-.55l3.02-.284a.512.512 0 01.557.453l.515 4.63 3.38-5.307a.512.512 0 01.558-.22zm7.064 3.453a.512.512 0 01.496.527l-.26 8.682a.512.512 0 01-.512.497h-2.05a.512.512 0 01-.512-.5l-.197-8.683v-.011c0-.283.228-.512.511-.512zM30.11 3.409c1.146-2.477 4.113-3.133 8.9-1.968.274.067.442.34.378.613l-.467 2.015a.512.512 0 01-.682.362c-1.715-.657-3.06-.87-4.034-.64-1.613.38-.983 1.712.563 2.016 1.547.304 5.694.37 5.19 5.112-.327 3.07-3.68 3.93-10.061 2.58a.512.512 0 01-.375-.675l.87-2.402.006-.018a.512.512 0 01.666-.282c2.709 1.096 4.293 1.247 4.755.45.733-1.265-.991-1.239-2.47-1.634-1.48-.395-5.016-1.688-3.239-5.529zm-8.133.826a.512.512 0 00-.556.486l-.299 6.328a.512.512 0 00.427.529c2.782.467 4.253-.584 4.414-3.151.16-2.547-1.168-3.944-3.986-4.192zM14.197 0c.983 0 1.78.79 1.78 1.765 0 .974-.797 1.764-1.78 1.764s-1.78-.79-1.78-1.764c0-.975.797-1.765 1.78-1.765z"/>
                        </svg>
                        </a>
                    </li>
                </ul>
                <?php } ?>
            </div>
            <div class="navbar-collapse collapse w-100 order-3 dual-collapse2 show" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if($_SESSION['kids']==1){
                    ?>
                    <li class="nav-item">
                        <button class="kids btn btn-outline-light btn-sm mt-1" value="Exit_Kids">Exit Kids</button>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
  </div>
</div>
<!-- Mobiel view end -->

<!-- Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header border-bottom-0">
        <h5 class="modal-title" id="loginModalLabel"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-5 text-light">
        <form method="POST" action="" id="loginsignup">
            <h6 class="mb-5">Login | Sign up</h6>
            <div class="row mb-3">
            <div class="col-sm-12 mb-3">
                <select class="form-select form-control countryCode" name="mobileCode" id="mobileCode">
                    <option selected value="">Country code</option>
                </select>
            </div>
            <div class="d-flex col-sm-12 mb-3">
                <input type="hidden" name="info" id="info">
                <input type="text" class="form-control" name="contact" id="contact" placeholder="Mobile number (Eg: 777123123)">
                <button type="button" class="btn btn-primary ms-2 otpreq"><span>Get&nbsp;OTP</span>
                <div class="spinner-border text-light otpSpinner" role="status">
                  <span class="visually-hidden">Loading...</span>
                </div>
                </button>
            </div>
            <div class="d-flex col-sm-12 mb-3">
                <div class="mb-3 mt-3 pinBox">
                    <input type="number" class="pinEntry" id="loginotp" name="otp" maxlength="4" autocomplete="off" data-gtm-form-interact-field-id="1" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">
                </div>
                <input type="hidden" name="id" id="otpid">
            </div>
            <div class="d-flex col-sm-12 mb-3">
              <input type="submit" class="btn btn-primary w-100" name="loginsign" id="loginsign" value="Login >">
            </div>
          </div>
        </form>        
        <form method="POST" action="" id="loginform">
        <h6 class="mb-5">Login to Continue</h6>
            <div class="mb-3">
                <!--<input type="hidden" name="info" id="info">-->
                <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                <input type="text" class="form-control" placeholder="Email / Mobile Number" id="user" name="user">
            </div>
            <div class="mb-3 position-relative">
                <input type="password" class="form-control" name="pwd" id="pwd" placeholder="Password">
                <i class="bi bi-eye pwd-icon"></i>
            </div>
            <div class="input-group mb-3 justify-content-end">
                <a href="">Forgot passoword?</a>
            </div>
            <div class="input-group mb-3 mt-3">
                <input type="submit" class="btn btn-primary w-100" value="Login >" name="loginSubmit" id="loginSubmit">
            </div>
            <div   div class="input-group mb-3 justify-content-center">
                <p>New User? <a href="" class="createAccount fw-bold text-decoration-none">Create Account</a></p>
            </div>
        </form>            
        <form method="POST" action="" id="signupform">
            <h6 class="mb-5">Sign Up</h6>
            <div class="mb-3">
                <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                <input type="text" class="form-control" placeholder="Name" id="userName" name="userName">
            </div>
            <div class="mb-3">
                <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                <input type="email" class="form-control" placeholder="Email Id" id="email" name="email">
            </div>
            <div class="mb-3">
                <!-- <span class="input-group-text" id="basic-addon1">@</span> -->
                <input type="text" class="form-control" placeholder="Mobile Number" id="mobile" name="mobile">
            </div>
            <div class="mb-3 position-relative">
                <input type="password" class="form-control" name="password" id="password" placeholder="password">
                <i class="bi bi-eye pwd-icon"></i>
            </div>

            <div class="input-group mb-3 mt-3">
                <input type="submit" class="btn btn-primary w-100" value="Sign UP >" name="signupSubmit" id="signupSubmit">
            </div>
            <div   div class="input-group mb-3 justify-content-center">
                <p>Already A User? <a href="" class="loginAccount fw-bold text-decoration-none">Login</a></p>
            </div>
        </form>

      </div>
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div> -->
    </div>
  </div>
</div>
<div id="snackbar"></div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
<script>
        function snackMsg(message) {
            //var x = $("#snackbar");
            $("#snackbar").text(message);
            $("#snackbar").addClass("show");
            setTimeout(function(){ $("#snackbar").removeClass("show"); }, 3000);
        }
            // Browser with  Detection
        navigator.sayswho= (function(){
            var N= navigator.appName, ua= navigator.userAgent, tem;
            var M= ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
            if(M && (tem= ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
            M= M? [M[1], M[2]]: [N, navigator.appVersion,'-?'];
            return M;
        })();

        $('#info').val(navigator.sayswho);
        $(document).on('click', '.createAccount', function(e){
            $('#loginform').hide();
            $('#signupform').show();
            e.preventDefault();
        });
        $(document).on('click', '.loginAccount', function(e){
            $('#signupform').hide();
            $('#loginform').show();
            e.preventDefault();
        });
        $(document).on('click', '.otpreq', function(e){
            e.preventDefault();
            if($('.countryCode').val() == ''){
                $('.cntrymsg').remove();
                $('.countryCode').parent().append('<p class="text-danger mt-1 mb-0 cntrymsg">Select Country</p>');
            }
            else{
                if($('.countryCode').val() == '+94,LK'){
                    if(($('#contact').val().length =='9' || $('#contact').val().length =='10') && /^-?\d+$/.test($('#contact').val())){
                        $('.cntmsg').remove();
                        otpRequest();
                    }
                    else{
                        $('.cntmsg').remove();
                        $('<p class="text-danger mt-1 mb-0 cntmsg">Mobile Number Should Be 9-10 Digits</p>').insertAfter($('#contact').parent());
                    }
                }
                else{
                   if(/\S+@\S+\.\S+/.test($('#contact').val())){
                       $('.cntmsg').remove();
                       otpRequest();
                   }
                   else{
                        $('.cntmsg').remove();
                        $('<p class="text-danger mt-1 mb-0 cntmsg">Enter Valid Email Address</p>').insertAfter($('#contact').parent());
                    }
                }
            }
        })
        $(document).on('change', '.countryCode', function(){
            $('.cntrymsg').remove();
            if($('.countryCode').val() == '+94,LK'){
                $('#contact').attr('placeholder', 'Mobile number (Eg: 777123123)');
            }
            else{
                $('#contact').attr('placeholder', 'Email ID');
            }
        })
        function otpRequest(){
            $.ajax({
                type:'POST',
				url: 'https://srihits.veramasait.com/App/sendOTP.php',
				mimeType: "multipart/form-data",
				data:{'contact':$('#contact').val(), 'country':$('#mobileCode').val()},
				beforeSend: function(){
				    $('.otpreq').attr('disabled', true);
				    $('.otpreq span').text('');
				    $('.otpSpinner').show()
				},
				success: function(data){
				    var json = JSON.parse(data);
				    if(json.success){
				        $('#otpid').val(json.id);
				        alert(json.message);
				        var timeleft = 30;
				        var interval = setInterval( function(){
				            if(timeleft <= 0){
                                $('.otpreq span').text('Resend');
                                $('.otpreq').attr('disabled', false);
                                clearInterval(interval);
                            }
                            else{
				            $('.otpreq span').html(timeleft+'&nbsp;S');
				            timeleft -= 1;
                            }
				        }, 1000);
				        $('.otpSpinner').hide()
				        $('.pinBox, #loginsign').show();
				    }
				    else{
				        alert(json.message);
				        $('.otpSpinner').hide()
				        $('.otpreq span').text('Resend');
				        $('.otpreq').attr('disabled', false);
				    }
				},
				error: function(err){
				    
				}
            })
        }
        $(document).on('submit', '#loginsignup', function(e){
            e.preventDefault();
            if($('#loginotp').val().length == 4){
                var form  = $(this);
                $.ajax({
					type:'POST',
					url: 'https://srihits.veramasait.com/App/loginsignup.php',
					mimeType: "multipart/form-data",
					data:form.serialize(),							
					success:function(data){
						var json = JSON.parse(data);
						if(json.success=='true'){
                            // alert(json.message);
                            $.ajax({
    							type:'POST',
    							url: 'ajax/login',
    							data:{id:json.userid},							
    							success:function(data){
    							}
                            })
                            setTimeout(function(){ window.location.href='index.php';}, 1000);									
						}
						else{
							alert(json.message);
						}
					},
					error: function(data){
						alert('Please try Again!');
					}
				});
            }
            else{
               $('.otpmsg').remove();
               $('<p class="text-danger mt-1 mb-3 otpmsg">OTP Should Be 4 Digits</p>').insertAfter($('.pinBox').parent()); 
            }
        })
        $("#signupSubmit").click(function () { 
		var form1 = $("#signupform");
                form1.validate({
                    errorElement: 'span',
                    errorClass: 'help-block',
                    highlight: function(element, errorClass, validClass) {
                        $(element).closest('.form-group').addClass("has-error");
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).closest('.form-group').removeClass("has-error");
                    },
                    rules: {
						userName: {
                            required: true,
					    },		
					    email: {
                            required: true,
                            email: true,
						},
					    mobile: {
					        required: true,
                            rangelength: [10, 12],
					    },
					    password: {
                            required: true,							
						},
						
					},
                    messages: {
						userName:  "Name required",
                        email: {
                            required: "Email id is required",
                        },
						mobile: {   
                            required: "Mobile number is required",                         
							rangelength: "Contact should be 10 digit number",							
                        },											
				        password: {
                            required: "Please enter Password",
                        },
					},
					submitHandler: function(form) {
						$.ajax({
							type:form.method,
							url: 'https://srihits.veramasait.com/App/signup.php',
							mimeType: "multipart/form-data",
							data:$(form).serialize(),							
							success:function(data){
								var json = JSON.parse(data);
								if(json.success=='true'){
                                    alert(json.message);
                                    setTimeout(function(){ window.location.href='index.php';}, 1000);									
								}
								else{
									alert(json.message);
								}
							},
							error: function(data){
								alert('Please try Again!');
							}
						});
					}
						});
				});
        $("#loginSubmit").click(function () { 
		var form1 = $("#loginform");
                form1.validate({
                    errorElement: 'span',
                    errorClass: 'help-block',
                    highlight: function(element, errorClass, validClass) {
                        $(element).closest('.form-group').addClass("has-error");
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).closest('.form-group').removeClass("has-error");
                    },
                    rules: {
					    user: {
                            required: true,
						},
					    pwd: {
                            required: true,							
						},
						
					},
                    messages: {						
                        user: {
                            required: "Email id / Mobile number is required",
                        },										
				        pwd: {
                            required: "Please enter Password",
                        },
					},
					submitHandler: function(form) {
						$.ajax({
							type:form.method,
							url: 'https://srihits.veramasait.com/App/login.php',
							mimeType: "multipart/form-data",
							data:$(form).serialize(),							
							success:function(data){
								var json = JSON.parse(data);
								if(json.success=='true'){
                                    alert(json.message);
                                    $.ajax({
        							type:'POST',
        							url: 'ajax/login',
        							data:{id:json.userid},							
        							success:function(data){
        							}
                                    })
                                    setTimeout(function(){ window.location.href='index.php';}, 1000);									
								}
								else{
									alert(json.message);
								}
							},
							error: function(data){
								alert('Please try Again!');
							}
						});
					}
						});
				});
        $('#search, #search1').keyup(function(){
			  var query = $(this).val();
			  if(query.length >= 1){
				load_data(query);
			  }
			  if(query.length == 0){
				  $("#suggestion-box").hide();
				  $("#suggestion-box1").hide();
			  }
			  function load_data(value)
				{
				  $.ajax({
					url:"https://srihits.veramasait.com/App/search.php",
					method:"POST",
					data:{kids:"<?php echo $_SESSION['kids'] ?>", name:value, userid:"<?= isset($_SESSION['userid'])?$_SESSION['userid']:''?>"},
					success:function(data)
					{
                        var json = JSON.parse(JSON.stringify(data));
                        var htmldata ='';
                        htmldata = '<ul id="title-list"  class="mb-1 ps-1" style="list-style-type:none;">';
                        if(json.thumbnail.length>0){
                        for(var i = 0 ; i< json.thumbnail.length ; i++){
						    $("#suggestion-box").show();
						     $("#suggestion-box1").show();
						    var status = json.poster[i].status;
						    if(status==0){
						       var statuspage = 'movie';
						    }
						    else if(status == 1){
						        var statuspage = 'series';
						    }
						    else if(status==2){
						        var statuspage = 'originals';
						    }
						    if(json.thumbnail[i].price>0 && json.thumbnail[i].price!='')
						    var price = json.thumbnail[i].price + ' LKR';
						    else var price='';
                            htmldata = htmldata + '<li class="mb-2 mt-2" style="background-color:#192133; border:1px solid #192133; border-radius:5px">\
                                        <a class="title-list" href="'+statuspage+'?id='+json.poster[i].videoid+'" style="text-decoration:none; color:black">\
                                            <div class="d-flex"><img src="'+json.poster[i].url+'" class="searchimg">\
                                            <div class="d-block"><p class="mb-0 fw-bold">'+json.thumbnail[i].title+'</p>\
                                            <p class="mb-0">'+json.thumbnail[i].genre+'</p>\
                                            <p class="mb-0" style="color:#ffaa05">'+price+'</p></div>\
                                            </div>\
                                        </a>\
                                        </li>';
					        //$("#suggestion-box").html("<p class="mb-0>"+json.thumbnail[i].title+"</p>");
                        }
                        htmldata = htmldata + '</ul>';
                        }
                        else{
                            htmldata = htmldata + '<p class="mb-0 text-center mt-1"> No Resuts Found</p></ul>';
                        }
                        
                        $("#suggestion-box").html(htmldata);
                        $("#suggestion-box1").html(htmldata);

					}
				  });
				}

		   });

            $("#suggestion-box").mousedown(function(){
                $('.title-list *').click(function () {
                    window.location.href = $(this).attr('href');
                });
               
		    });
		    $( '#search').focusout(function(){
                $("#suggestion-box").hide();
                $("#search").val('');
            });
            $("#suggestion-box1").mousedown(function(){
                $('.title-list *').click(function () {
                    window.location.href = $(this).attr('href');
                });
		    });
		    $( '#search1').focusout(function(){
                $("#suggestion-box1").hide();
                $("#search1").val('');
            });
            
            $('#suggestion-box, #suggestion-box1').on('mousedown', function(event) {
            // do your magic
            event.preventDefault();
            });

		
		$("#search, #search1").focus(function(){
			if($('#search').val().length == 0){
			$('#suggestion-box').hide()
			}
			if($('#search1').val().length == 0){
			$('#suggestion-box1').hide()
			}
		});
		$(document).on('click', '#kids, .kids', function(e){
            var webtype = $(this).attr('value')
            $.ajax({
					url:"ajax/kids",
					method:"POST",
					data:{webtype:webtype},
					success:function(data)
					{
                        window.location.href="index";
                    }
                })
        });
        $('.pwd-icon').on('click', function(e) {
              var classtype = $(this).attr("class"); 
        	  if(classtype.includes('bi-eye-slash')){
        		  $(this).attr('class', 'bi bi-eye pwd-icon');
        		  $(this).prev().attr('type', 'password');
        	  }
        	  else{
        		  $(this).attr('class', 'bi bi-eye-slash pwd-icon');
        		  $(this).prev().attr('type', 'text');
        	  }
              e.preventDefault();
        });
    </script>
 
<!--------------------End of header ------------------> 

<style>
    .movie{
        margin-top:1rem;
        padding-right:4rem;
        padding-left:4rem;
    }
    .moviecontent{
        width: 100%;
        background: linear-gradient(to right, #0f1526, transparent);
        height: 400px;
        padding: 2.5rem;
        border-radius: 2px;
    }
    .movieImg{
        width:100%;
        height:400px;
        border-radius:10px
    }
    .moviecontent{
        border-radius:10px;
    }
    .moviedesc{
        height: 4.5rem;
        color: #888686;
        overflow: hidden;
        text-overflow: ellipsis;
        width:60%;
    }
    .trailicon{
        margin-top:-2px;
    }
    .trailbtn{
        background-color: #ee9a20;
        padding: 0 10px;
        height: 30px;
    }
    .playbtn{
        background-color: #019065;
        padding: 0 10px;
        height: 30px; 
    }
    .playicon{
        margin-top:-3px;
    }
    .sharelink{
        display:none;
    }
    .sharelink a{
        color:#6c757d !important;
    }
    .movieshare{
        cursor:pointer;
    }
    .movieshare:hover .sharelink{
        display:flex;    
        right: 0px;
        transform: translateX(5%);
    }
    .sharelink a:hover{
        color:#fff !important;
    }
    form *{
            cursor: pointer;
        }
    @media only screen and (max-width:992px){
        .movie{
            padding-right:3.5rem;
            padding-left:3.5rem;
        }        
    }
    @media only screen and (max-width:786px){
        .movie{
            padding-right:2rem;
            padding-left:2rem;
        }
        .movieImg{
            height:300px;
        }
        .moviecontent{
            height:300px;
            padding:1.5rem;
        }
        .moviedesc{
            width:80%;
        }
        .bi-play-fill{
            margin-top:-8px;
        }
        
    }
    @media only screen and (max-width:450px){
        .movie{
            padding-right:0;
            padding-left:0;
        }
        .movieImg{
            height:250px;
            border-radius:0;
        }
        .moviecontent{

            height:250px;
            border-radius:0;
            padding:1rem;
        }
        .movietitle, .moviedetails, .moviedesc, .moviewish, .movieshare{
            display:none;
        }  
        .bi-play-fill{
            margin-top:-5px;
        }
    }
</style>
<div class="movie">
    <div class="position-relative">        
    <?php
        if(isset($_SESSION['userid'])){
        $wish_url = 'https://srihits.veramasait.com/App/wishlist.php';
        $wish_myvars = 'type=list&userid='.$_SESSION['userid'].'&kids='.$_SESSION['kids'];
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
        if(count($response->data->details[0])>0){
        $_SESSION['full_url']=$response->data->media[0]->url;
        $_SESSION['url']=$response->data->details[0]->trailer->url;
        $_SESSION['title']=$response->data->details[0]->title;
        $releasedate1 = DateTime::createFromFormat("d/m/Y", $response->data->details[0]->releasedate) ;
        $releasedate = $releasedate1 ->  format('Y');
        $genre = str_replace(' |', ',', $response->data->details[0]->genre);
        $language = str_replace(' |', ',', $response->data->details[0]->languages);
        $title =$response->data->details[0]->title;
        $description =$response->data->details[0]->shortdescription;
        $duration = $response->data->details[0]->runtime;
        $price = $response->data->details[0]->countryprice;
        $currency = $response->data->details[0]->currency;
        $videoid = $response->data->details[0]->videoid;
        echo '<img src="'.$response->data->details[0]->images[1]->url.'" class="movieImg float-end">
        <div class="position-absolute moviecontent">
            <h3 class="movietitle text-capitalize text-light fw-bold">'.$response->data->details[0]->title.'</h3>
            <p class="text-secondary fw-bold moviedetails">'.$response->data->details[0]->runtime.' min &#x2022 '.$releasedate.'  &#x2022 '.$genre.'  &#x2022 '.$language.'</p>
            <p class="mb-0 text-light moviedesc">'.$response->data->details[0]->shortdescription.'</p>
            <div class="text-light position-absolute pb-5 bottom-0 d-flex movieplay">';
            if($response->data->details[0]->countryprice==0 || $response->data->details[0]->countryprice=='' || $response->data->details[0]->subscription==1)
                    echo '<form action="play" method="POST" class="movieref text-decoration-none text-light d-flex"><input type="hidden" name="movie" />
                    <button class="btn me-1 playbtn" ><img src="assets/images/play-icon.png" class="playicon" width="22" height="22" ><span class="fs-6 text-light"> Play</span></button></form>';
                else
                    echo '<button class="btn me-1 movieref playbtn" ><img src="assets/images/play-icon.png" class="playicon" width="22" height="22" ><span class="fs-6 text-light"> Buy to Watch</span></button>';
            
                if($response->data->details[0]->trailer->url!=''){
                echo '<form action="play" method="POST" class="trailerref ms-5 text-decoration-none text-light d-flex"><input type="hidden" name="trailer" />
                <button class="btn me-1 trailbtn" >
                <img src="assets/images/play-icon.png" class="playicon" width="22" height="22" >
                <span class="fs-6 text-light">Trailer</span></button></form>';
                }
                echo '<div class="text-light text-center ms-5 moviewish" style="margin-top:-10px; cursor:pointer">';
                if(isset($_SESSION['userid'])){
                    if(in_array($response->data->details[0]->videoid, $watchlist)){
                        echo '<i class="bi bi-check-lg text-primary fs-2 watchlist" value="'.$response->data->details[0]->videoid.' , 0" ></i>';
                    }
                    else{
                        echo '<i class="bi bi-plus fs-2 watchlist" value="'.$response->data->details[0]->videoid.' , 0" ></i>';
                    }
                }
                else{
                    echo '<i class="bi bi-plus fs-2 watchlist" value="'.$response->data->details[0]->videoid.' , 0" ></i>';   
                }
                echo '<p class="mb-0 fw-bold" style="margin-top:-15px; font-size:12px">Wachlist</p></div>
                <div class="text-light text-center ms-5 movieshare position-relative">
                    <i class="bi bi-share-fill fs-6" ></i>
                    <p class="mb-0 fw-bold" style="margin-top:-1px; font-size:12px">Share</p>
                    <div class="sharelink position-absolute p-1" style="background-color:#192133; border-radius:10px; right:0">
                        <a onclick="MyWindow=window.open(\'https://www.facebook.com/sharer/sharer.php?u=https://www.srihits.veramasait.com/demo/movie?id='.$id.'\',\'MyWindow\',\'width=600,height=400\'); return false;"><i class="bi bi-facebook ps-3 pe-3 fs-4 rounded"></i></a>
                        <a onclick="MyWindow=window.open(\'https://api.whatsapp.com/send?text=https://srihits.veramasait.com/demo/movie?id='.$id.'\',\'MyWindow\',\'width=600,height=400\'); return false;"><i class="bi bi-whatsapp px-3 fs-4 rounded"></i></a>
                        <a onclick="MyWindow=window.open(\'https://telegram.me/share/url?url=https://srihits.veramasait.com/demo/movie?id='.$id.'\',\'MyWindow\',\'width=600,height=400\'); return false;"><i class="bi bi-telegram px-3 fs-4 rounded"></i></a>
                        <a onclick="MyWindow=window.open(\'https://twitter.com/intent/tweet?url=https://srihits.veramasait.com/demo/movie?id='.$id.'\',\'MyWindow\',\'width=600,height=400\'); return false;"><i class="bi bi-twitter ps-3 pe-3 fs-4 rounded"></i></a>
                        <i class="bi bi-link-45deg px-3 fs-4 rounded"  value="https://srihits.veramasait.com/demo/movie?id='.$id.'"></i>
                    </div>
                </div> 
            </div>
        </div>';
        }
        else{
            echo '<script>alert("Opps! This video is not available"); window.location.href="index.php";</script>';
        }
    ?>
    </div>
    <script>
        $(document).on('click', '.fbshare', function(){
            window.location.href="movie?id=<?php echo $_GET["id"]?>";
        })
    </script>
</div>
<?php
// print_r(count($response->data->relateddata->thumbnail));
echo '<br style="clear:both"><div  class="container-fluid ps-3">
            <h5 class="text-light  ms-3 mt-5">Related Movies</h5>
            <section class="contentlist list mb-3 d-flex flex-wrap ">';
            for($j=0; $j<count($response->data->relateddata->thumbnail); $j++){
                //$genre= str_replace(' |', ',',$categoryjson->$data[$j]->genre);
                echo '  <a href="movie?id='.$response->data->relateddata->thumbnail[$j]->videoid.'"><div class="thumbnail position-relative pt-4 pb-2">
                        <img src="'.$response->data->relateddata->thumbnail[$j]->url.'" class="thumbimage me-3 mb-3">
                        <div class="thumbnailcontent position-absolute p-1 " >
                            <p class="thumbtitle fw-bold text-light mb-0 text-capitalize ps-1">'.$response->data->relateddata->thumbnail[$j]->title.'</p>
                            <p class="thumbgenre text-light mb-0 text-capitalize ps-1">'.$response->data->relateddata->thumbnail[$j]->genre.'</p>';
                            if(isset($_SESSION['userid'])){
                                if(in_array($response->data->relateddata->thumbnail[$j]->videoid, $watchlist)){
                                    echo '<button class="watchlist text-uppercase" value="'.$response->data->relateddata->thumbnail[$j]->videoid.', 0" href="#">&#x2713; REMOVE FROM WISHLIST</button>';
                                }
                                else{
                                    echo '<button class="watchlist text-uppercase" value="'.$response->data->relateddata->thumbnail[$j]->videoid.', 0" href="#">+ ADD TO WATCHLIST</button>';
                                }
                            }
                            else{
                             echo '<button class="watchlist" value="'.$response->data->relateddata->thumbnail[$j]->videoid.', 0" href="#">+ ADD TO WATCHLIST</button>';
                            }
                        echo '</div>
                    </div></a>';
            }
            echo '</section></div>';
            $countdata = count($response->data->relateddata->thumbnail)*140;
           // if(count($categoryjson->$data)>1){
            echo '<script>
            var width = $(window).width();
            if(width < '.$countdata.'){
            $(".list").slick({
                slidesToShow:(width+75)/180,
                slidesToScroll:(width/160),
                dots: false,
                infinite: false,
                speed: 1000,
                arrows: true,
            });
            }
            </script>';
?>
</div>
<script>
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
    $(document).on('click', '.movieref, .trailerref', function(){
        $(this).submit();
    })
    $('#movieDropdown').css({'color':'#ffaa05', 'font-weight':'bold'})
    $(document).on('click', '.bi-link-45deg', function(){
      navigator.clipboard.writeText($(this).attr('value'));
      var copiedelement = $(this);
      setTimeout(function(){alert('copied')},500);
    })
</script>
<?php include "footer.php" ?>