<?php
/*
Plugin Name: iFrame MultiPlayer
Plugin URI: http://wikibyte.org/
Description: Entwickelt für ohneQ - iFrame Multiplayer API + Post_Type: Podlove
Author: Michael McCouman Jr.
Version: 1.0.2
Author URI: http://twitter.com/mccouman
*/

// [iFramePlayer width="100" test="on"]
function iframe_func( $atts, $content = null ) {
   //Vars
  extract( 
  	shortcode_atts( 
  		array( 
  			'width' => '',  		
  			'test' => 'off', 
  			'page' => '',
  			'podlove' => '',	
  		), 
  	$atts ) 
  );
  

if($test == 'on'){
$test_out = "<p id='callback'></p>
<script type='text/javascript'>
			//READ ALL CALLBACKS
			iFrameResize({
				log                     : true,                  // Enable console logging
				enablePublicMethods     : true,                  // Enable methods within iframe hosted page
				resizedCallback         : function(messageData){ // Callback fn when resize is received
					$('p#callback').html(
						'<b>Frame ID:</b> '    + messageData.iframe.id +
						' <b>Height:</b> '     + messageData.height +
						' <b>Width:</b> '      + messageData.width + 
						' <b>Event type:</b> ' + messageData.type
					);
				},
				messageCallback         : function(messageData){ // Callback fn when message is received
					$('p#callback').html(
						'<b>Frame ID:</b> '    + messageData.iframe.id +
						' <b>Message:</b> '    + messageData.message
					);
					alert(messageData.message);
				},
				closedCallback         : function(id){ // Callback fn when iFrame is closed
					$('p#callback').html(
						'<b>IFrame (</b>'    + id +
						'<b>) removed from page.</b>'
					);
				}
			});
</script>";
} else {
	$test_out = "<script type='text/javascript'>iFrameResize({ enablePublicMethods: true});</script>";
}

if(esc_attr($width)) {
	$width_out = "width='".esc_attr($width)."%'"; 
} else {
	$width_out = "width='100%'";
}


if($test == 'on'){
	//help: test
	$linktest = "".site_url()."/wp-content/plugins/iFrameMultiplayer/test/content.html";
} else {
	if(esc_attr($podlove) == '1'){
		$_out = '?method=pl&iframeplayer=1';
	} else {
		$_out = '?method=ml&iframeplayer=1';
	}
	
	if( esc_attr($page) ){
		$page_out = esc_attr($page);
		$linktest = "".site_url()."/".$page_out."/".$_out;
		
	} else {
		//help: install
		$linktest = site_url()."/wp-content/plugins/iFrameMultiplayer/test/info-link.html";	
	}
}


	//player out
	$iframe_out ="<iframe id='test' ".$width_out." src='".$linktest."' scrolling='yes' frameBorder='0'></iframe>";	


return "<!--iframe player start-->
	<script src='https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
	<script type='text/javascript'>
		if (!Array.prototype.forEach){
				Array.prototype.forEach = function(fun /*, thisArg */){
				'use strict';
				if (this === void 0 || this === null || typeof fun !== 'function') throw new TypeError();
				
				var
				t = Object(this),
				len = t.length >>> 0,
				thisArg = arguments.length >= 2 ? arguments[1] : void 0;

				for (var i = 0; i < len; i++)
				if (i in t)
					fun.call(thisArg, t[i], i, t);
				};
		}
	</script>
	
	".$iframe_out."
	<script type='text/javascript' src='".site_url()."/wp-content/plugins/iFrameMultiplayer/js/jquery.iframeResizer.min.js'></script>
	".$test_out."
	<!--//iframe player end-->";
}
add_shortcode( 'iFrameMultiplayer', 'iframe_func' );





// [Episode title="Meine tolle Episode"]http://localhost:8888/dwdns-31-talk-mit-ted.mp3[/Episode]
function playlisting_func( $atts, $content = null ) {

 //Vars
  extract( 
  	shortcode_atts( 
  		array( 
  			'title' => 'episodenname',
  		), 
  	$atts ) 
  );
  return "<Source src='".$content."' title='".$title."'></Source>";

}
add_shortcode( 'Episode', 'playlisting_func' );
