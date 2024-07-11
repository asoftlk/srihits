<style>
.footer {
    position: relative;
}
.footer .container-fluid{
    padding: 34px 24px 24px;
}
.footer .container-fluid .footer-left {
    padding: 0;
}
.footer .container-fluid .footer-left ul {
    list-style: none;
    padding: 0;
    margin: 0;
}
.footer .container-fluid .footer-left ul li {
    display: inline-block;
}
.footer .container-fluid .footer-left ul li a {
    font-size: 14px;
    font-weight: 400;
    text-transform: capitalize;
    color: #fff;
    text-decoration: none;
    cursor: pointer;
    display: inline-block;
    padding: 0 20px 0 0;
}
.footer .container-fluid .footer-right .app-unit {
    padding: 0 0 24px 30px;
    float: right;
}
.footer .container-fluid .footer-right .app-unit .store-wrapper {
    float: right;
}
.footer .container-fluid .footer-right p {
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    padding-bottom: 7px;
}
.footer .container-fluid .footer-right .app-unit .store-wrapper a {
    height: 40px;
    width: 135px;
    /*display: inline-block;*/
    /*margin-right: 5px;*/
    cursor: pointer;
}
.footer .container-fluid .footer-right .app-unit .store-wrapper a.playstore {
    background-position: 0 0;
    margin-bottom: 15px;
}
.footer .container-fluid .footer-right .app-unit .store-wrapper a.appstore {
    background-position: -140px 0;
    margin-bottom:5px;
}
.footer .container-fluid .footer-right .social-unit {
    float: right;
    padding: 0;
}
.footer .container-fluid .footer-right p {
    font-size: 14px;
    font-weight: 500;
    color: #fff;
    padding-bottom: 7px;
}
.footer .container-fluid .footer-right .social-unit a {
    height: 40px;
    width: 40px;
    display: inline-block;
    margin-right: 5px;
    cursor: pointer;
}
.footer .container-fluid .footer-right .social-unit a.fb {
    background-position: 0 0;
    cursor:pointer;
}
.footer .container-fluid .footer-right .social-unit a.tw {
    background-position: -45px 0;
    cursor:pointer;
}
.footer .container-fluid .footer-right .social-unit a.yt {
    background-position: -45px 0;
    cursor:pointer;
}
.footer .container-fluid .footer-left .copyright {
    padding-top: 11px;
    padding-right: 15%;
    font-size: 12px;
    line-height: 1.8;
    color: #fff;
    font-weight: 400;
}
@media only screen and (max-width: 767px){
.footer .container-fluid .footer-right {
    padding: 0 0 40px 0;
}
.footer .container-fluid .footer-right .app-unit {
    padding: 0 0 24px;
}
.footer .container-fluid .footer-right .social-unit {
    float: left;
    text-align: left;
}
}

element.style {
}
@media only screen and (max-width: 480px){
.footer .container-fluid .footer-right .app-unit {
    padding: 0 0 24px 8px;
    width: 50%;
}
.footer .container-fluid .footer-right .social-unit {
    width: 40%;
}
}
</style>
<script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
<script>
    $(document).on('click', '.watchlist', function(e){
        var userid = "<?php echo isset($_SESSION['userid'])?$_SESSION['userid']:'' ?>"
        if(userid != ''){
            var component = $(this);
            var values = $(this).attr('value');
            var valuessplit =  values.split(', ');
            var id = valuessplit[0];
            var status = valuessplit[1];
            $.ajax({
                url:"https://srihits.veramasait.com/App/wishlist.php",
                method:"POST",
                data:{kids:"<?php echo $_SESSION['kids'] ?>", userid:userid, status:status, id:id},
                success:function(data)
                {
                    if(data.status="true"){
                        if(data.message.includes('Added')){
                            if(component.hasClass('bi')){
                                component.removeClass('bi bi-plus').addClass("bi bi-check-lg text-primary");
                            }
                            else{
                                component.text('\u2713 Remove from Watchlist');
                            }
                        }
                        else{
                            if(component.hasClass('bi')){
                                component.removeClass('bi bi-check-lg text-primary').addClass("bi bi-plus");
                            }
                            else{
                                component.text('+ Add to Watchlist');
                            }
                        }
                        snackMsg(data.message);
                        if(window.location.href.includes('watchlist')){
                            $('a[href$="id='+id+'"]').remove();
                            if($(".list a").length ==0){
                                $('div .title').children().remove()
                                $(".title").append('<h4 class="title text-light text-center mt-4 text-capitalize ms-3 mt-2">Your Watchlist is Empty!</h4><p class="text-light text-center">Keep track of Movies, TV Shows and clips you want to watch</p>');
                            }
                        }
                        
                    }
                }
            });  
        }
        else{
            $('#loginModal').modal('show');
        }      
        e.preventDefault();
    });
</script>
<div class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="footer-left col-xs-12 col-sm-7 col-sm-7">
                <ul>
                    <li><a href="about-us" target="_blank"  class="">About Srihits</a>
                    </li>
                    <li><a href="terms-of-use" target="_blank"  class="">Terms of Use</a>
                    </li>
                    <li><a href="privacy-policy" target="_blank"  class="">Privacy
                            Policy</a>
                    </li>
                    <li><a href="" target="_blank"  class="">FAQ</a></li>
                </ul>
                <p class="copyright">© <script type="text/javascript">document.write(new Date().getFullYear());</script>. All Rights Reserved. all related channel and
                    programming logos are service marks of, and all related programming visuals and elements are the
                    property of, Cine Films Lanka PVT LTD. All rights reserved.</p>
            </div>
            <div class="footer-right col-xs-12 col-sm-5 col-sm-5">
                <div class="app-unit col-xs-8">
                    <div class="store-wrapper">
                        <p class="mb-1">Srihits App</p>
                        <a class="playstore" href="" target="_blank" ><img src="assets/images/playstore.png" width="120" height="35"></a>
                        <a class="appstore" href="" target="_blank" ><img src="assets/images/appstore.png" width="120" height="35"></a>
                    </div>
                </div>
                <div class="social-unit col-xs-4">
                    <div>
                        <p>Connect with us</p>
                        <a class="fb" href="https://www.facebook.com/srihits.official" target="_blank" ><i class="bi bi-facebook text-light fa-xl"></i></a>
                        <a class="tw" href="https://www.instagram.com/srihits/" target="_blank" ><i class="bi bi-instagram text-light fa-xl"></i></a>
                        <a class="yt" href="https://www.youtube.com/@Dr.SomaratneDissanayake" target="_blank" ><i class="bi bi-youtube text-light fa-xl"></i></a>
                        <a class="tk" href="https://www.tiktok.com/@drsomaratnedissanayake" target="_blank" ><i class="bi bi-tiktok text-light fa-xl"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="subscribeBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="subscribeBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="subscribeBackdropLabel"><img src="assets/images/Srihits-website-logo1.png" width="160" height="32"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body mb-3">
      </div>
      <div class="modal-footer justify-content-start">
        <p class="text-success">*This video Will be available for 48 hrs from the time of buying</p>
      </div>
    </div>
  </div>
</div>
<script>
$(document).on('click', '.movieref', function(){
    var userid = "<?= isset($_SESSION['userid'])?$_SESSION['userid']:''?>";
    if(userid==''){
        $('#loginModal').modal('show');
    }
    else{
        $('#subscribeBackdrop').modal('show');
        var imgurl= $(this).parent().parent().parent().find('img').attr('src');
        $('#subscribeBackdrop .modal-body').children().remove();
        var html = '<div class="row text-light">\
                <div class="col-md-5">\
                    <img src="'+imgurl+'" width="250" height="140" class="rounded">\
                    <h4 class="mt-3">Buy to Watch</h4>\
                </div>\
                <div class="col-md-7">\
                    <h4><?= $title ?></h4>\
                    <h6><?= $genre ?></h6>\
                    <h6><?= $language ?></h6>\
                    <p><?= substr(trim(preg_replace('/\s+|\'/', ' ', $description)),0,250) ?></p>\
                    <p class="text-end">Price: <?= $price." ".$currency ?></p>\
                    <button type="button" class="btn btn-success float-end" id="payhere-payment">Buy Now</button>\
                </div>\
            </div>';
        $('#subscribeBackdrop .modal-body').append(html);
    }
})
var ajaxcheck=0;
$( document ).ajaxComplete(function() {
    if(ajaxcheck==0){
        if((screen.height) > $(document).height()+200){
            $('.footer').css({'position':'absolute', 'bottom':'0'});
        }
        else{
            $('.footer').css({'position':'relative'});    
        }
        ajaxcheck=1
    }
});
$(document).on('scroll', function(){
    // if((screen.height) > ($(document).height()+100)){
    // $('.footer').css({'position':'absolute', 'bottom':'0'});
    // }
    // else{
    // $('.footer').css({'position':'relative'});    
    // }
});
$.getJSON("https://srihits.veramasait.com/App/countrycodes.json", function(result){
    var countrycode ="+94";
    if(countrycode == null){
      for(var i=0; i< result.length; i++){
        $('.countryCode').append('<option value="'+result[i].dial_code+'">'+result[i].dial_code+'('+result[i].name+')</option>');
      }
    }
    else{
      for(var i=0; i< result.length; i++){
        if(countrycode==result[i].dial_code){
          $('.countryCode').append('<option value="'+result[i].dial_code+','+result[i].code+'" selected>'+result[i].dial_code+'('+result[i].name+')</option>');
        }
        else{
          $('.countryCode').append('<option value="'+result[i].dial_code+','+result[i].code+'">'+result[i].dial_code+'('+result[i].name+')</option>');
        }
        
      }
    }
});
    
</script>
<script>
// $(document).ready(function(){
//     $('#mobileCode option[value="+94,LK"]').prop('selected', true)
//     $('#contact').attr('placeholder', 'Mobile number (Eg: 777123123)');
// })
    // $(document).on('click', '#payhere-payment', function(e){
    //     console.log('hello');
    //     // payhere.startPayment(payment);
    // })
    // Payment completed. It can be a successful failure.
    payhere.onCompleted = function onCompleted(orderId) {
        // console.log(payhere);
        // console.log("Payment completed. OrderID:" + orderId);
        $.ajax({
            type:'POST',
            url:"https://srihits.veramasait.com/App/subscribe.php",
            data:{'orderid':orderId, 'userid':"<?= (isset($_SESSION['userid']))?$_SESSION['userid']:''?>", 'videoid':"<?= $videoid ?>", 'title':"<?= $title ?>"},
            success: function(data){
                var json = JSON.parse(data);
                if(json.success){
                    alert(json.message);
                    window.location.reload();
                }
                else{
                    alert(json.message);
                }
            },
            error: function(error){
                alert(error.reponseText);
            }
        })
        
        // window.location.href ="index.php?oid="+orderId;
        // Note: validate the payment and show success or failure page to the customer
    };

    // Payment window closed
    payhere.onDismissed = function onDismissed() {
        // Note: Prompt user to pay again or show an error page
        alert("Payment dismissed");
    };

    // Error occurred
    payhere.onError = function onError(error) {
        // Note: show an error page
       alert("Error:"  + error);
    };

    // Put the payment variables here
    var payment = {
        "sandbox": true,
        "merchant_id": "1221934",    // Replace your Merchant ID
        "return_url": "https://srihits.veramasait.com/demo/notify",     // Important
        "cancel_url": "https://srihits.veramasait.com/demo/notify",     // Important
        "notify_url": "https://srihits.veramasait.com/demo/notify",
        "order_id": "<?= $orderid ?>",
        "items": "<?= $title ?>",
        "amount": "<?= $price ?>",
        "currency": "<?= $currency ?>",
        "hash": "<?= $hash ?>", // *Replace with generated hash retrieved from backend
        "first_name": "Srihits",
        "last_name": "Lanka",
        "email": "knataraju45@gmail.com",
        "phone": "9032841549",
        "address": "No.1, Galle Road",
        "city": "Colombo",
        "country": "Sri Lanka"
    };

    // Show the payhere.js popup, when "PayHere Pay" is clicked
    $(document).on('click', '#payhere-payment', function(e){
        payhere.startPayment(payment);
    });
</script>


