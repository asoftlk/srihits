<?php
include "header.php";
if($_SESSION['url']==''){
  echo '<script>alert("This vidoe is not available");</script>';
}
if(!isset($_SESSION['url'])){
    echo '<script>window.location.href="index"</script>';
}
if(isset($_POST["movie"])){
    $url = $_SESSION['full_url'];
}
elseif(isset($_POST["trailer"])){
    $url = $_SESSION['url'];
}
?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Srihits</title>
  <link rel='stylesheet' href='https://vjs.zencdn.net/7.14.3/video-js.css'>
  
<style>
/* @media all and (display-mode: browser) {
  .bi-arrow-counterclockwise p, .bi-arrow-clockwise p{
    margin-top:-38px;
  }
  #remainDuration{
    margin-top:-10px;
  }
  #volume-bar{
    margin-top:-2px;
  }
} */
  
body {
	font-family: 'Montserrat', sans-serif;
	line-height: 1.6;
	margin: 0;
	min-height: 100vh;
	   
      background-color: #0A0A0A;

}
.navbar{
  display:none;
}
::webkit-scrollbar{
  width:0%;
}

.contentMenu {
  position: relative;
  width: 4em;
}
.contentMenu .icon {
  text-align: center;
  color: white;
  font-size:28px;
  margin-top: -7px;
}
.contentMenu .icon:hover {
  cursor: pointer;
  color: gray;
}
.contentMenu .icon:hover + .menu {
  transform: translate(-50%, -30px);
  visibility: visible;
  opacity: 0.8;
}
.contentMenu .menu {
  position: absolute;
  bottom: 6px;
  left: 50%;
  transition: all 200ms;
  display: flex;
  justify-content: end;
  flex-direction: column-reverse;
  width: 100px;
  transform: translate(-50%, -20px);
  visibility: hidden;
  opacity: 0;
  font-size:12px;
}
.contentMenu .menu:hover {
  transform: translate(-50%, -30px);
  visibility: visible;
  opacity: 1;
}


#auto {
  background: #333;
}
#auto .current {
  font-size: 10px;
  margin-left: 3px;
}
#auto .current:before {
  margin-left: -3px;
  content: "(";
  position: absolute;
}
#auto .current:after {
  content: ")";
  position: absolute;
}

.item {
  position: relative;
  text-align: center;
  border: 0;
  padding: 10px;
  background: #444;
}
.item.selected {
  background: #333;
  font-weight: bold;
}
.item.selected:before {
  content: "";
  position: absolute;
  width: 10px;
  height: 10px;
  top: 50%;
  border-radius: 50%;
  background: #4caf50;
  left: 10px;
  transform: translateY(-50%);
}
.item:hover {
  background: #333;
  cursor: pointer;
}
.video-js{
  width:100vw;
  height:100vh;
}
.bi-arrow-left, .bi-arrows-fullscreen, .bi-play-fill, .bi-arrow-clockwise, .bi-arrow-counterclockwise{
  cursor:pointer;
}
.bi-arrow-left::before{
  font-size:2.5rem;
}
.bi-arrows-fullscreen::before, .bi-fullscreen-exit::before, .bi-volume-down-fill::before{
  font-size:1.8rem;
}
.bi-play-fill::before, .bi-pause-fill::before, .bi-arrow-clockwise::before, .bi-arrow-counterclockwise::before{
  font-size:3.5rem;
}
.bi-volume-up-fill::before, .bi-volume-mute-fill::before{
  font-size:1.8rem;
}
.bi-arrow-counterclockwise p, .bi-arrow-clockwise p{
  margin-left: 16px;
  margin-top: -42px;
  font-weight: 700;
  font-size: 18px;
}
#fullscreendiv{
  position:absolute;
  top:10px;
  right:10px;
}
#playdiv{
  position:absolute;
  top:46vh;
  right:46vw;
}
#forwarddiv{
  position:absolute;
  top:46vh;
  right:20vw;
}
#backwarddiv{
  position:absolute;
  top:46vh;
  right:70vw;
}
.vjs-has-started .vjs-control-bar{
  /* display:none; */
}
.video-js .vjs-big-play-button{
  display:none;
}

#custom-seekbar
{  
  width: 85%;
  position: absolute;
  margin-left: auto;
  margin-right: auto;
  left: 0;
  right: 0;
  bottom: 6vh;
  display:flex;
}
#custom-seekbar span
{
  background-color: orange;
  position: absolute;
  top: 0;
  left: 0;
  height: 10px;
  width: 0px;
}
#custom-seekbar span:after{
  content: '';
  display:block;
  position: absolute;
  background-color: red;
  color: red;
  top: 0;
  right: 0;
}
#remainDuration{
  padding-left: 20px;
  margin-top: -10px;
  color: #fff;
  font-size:14px;
}
#customRange1{
  width:100%;
  background:transparent;
  height:4px;
}
#volume-seekbar{
  display:flex;
  position:absolute;
  top:88vh; 
  right:20vw
}
#vol-control{
  height:4px;
}
/*#vol-control:hover{*/
/*    border:4px solid #ddd;*/
/*}*/
#volume-bar{
  margin-top: -2px;
  margin-left: 5px;
  display:none;
}
#volumediv:hover #volume-bar{
  display:block;
}
/*input[type=range]{*/
/*  filter:hue-rotate(168deg);*/
/*}*/
input[type=range]::-webkit-slider-runnable-track {
  width: 100%;
  height: 6px;
  cursor: pointer;
}
input[type=range]::-webkit-slider-thumb {
  height: 12px;
  width: 12px;
  border-radius: 50%;
  cursor: pointer;
  margin-top: -5px;
}
.qualitySelector{
  position:absolute; 
  top:88vh; 
  right:10vw;
}
.pip-expanded, .pip-small, .pip-icon, .pip-explainer {
    position: absolute;
    left: 0;
    top: 0;
    display :block;
}
video::-webkit-media-controls {
  display:none !important;
  opacity: 1 !important;
}
video::-webkit-media-controls-play-button {display:none !important;}

video::-webkit-media-controls-volume-slider {}

video::-webkit-media-controls-mute-button {}

video::-webkit-media-controls-timeline {}

video::-webkit-media-controls-current-time-display {}

video::-webkit-media-controls-start-playback-button {
    display: none;
}

@media only screen and (max-width:560px){
  .qualitySelector{
    left:75vw;
  }
  #volume-bar{
      display:none !important;
  }
  #volume-seekbar{
      right:30vw;
  }
  #custom-seekbar{
      bottom:12vh;
  }
  #volume-seekbar, .qualitySelector{
      top:85vh;
  }
  /*.video-js, .controlsdiv {
      transform: rotate(90deg);
  }
  .video-js{
    height:90vh;
  }
  .controlsdiv{
    height:90vh;
  }
  body{
      height:90vh;
  }*/
}
/* @media only screen and (max-width:560px){
    .videoOrient{
      transform: rotate(90deg);
    }
    .video-js{
      width:100vh;
      height:100vw;
    }
    #playdiv{
      position:absolute;
      top:46vw;
      right:46vh;
    }
    #forwarddiv{
      position:absolute;
      top:46vw;
      right:20vh;
    }
    #backwarddiv{
      position:absolute;
      top:46vw;
      right:70vh;
    }
  } */
@media all and (display-mode: fullscreen) {
  /* every CSS goes here that you want 
  to apply or alter in the fullscreen mode*/
  .bi-arrow-counterclockwise p, .bi-arrow-clockwise p{
    margin-top:-38px;
  }
  #remainDuration{
    margin-top:-6px;
  }
  #volume-bar{
    margin-top:6px;
  }
  .qualitySelector{
      top:90vh;
  }
}


  </style>
</head>
<body>
<!-- partial:index.partial.html -->
<div class="videoOrient" style="position:relative">
  <video id="my-video" playsinline="" class="video-js vjs-default-skin" >
     <source     
       src=  '<?php echo $url?>'; ;  
        type="application/x-mpegURL"> 
  </video>
  <div class="controlsdiv container-fluid p-5" style="position:absolute; top:0; color:#fff">
    <div style="position:absolute; top:10px; left:10px; display:flex">
      <i class="bi bi-arrow-left"></i>
      <h3 class="text-light ms-3 mt-1 text-c"><?= $_SESSION['title'] ?></h3>
    </div>
    <div id="fullscreendiv">
      <i class="bi bi-arrows-fullscreen" id="fullscreenicon"></i>
    </div>
    <div id="playdiv">
      <i class="bi bi-pause-fill" id="playcontrol"></i>
    </div>
    <div id="forwarddiv">
      <i class="bi bi-arrow-clockwise"><p>10</p></i>
    </div>
    <div id="backwarddiv">
      <i class="bi bi-arrow-counterclockwise"><p>10</p></i>
    </div>
    <div id="custom-seekbar" style="position:absolute; top:82vh;">
      <input type="range" id="customRange1" min="0"  value="0"/>
      <p id="remainDuration"></p>
    </div>
    <div id="volume-seekbar" style="">
      <div id="volume-bar">
        <input id="vol-control" type="range" min="0" max="1" step="0.01" >
      </div>
      <div id="volumediv"><i class="bi bi-volume-up-fill" id="volumeicon"></i></div>
    </div>
    <div class="qualitySelector"></div>
  </div>
  <!-- <div id="custom-seekbar" style="position:absolute; bottom:10vh;">
    <span></span>
  </div> -->
</div>
<!-- partial -->
  <script src='https://vjs.zencdn.net/7.14.3/video.js'></script>
  
  <script>
    $('#fullscreenicon').click(function(e) {
        e.preventDefault();
        $('.vjs-fullscreen-control').click();
        $(this).toggleClass('bi-fullscreen-exit', 'bi-arrows-fullscreen');
    });
    $('.bi-arrow-left').click(function(e) {
      e.preventDefault();
      window.history.go(-1);
    });
    document.addEventListener("fullscreenchange", function() {
      if (document.fullscreen) {
        $('.controlsdiv').appendTo($('.video-js'));
      }
      else{
        $('.bi-arrow-counterclockwise p, .bi-arrow-clockwise p').css({'margin-top':'-38px'});
        $('#remainDuration').css({'margin-top':'-6px'});
        $('#volume-bar').css({'margin-top':'6px'});
        $('.qualitySelector').css({'top':'89vh'});
      }
    });
    String.prototype.toHHMMSS = function () {
        var sec_num = parseInt(this, 10); // don't forget the second param
        var hours   = Math.floor(sec_num / 3600);
        var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
        var seconds = sec_num - (hours * 3600) - (minutes * 60);

        if (hours   < 10) {hours   = "0"+hours;}
        if (minutes < 10) {minutes = "0"+minutes;}
        if (seconds < 10) {seconds = "0"+seconds;}
        if(hours==0){
          return minutes+':'+seconds;
        }
        else{
          return hours+':'+minutes+':'+seconds;
        }
        
    }

    var vid = document.getElementById("my-video");
    vid.ontimeupdate = function(){
      var percentage = ( vid.currentTime / vid.duration ) * 100;
      //console.log(vid.currentTime);
      var remainTime = vid.duration - vid.currentTime;
      var time = (Math.floor(remainTime)).toString();
      if(!isNaN(time)){
      $('#remainDuration').text(time.toHHMMSS());
      }
      if(!isNaN(percentage)){
      $("#custom-seekbar input").val(percentage);
      }
      else{
        $("#custom-seekbar input").val(0);
      }
      if(remainTime ==0){
        window.history.go(-1);
      }
    };
    

    var sliderCanMove = false;

    $("#custom-seekbar").on("touchstart", function(e){
        sliderCanMove = true;
        if(sliderCanMove){
            var offset = $("#custom-seekbar").offset();
            if(e.clientX==undefined){
              var left = (e.targetTouches[0].screenX - offset.left);
            }
            else{
              var left = ((e.clientX ));
            }
            var totalWidth = $("#customRange1").width();
            var percentage = ( left / totalWidth );
            var vidTime = vid.duration * percentage;
            vid.currentTime = vidTime;
        }
        
    });

    $(window).on("touchmove", function(e){
        if(sliderCanMove){
            var offset = $("#custom-seekbar").offset();
            if(e.clientX==undefined){
              var left = (e.targetTouches[0].screenX - offset.left);
            }
            else{
              var left = ((e.clientX ));
            }
            var totalWidth = $("#customRange1").width();
            var percentage = ( left / totalWidth );
            var vidTime = vid.duration * percentage;
            vid.currentTime = vidTime;
        }
    });

    $(window).on("touchend", function(){
        sliderCanMove = false;
    });

    $(document).on("mouseover", '#volume-seekbar', function(){
        $('#volume-bar').show();
    });
    $(document).on("mouseout", '#volume-seekbar', function(){
        $('#volume-bar').hide();
    });
    // $(document).on("touchmove", '#volume-seekbar', function(){
    //     $('#volume-bar').show();
    // });
    // $(document).on("touchend", '#volumeicon', function(){
    //     $('#volume-bar').hide();
    // });

    $("#custom-seekbar").on("click", function(e){
        var offset = $(this).offset();
        if(e.clientX==undefined){
          var left = (e.targetTouches[0].screenX - offset.left);
        }
        else{
          var left = ((e.clientX ));
        }
        var left = (e.pageX - offset.left);
        var totalWidth = $("#customRange1").width();
        var percentage = ( left / totalWidth );
        var vidTime = vid.duration * percentage;
        vid.currentTime = vidTime;
    });
    // function thisVolume(volume_value)
    // {
    //     var myvideo = document.getElementById("my-video");
    //     document.getElementById("vol").innerHTML=volume_value;
    //     myvideo.volume = volume_value / 100;
        
    // }
    $(window).on("touchmove, touchstart", function(e){
      $(".controlsdiv").show().delay(6000).fadeOut();
    })
    $(window).on("mousemove", function(e){
      $(".controlsdiv").show().delay(6000).fadeOut();
    })

  </script>
  <script>
    //   videojs.options.vhs.overrideNative = true;
    //   videojs.options.html5.nativeAudioTracks = false;
    //   videojs.options.html5.nativeVideoTracks = false;
  videojs.Vhs.xhr.beforeRequest = function (options) {
  let newUri = options.uri.includes('.ts') ? options.uri + "?q=test" : options.uri;
  return {
    ...options,
    uri: newUri };
  };
  

if(performance.navigation.type || (browser != "Apple Safari")){
  var autoplay=false;
  $('#playcontrol').attr('class', 'bi bi-play-fill');
}
else{
  var autoplay='any';
}

var browser = (function() {
    var test = function(regexp) {return regexp.test(window.navigator.userAgent)}
    switch (true) {
        case test(/edg/i): return "Microsoft Edge";
        case test(/trident/i): return "Microsoft Internet Explorer";
        case test(/firefox|fxios/i): return "Mozilla Firefox";
        case test(/opr\//i): return "Opera";
        case test(/ucbrowser/i): return "UC Browser";
        case test(/samsungbrowser/i): return "Samsung Browser";
        case test(/chrome|chromium|crios/i): return "Google Chrome";
        case test(/safari/i): return "Apple Safari";
        default: return "Other";
    }
})();

let player = videojs("my-video", {controls : false,responsive: true,autoplay: autoplay}, () => {
  player.one("loadedmetadata", () => {
    if(browser != "Apple Safari"){
    window.qualities = player.
    tech({IWillNotUseThisInPlugins : true }).
    vhs.representations();
    if((qualities.length) >1){
    createButtonsQualities({
      class: "item",
      qualities: qualities,
      father: player.controlBar.el_ });
    }
    }
    // if ( player.paused ) {
    //     player.play();
    // } else {
    //     player.pause();
    // }
    // if ( player.muted() ) {
    //     player.pause();
    //     player.muted(false);
    //      $('#playcontrol').removeClass('bi-pause-fill').addClass('bi-play-fill');
    // } else {
    //     player.play();
    //      $("#playcontrol").removeClass('bi-play-fill').addClass('bi-pause-fill');
    // }
    // player.play();
    // $('.vjs-mute-control').click();
    // player.volume(0.5);
    $(document).on('click', '#playcontrol', function(){
      if(($(this).attr('class')).includes('bi-play-fill')){
        player.play();
        $(this).removeClass('bi-play-fill').addClass('bi-pause-fill');
      }
      else{
        player.pause();
        $(this).removeClass('bi-pause-fill').addClass('bi-play-fill');
      }
      
    });
    $(document).on('click', '.bi-arrow-clockwise', function(){
      $(this).children().css({"zoom": "1.3"}).fadeOut();
      player.currentTime(player.currentTime() + 10);
      //$(this).css({"zoom": "1"}).fadeIn();
      $(this).children().css({"zoom": "1"}).fadeIn();
    });
    $(document).on('click', '.bi-arrow-counterclockwise', function(){
      $(this).children().css({"zoom": "1.3"}).fadeOut();
      player.currentTime(player.currentTime() - 10);
      $(this).children().css({"zoom": "1"}).fadeIn();
    });
    $(document).on('change', '#vol-control', function(){
      if($('#vol-control').val()== 0){
        $('#volumeicon').attr('class', 'bi bi-volume-mute-fill');
      }
      else if($('#vol-control').val() <=0.5){
        if(player.muted()){
            player.muted(false);
            $('#volumeicon').attr('class', 'bi bi-volume-down-fill');
        }
        $('#volumeicon').attr('class', 'bi bi-volume-down-fill');
      }
      else{
        if(player.muted()){
            player.muted(false);
            $('#volumeicon').attr('class', 'bi bi-volume-up-fill');
        }
        $('#volumeicon').attr('class', 'bi bi-volume-up-fill');
      }
      player.volume($('#vol-control').val());
    })
    $("video").bind("contextmenu",function(){
        return false;
    });
    $(document).on('click', '#volumeicon', function(){
      var volumeClass = $(this).attr('class');
      if(volumeClass.includes('volume-up-fill')|| volumeClass.includes('volume-down-fill')){
        $('#volumeicon').attr('class', 'bi bi-volume-mute-fill');
        $('#vol-control').val(0);
        player.muted(true);
      }
      else{
        if(player.volume() <= 0.5){
          $('#volumeicon').attr('class', 'bi bi-volume-down-fill');
        }
        else{
          $('#volumeicon').attr('class', 'bi bi-volume-up-fill');
        }
        player.muted(false);
        $('#vol-control').val(player.volume());
      }
    })
    if(player.muted()){
      $('#volumeicon').attr('class', 'bi bi-volume-mute-fill');
      $('#vol-control').val(0);
    }
      //
    
    // ---------------------------------------------- //

    function createAutoQualityButton(params) {
      let button = document.createElement("div");

      button.id = "auto";
      button.innerText = `Auto`;

      button.classList.add("selected");

      if (params && params.class) button.classList.add(params.class);

      button.addEventListener("click", () => {
        removeSelected(params);
        button.classList.add("selected");
        qualities.map(quality => quality.enabled(true));
      });

      return button;
    }

    function createButtonsQualities(params) {

      let contentMenu = document.createElement('div');
      let menu = document.createElement('div');
      let icon = document.createElement('div');

      let fullscreen = params.father.querySelector('.vjs-fullscreen-control');
      contentMenu.appendChild(icon);
      contentMenu.appendChild(menu);
      $('.qualitySelector').html(contentMenu);

      menu.classList.add('menu');
      icon.classList.add('icon', 'vjs-icon-cog');
      contentMenu.classList.add('contentMenu');

      let autoButton = createAutoQualityButton(params);

      menu.appendChild(autoButton);

      qualities.sort((a, b) => {
        return a.height > b.height ? 1 : 0;
      });

      qualities.map(quality => {
        let button = document.createElement("div");

        if (params && params.class) button.classList.add(params.class);

        button.id = `${quality.height}`;
        button.innerText = quality.height + "p";

        button.addEventListener("click", () => {
          resetQuality(params);
          button.classList.add("selected");
          quality.enabled(true);
        });

        menu.appendChild(button);
      });

      setInterval(() => {
        let auto = document.querySelector("#auto");
        current = player.
        tech({ IWillNotUseThisInPlugins: true }).
        vhs.selectPlaylist().attributes.RESOLUTION.height;
        //console.log(current);

        document.querySelector("#auto").innerHTML = auto.classList.contains(
        "selected") ?

        `Auto <span class='current'>${current}p</span>` :
        "Auto";
      }, 1000);


    }

    function removeSelected(params) {
      document.querySelector("#auto").classList.remove("selected");
      [...document.querySelectorAll(`.${params.class}`)].map(quality => {
        quality.classList.remove("selected");
      });
    }

    function resetQuality(params) {
      removeSelected(params);

      for (let quality of params.qualities) {
        quality.enabled(false);
      }
    }
  });
});
    
</script>

</body>
</html>
