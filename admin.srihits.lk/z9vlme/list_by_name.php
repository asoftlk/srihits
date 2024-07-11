<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
$type = $obj['type'];
$name = $obj['name'];
$kids = $obj['kids'];
$condm = $type == '1' ? "and moviedetails.countries like '%$name%'" : " and moviedetails.genre like '%$name%' ";
$condt = $type == '1' ? "AND tvseriesdetails.countries like '%$name%'" : " AND tvseriesdetails.genre like '%$name%' ";
$condv = $type == '1' ? "AND vsc.countries like '%$name%'" : " AND vsc.genre like '%$name%' ";
$list=array('Latest & Trending','Popular in Movies','Popular in Series','Popular in Short Films','Popular in Video Albums','Popular in Comedy Drama');
 $lt=array();
$queryL = mysqli_query($con,"select thumbnail.*,moviedetails.title from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' ".$condm." ");
    while($row=mysqli_fetch_assoc($queryL)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
            array_push($lt,$row);
        }
        }
$queryL = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title from thumbnail LEFT JOIN tvseriesdetails ON tvseriesdetails.videoid=thumbnail.videoid where tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' ".$condt." ");
    while($row=mysqli_fetch_assoc($queryL)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
            
            array_push($lt,$row);
        }
        }
$queryL = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.type vtype from thumbnail LEFT JOIN vsc ON vsc.videoid=thumbnail.videoid where vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids' ".$condv." ");
    while($row=mysqli_fetch_assoc($queryL)){
        $row['nav']='vsc';
        if($row['type']=='thumbnail'){
            
            array_push($lt,$row);
        }
        }
//Popular in Movies
$pm = array();
$querypM = mysqli_query($con,"select thumbnail.*,moviedetails.title from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' ".$condm." order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypM)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pm,$row);
            }
    }
//Popular in Series
$ps = array();
$querypS = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' ".$condt." order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypS)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($ps,$row);
            }
    }
//Popular in Shortfilm
$psf = array();
$querypSf = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.type vtype from viewsbyuser  LEFT JOIN vsc ON viewsbyuser.videoid=vsc.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids' and vsc.vsctype='shortfilm' ".$condv." order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypSf)){
        $row['nav']='vsc';
        if($row['type']=='thumbnail'){
                array_push($psf,$row);
            }
    }
//Popular in Video Albums
$pva = array();
$querypVa = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.type vtype from viewsbyuser  LEFT JOIN vsc ON viewsbyuser.videoid=vsc.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids' and vsc.vsctype='videoalbum(songs)' ".$condv." order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypVa)){
        $row['nav']='vsc';
        if($row['type']=='thumbnail'){
                array_push($pva,$row);
            }
    }
//Popular in Comedy Drama
$pcd = array();
$querypcd = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.type vtype from viewsbyuser  LEFT JOIN vsc ON viewsbyuser.videoid=vsc.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids' and vsc.vsctype='comedydrama' ".$condv." order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypcd)){
        $row['nav']='vsc';
        if($row['type']=='thumbnail'){
                array_push($pcd,$row);
            }
    }
 
 $rtn = array('names'=>$list,'Latest & Trending'=>$lt,'Popular in Movies'=>$pm,'Popular in Series'=>$ps,'Popular in Short Films'=>$psf,'Popular in Video Albums'=>$pva,'Popular in Comedy Drama'=>$pcd);  
 echo json_encode($rtn);
    
    
    
?>