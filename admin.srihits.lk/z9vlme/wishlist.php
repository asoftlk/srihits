<?php
include "DatabaseConfig.php";
$con = mysqli_connect($HostName,$HostUser,$HostPass,$DatabaseName);
// header('Access-Control-Allow-Origin: *');
header("Content-Type: application/json");
$json = file_get_contents('php://input');
$obj = json_decode($json,true);
if(isset($_POST['userid'])){
$id= $_POST['id'];
$userid = $_POST['userid'];
$status = $_POST['status'];
$type = $_POST['type'];
$kids = $_POST['kids'];
}
else{
$id= $obj['id'];
$userid = $obj['userid'];
$status = $obj['status'];
$type = $obj['type'];
$kids = $obj['kids'];    
}
if($type=='list'){
     $thumbnail=array();
    $poster=array();
    $videoDetails = array();
    $quty = mysqli_query($con,"select * from wishlist where userid='$userid'");
    $uhd = mysqli_num_rows($quty);
    if($uhd>0){
        while($row = mysqli_fetch_assoc($quty))
        {
            $vd=$row['videoid'];
            $stus = $row['status'];
            if($stus==0){
                 $query = mysqli_query($con,"select thumbnail.*,moviedetails.title,moviedetails.price,moviedetails.releasedate,moviedetails.runtime from thumbnail LEFT JOIN moviedetails ON moviedetails.videoid=thumbnail.videoid where moviedetails.publish='1' and moviedetails.approve='1' and moviedetails.kids='$kids' and moviedetails.videoid='$vd' ");
                    while($row=mysqli_fetch_assoc($query)){
                         $row['nav']='movie';
                        if($row['type']=='thumbnail'){
                            
                            array_push($thumbnail,$row);
                        }
                        else{array_push($poster,$row);}
                        }
            }
            else if($stus==1){
                    $query = mysqli_query($con,"select thumbnail.*,tvseriesdetails.title,tvseriesdetails.price,tvseriesdetails.releasedate,tvseriesdetails.runtime from thumbnail LEFT JOIN tvseriesdetails ON tvseriesdetails.videoid=thumbnail.videoid where tvseriesdetails.publish='1'and tvseriesdetails.approve='1' and tvseriesdetails.kids='$kids' and tvseriesdetails.videoid='$vd' ");
                    while($row=mysqli_fetch_assoc($query)){
                         $row['nav']='series';
                        if($row['type']=='thumbnail'){
                            
                            array_push($thumbnail,$row);
                        }
                        else{array_push($poster,$row);}
                        }
            }
            else if($stus==2)
            {
                 $query = mysqli_query($con,"select thumbnail.*,vsc.title,vsc.type as vtype,vsc.price,vsc.releasedate,vsc.runtime from thumbnail LEFT JOIN vsc ON vsc.videoid=thumbnail.videoid where vsc.publish='1' and vsc.approve='1' and vsc.kids='$kids'and vsc.videoid='$vd' ");
                    while($row=mysqli_fetch_assoc($query)){
                         $row['nav']='vsc';
                        if($row['type']=='thumbnail'){
                            array_push($thumbnail,$row);
                        }
                        else{array_push($poster,$row);}
                        }
            }
            $queryplay = mysqli_query($con,"select * from videos where videoid ='$vd'");
            while($row=mysqli_fetch_assoc($queryplay)){array_push($videoDetails,$row); }
           
        }
        
    }
    $rtn = array('thumbnail'=>$thumbnail,'poster'=>$poster,'media'=>$videoDetails,'count'=>$uhd);
}
else{
 $query = mysqli_query($con,"select * from wishlist where videoid='$id' and userid='$userid'");
$ck = mysqli_num_rows($query);
if($ck>0){
    $quer = mysqli_query($con,"delete from wishlist where  videoid='$id' and userid='$userid'");
    if($quer){$rtn = array('success'=>'true','message'=>'Removed from Watchlist', 'data' => $type, 'user'=> $_POST['userid']);}
    else{$rtn = array('success'=>'fail','message'=>'Unfavourited failed');}
}
else{
    $quer = "insert into wishlist (userid,videoid,status) values ('$userid','$id','$status')";
    $abc = mysqli_query($con,$quer);
     if($abc){$rtn = array('success'=>'true','message'=>'Added to Watchlist', 'data' => $type, 'user'=> $_POST['userid']);}
    else{$rtn = array('success'=>'fail','message'=>'favourite failed','favrouite'=>$fav,'$duration'=>$duration);}
}   
}
echo json_encode($rtn);
?>