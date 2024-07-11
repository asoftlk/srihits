<?php include "header.php"; 
$url = 'https://srihits.veramasait.com/App/profile.php';
$myvars = 'id='.$_SESSION["userid"];
$id = $_GET["id"];

$ch = curl_init( $url );
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_HEADER, 0);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

$response = curl_exec( $ch );
$response= json_decode($response);
print_r();
?>
<style>
    .profile{
        text-align: center;
        margin-top: 4rem;
    }
    .bi-person-circle{
       color: #1f80e0;
        font-size: 5rem; 
    }
    .bi-person-circle::before{
        background: #fff;
        border-radius: 50%;
    }
    .accordion{
        width:350px;
        margin:auto;
    }
    .accordion-button, .accordion-button:not(.collapsed){
        background-color:#192133;
        color:#fff;
    }
    .accordion-button::after{
        background-image: url('data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23ffffff'%3e%3cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e') !important;
        transform:rotate(-90deg);
    }
</style>
<div class="container">
    <div class="profile">
        <i class="bi bi-person-circle"></i>
    </div>
    <div class="user">
        <h4 class="text-center fw-700 text-light mb-0"><?= $response->user[0]->name ?></h4>
    </div>
    <div class="contact mb-3">
        <h6 class="text-center fw-700 text-light mb-0"><?= $response->user[0]->email.'  | '.$response->user[0]->mobilenumber ?></h6>
    </div>
 <div class="accordion" id="accordionExample">
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingOne">
      <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
        Account Setting
      </button>
    </h2>
    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      </div>
    </div>
  </div>
  <div class="accordion-item">
    <h2 class="accordion-header" id="headingTwo">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
        Manage Devices
      </button>
    </h2>
    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
      <div class="accordion-body">
      </div>
    </div>
  </div>
  </div>
</div>