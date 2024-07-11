<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$kids = $obj['kids'];
// $kids = '0';
$list=array('Trending now','Blockbusters','Action','Thriller','Drama','Entertainment','Family','Classic');
// Latest & Trending
 $lt=array();
$queryL = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.price from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and insertdatetime >= now()-interval 3 month");
    while($row=mysqli_fetch_assoc($queryL)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
            array_push($lt,$row);
        }
        }
//Popular in Movies
$pm = array();
$querypM = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypM)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pm,$row);
            }
    }

//Popular in Action
$pac=array();$n = 'action';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pac,$row);
            }
    }
//Popular in Thriller
$pth=array();$n = 'thriller';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pth,$row);
            }
    }
//Popular in Drama
$pd=array();$n = 'drama';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pd,$row);
            }
    }
//Popular in entertainment
$pr=array();$n = 'entertainment';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pr,$row);
            }
    }

//Popular in Family
$pro=array();$n = 'family';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pro,$row);
            }
    }
//Popular in Classic
$pfa=array();$n = 'classic';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pfa,$row);
            }
    }

$rtn = array('names'=>$list,'Trending now'=>$lt,'Blockbusters'=>$pm,'Action'=>$pac,'Thriller'=>$pth,'Drama'=>$pd,'Entertainment'=>$pr,'Family'=>$pro,'Classic'=>$pfa);
echo json_encode($rtn);
?>