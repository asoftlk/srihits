<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
if(isset($_POST['kids'])){
$kids = mysqli_real_escape_string($con, $_POST['kids']);
$userid = mysqli_real_escape_string($con, $_POST['userid']);
}
else{
$kids = $obj['kids'];
$userid = $obj['userid'];
}
// $kids = '0';
$list=array('My Subscription', 'Latest & Trending','Popular in Movies','Popular in Series','Popular in Short Films','Popular in Video Albums','Popular in Comedy Drama','Popular in Action','Popular in Thriller','Popular in Drama','Popular in Reality','Popular in Romance','Popular in Family','Popular in Crime','Popular in Comedy','Popular in Biopic','Popular in Science');
//My Subscription
$sub =[];
if($userid!=''){
    $queryS = mysqli_query($con, "SELECT * from subscription WHERE userid = '$userid' and datetime > (NOW() - INTERVAL 48 HOUR)");
    if($queryS && mysqli_num_rows($queryS)>0){
        $subs =  mysqli_fetch_all($queryS, MYSQLI_ASSOC);
        for($i =0; $i<count($subs); $i++){
            $vid = $subs[$i]['videoid'];
            // echo "select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.videoid='$vid'";
            $queryL = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.videoid='$vid'");
                if($queryL && mysqli_num_rows($queryL)>0){
                while($row=mysqli_fetch_assoc($queryL)){
                    $row['nav']='movie';
                    if($row['type']=='thumbnail'){
                        // print_r($row);
                        array_push($sub,$row);
                    }
                    }
                }
                else{
                    $queryL = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,,tvseriesdetails.genre,tvseriesdetails.price from thumbnail LEFT JOIN tvseriesdetails ON tvseriesdetails.videoid=thumbnail.videoid where tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.videoid='$vid'");
                        if($queryL && mysqli_num_rows($queryL)>0){
                        while($row=mysqli_fetch_assoc($queryL)){
                            $row['nav']='series';
                            if($row['type']=='thumbnail'){
                                
                                array_push($sub,$row);
                            }
                            }
                        }
                        else{
                            $queryL = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.genre,vsc.type,vsc.price, vsc.vtype from thumbnail LEFT JOIN vsc ON vsc.videoid=thumbnail.videoid where vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids' and vsc.videoid = '$vid'");
                            if($queryL && mysqli_num_rows($queryL)>0){
                            while($row=mysqli_fetch_assoc($queryL)){
                                $row['nav']='vsc';
                                if($row['type']=='thumbnail'){
                                    array_push($sub,$row);
                                }
                                }
                            }
                            
                        }
                }
            
        }
    }
}
$querypM = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypM)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pm,$row);
            }
    }
// Latest & Trending
 $lt=array();
$queryL = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and insertdatetime >= now()-interval 3 month");
    while($row=mysqli_fetch_assoc($queryL)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
            array_push($lt,$row);
        }
        }
$queryL = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,,tvseriesdetails.genre,tvseriesdetails.price from thumbnail LEFT JOIN tvseriesdetails ON tvseriesdetails.videoid=thumbnail.videoid where tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and insertdatetime >= now()-interval 3 month");
    while($row=mysqli_fetch_assoc($queryL)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
            
            array_push($lt,$row);
        }
        }
$queryL = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.genre,vsc.type,vsc.price, vsc.vtype from thumbnail LEFT JOIN vsc ON vsc.videoid=thumbnail.videoid where vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids' and insertdatetime >= now()-interval 3 month");
    while($row=mysqli_fetch_assoc($queryL)){
        $row['nav']='vsc';
        if($row['type']=='thumbnail'){
            array_push($lt,$row);
        }
        }
//Popular in Movies
$pm = array();
$querypM = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypM)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pm,$row);
            }
    }
//Popular in Series
$ps = array();
$querypS = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypS)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($ps,$row);
            }
    }
//Popular in Shortfilm
$psf = array();
$querypSf = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.genre,vsc.type vtype,vsc.price from viewsbyuser  LEFT JOIN vsc ON viewsbyuser.videoid=vsc.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids' and vsc.type='shortfilm' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypSf)){
        $row['nav']='vsc';
        if($row['type']=='thumbnail'){
                array_push($psf,$row);
            }
    }
//Popular in Video Albums
$pva = array();
$querypVa = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.genre,vsc.type vtype,vsc.price from viewsbyuser  LEFT JOIN vsc ON viewsbyuser.videoid=vsc.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids' and vsc.type='videoalbum(songs)' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypVa)){
        $row['nav']='vsc';
        if($row['type']=='thumbnail'){
                array_push($pva,$row);
            }
    }
//Popular in Comedy Drama
$pcd = array();
$querypcd = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.genre,vsc.type vtype,vsc.price from viewsbyuser  LEFT JOIN vsc ON viewsbyuser.videoid=vsc.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids' and vsc.type='comedydrama' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($querypcd)){
        $row['nav']='vsc';
        if($row['type']=='thumbnail'){
                array_push($pcd,$row);
            }
    }
//Popular in Action
$pac=array();$n = 'action';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pac,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.title,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($pac,$row);
            }
    }
//Popular in Thriller
$pth=array();$n = 'thriller';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pth,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($pth,$row);
            }
    }
//Popular in Drama
$pd=array();$n = 'drama';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pd,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($pd,$row);
            }
    }
//Popular in Reality
$pr=array();$n = 'reality';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pr,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($pr,$row);
            }
    }
//Popular in Romance
$pro=array();$n = 'romance';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title, moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pro,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($pro,$row);
            }
    }
//Popular in Family
$pfa=array();$n = 'family';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pfa,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($pfa,$row);
            }
    }
//Popular in Crime
$pcri=array();$n = 'crime';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,,moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pcri,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($pcri,$row);
            }
    }
//Popular in Comedy
$pcom=array();$n = 'comedy';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,,moviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pcom,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($pcom,$row);
            }
    }
//Popular in Biopic
$pbio=array();$n = 'biopic';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,oviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($pbio,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($pbio,$row);
            }
    }
//Popular in Science
$psci=array();$n = 'science';
$queryac = mysqli_query($con,"select thumbnail.*,moviedetails.title,oviedetails.genre,moviedetails.price from viewsbyuser  LEFT JOIN moviedetails ON viewsbyuser.videoid=moviedetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='movie';
        if($row['type']=='thumbnail'){
                array_push($psci,$row);
            }
    }
$queryac = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.genre,tvseriesdetails.price from viewsbyuser  LEFT JOIN tvseriesdetails ON viewsbyuser.videoid=tvseriesdetails.videoid LEFT JOIN thumbnail ON viewsbyuser.videoid=thumbnail.videoid where  tvseriesdetails.publish='1' and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.genre like '%$n%' order by viewsbyuser.count DESC limit 10");
    while($row = mysqli_fetch_assoc($queryac)){
        $row['nav']='series';
        if($row['type']=='thumbnail'){
                array_push($psci,$row);
            }
    }
$queryLiveTv = mysqli_query($con,"select id,name,url,logo from livetv");
$lTv=[];
$lTv = $queryLiveTv->fetch_all(MYSQLI_ASSOC);
$rtn = array('names'=>$list,'My Subscription'=>$sub, 'Latest & Trending'=>$lt,'Popular in Movies'=>$pm,'Popular in Series'=>$ps,'Popular in Short Films'=>$psf,'Popular in Video Albums'=>$pva,'Popular in Comedy Drama'=>$pcd,'Popular in Action'=>$pac,'Popular in Thriller'=>$pth,'Popular in Drama'=>$pd,'Popular in Reality'=>$pr,'Popular in Romance'=>$pro,'Popular in Family'=>$pfa,'Popular in Crime'=>$pcri,'Popular in Comedy'=>$pcom,
'Popular in Biopic'=>$pbio,'Popular in Science'=>$psci,'live_tv'=>$lTv);
echo json_encode($rtn);
?>