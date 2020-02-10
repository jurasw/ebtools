<!DOCTYPE html>
<html>
    <head>
        
        <title> AR Invitation </title>
        <meta name="viewport" content="width=device-width,height=device-height">
	<meta name="apple-mobile-web-app-capable" content="yes">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
     
        <script src="https://aframe.io/releases/0.8.2/aframe.min.js"></script>
        <script src="https://cdn.rawgit.com/jeromeetienne/AR.js/1.5.5/aframe/build/aframe-ar.js"></script>    
        <script>
            // Invitation Video Handler
            
            AFRAME.registerComponent('video-vidhandler', {
                init: function() {
		    console.log('video init entered');
                    this.toggle = false;
                    this.vid = document.querySelector("#invitation");
                    this.vid.pause();
                },
                tick: function() {
                    if (this.el.object3D.visible == true) {
                        if (!this.toggle) {
                            this.toggle = true;
                            this.vid.play();
                        }
                    } else {
                        this.toggle = false;
                        this.vid.pause();
                    }
                }
            });

            // Count down Timer and Countdown Timer Component

            AFRAME.registerComponent('clock-text', {
                init: function() {
		    console.log('Timer init entered');
                    var el = this.el;
                    this.ready = false;
		    el.addEventListener('textfontset', function() {
    	            	this.ready = true;
		    }.bind(this));
                },
                tick: function() {
  	        	var el = this.el;
                    if (!this.ready) {
    	                return;
                    }

                    var endTime = new Date("May 29, 2020 00:54:00").getTime();
                    var timeRem;

                    var timer = setInterval(function() {
                        var currTime = new Date().getTime();

                        var diff = endTime - currTime;

                        if(diff > 0) {
                            var days = Math.floor(diff / (1000 * 60 * 60 * 24));
                            var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                            var mins = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
                            var secs = Math.floor((diff % (1000 * 60)) / 1000);
                            //console.log(days, hours, mins, secs);
                            var timeRem = days + " days " + hours + " hrs " + mins + " mins " + secs + " secs ";
                            //console.log(timeRem);
                        } else {
                            var timeRem = "Finally! The day has come.";
                        }
                        el.setAttribute('value', timeRem);
                    }, 1000);
                    
                }
            });
		
		
	    // Mappoint component
		
	    AFRAME.registerComponent('mappoint-handler', {
            
		init: function() {
		    //console.log("I was triggered");
		    const marker3 = document.querySelector("#marker3");
		    const imgMap = document.querySelector("#img-map");
			
		    marker3.addEventListener('click', function(ev, target) {
		        const intersectedElement = ev && ev.detail && ev.detail.intersectedEl;
			if (imgMap && intersectedElement === imgMap) {
			    console.log("Clicked");
			    document.location.href = "https://goo.gl/maps/gRsth6SHo5AgwMbT7";
			}
		    });
		}
	    });
			
        </script>


    </head>
    <body>
      
        <h1><a style="font-family: 'Arial';" href="<?php  echo "https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id={$client_id}&redirect_uri={$redirect_uri}&state={$csrf_token}&scope={$scopes}"; ?>">Sign in with LinkedIn</a></h1>
      
        <a-scene id="scene" arjs='trackingMethod: best; debugUIEnabled: false;' vr-mode-ui="enabled: false" ar-template >
            
            <a-assets>

                
                <!-- Invitation  Video -->
                
                <video preload="none" id="invitation" response-type="arraybuffer" loop="false" crossorigin webkit-playsinline playsinline controls>
                    <source  src="videos/invitation.mp4">
                </video>

                <!-- Map point Image -->

                <img id="map-point" src="images/map-navigate.jpg">     
                
                <!-- Texture Image -->

                <img id="texture" src="images/texture.jpg">

            </a-assets>
            
           
            
            <!-- Invitation Video Marker -->

            <a-marker preset="kanji" video-vidhandler>
                <!--<a-box position='0 0 0' material='color: red;'></a-box>-->
                <a-plane scale = "7 3" position='2 0 -1' rotation="-90 0 0" material='transparent:true;src:#invitation' controls></a-plane>
                <!--<a-entity text="font: https://cdn.aframe.io/fonts/mozillavr.fnt; value: Fun Moments"></a-entity>-->
            </a-marker>

            <!-- Count down Timer Marker -->

            <a-marker id="marker2" type='pattern' url='markers/timer-pattern-marker.patt'>
                <!--<a-box position='0 0 0' material='color: red;'></a-box>-->
                <!--<a-plane scale = "4 2" position='0 0.1 0' rotation="-90 0 0" material='transparent:true;src:#invitation' controls></a-plane>-->
                <!--<a-entity text="font: https://cdn.aframe.io/fonts/mozillavr.fnt; value: Fun Moments"></a-entity>-->

                <a-plane scale="2 1" position="0 0.1 0" rotation="-90 0 0" src="#texture">
                    <a-text id="timer" clock-text value="00:00:00:00" width="1.5" height="1" position="-0.451 0.041 0.000" color="#FFFFFF"></a-text>
                </a-plane>

                
            </a-marker>

            <!-- Map Location Marker -->

            <a-marker id="marker3" type='pattern' url='markers/map-pattern-marker.patt' emitevents="true" cursor="rayOrigin: mouse" mappoint-handler>
                <!--<a-box position='0 0 0' material='color: red;'></a-box>-->
                <a-plane id="img-map" scale = "2 2" position='0 0.1 0' rotation="-90 0 0" material='transparent:true;src:#map-point'></a-plane>
                <!--<a-entity text="font: https://cdn.aframe.io/fonts/mozillavr.fnt; value: Fun Moments"></a-entity>-->
            </a-marker>     
  
            <!-- Camera -->

            <a-entity camera></a-entity>

        </a-scene>



        
    </body>
</html>