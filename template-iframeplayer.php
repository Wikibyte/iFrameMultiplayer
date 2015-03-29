<?php
/*
Template Name: Iframe Player
*/
if (isset($_GET["iframeplayer"]) && !empty($_GET["iframeplayer"])) {
  $iframe_get = $_GET["iframeplayer"];
  if ($iframe_get == '1'){ 

	echo '<html>
 		<head>
			<script type="text/javascript" src="http://cdn.jsdelivr.net/jquery/1.10.2/jquery-1.10.2.min.js"></script>
 		</head>
		<body style="margin:0; padding:0;">';

	//Methoden:
	if (isset($_GET["method"]) && !empty($_GET["method"])) {
		$podlove_get = $_GET["method"];
		if ($podlove_get == 'pl'){ 
		
		  echo '<div id="mediawrapper" style="height:280px; width: 100%;">
				<audio type="audio/mp3" controls="controls" style="width: 100%;">';
				
			$args = array( 
				'post_type' => 'podcast', 
				'posts_per_page' => 10, 
				'orderby' => 'rand' 
			);
			$loop = new WP_Query( $args );
			while ( $loop->have_posts() ) : $loop->the_post();
	
				echo '<Source src="'. do_shortcode( '[podlove-template id="podlove-web-player"]' ) .'" title="'.get_the_title( $ID ).'"></Source>';
	
			endwhile;
		
			echo '</audio>
				  </div>';
				  
		} elseif($podlove_get == 'ml') {
		
			#echo '<div id="mediawrapper" style="height:280px; width: 100%;">
			#	<audio type="audio/mp3" controls="controls" style="width: 100%;">';
			
				while ( have_posts() ) : the_post();

				remove_filter ('the_content', 'wpautop');
				the_content();
				
				endwhile;
			
			#echo '</audio>
			#	  </div>';
			
		} else {
			
			#Keine Angaben der Methode
			if ( !is_user_logged_in() ) {
     			//Weiterleitung aktiv
				header ( "location: " . site_url() ); 
			} else {
     			echo '<div style="padding: 20px; background: #fefefe; border:1px solid #eee;">
					<h2>iFramePlayer manuell bearbeiten?</h2>';
     				edit_post_link('Jetzt bearbeiten', '<p>', '</p>');
     			echo '</div>';
			}
		  	
		}

?>
<script>$(function(){$('video,audio').mediaelementplayer({loop: true,shuffle: true,playlist: true,audioHeight: 30,playlistposition: 'bottom', features: ['playlistfeature', 'prevtrack', 'playpause', 'nexttrack', 'loop', 'shuffle', 'playlist', 'current', 'progress', 'duration', 'volume'],keyActions: []});});</script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/mediaelement/mediaelement-and-player.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/mediaelement/wp-mediaelement.js"></script>
<link rel="stylesheet" id="mediaelement-css" href="<?php echo site_url(); ?>/wp-includes/js/mediaelement/mediaelementplayer.min.css" type="text/css" media="all">
<link rel="stylesheet" id="wp-mediaelement-css" href="<?php echo site_url(); ?>/wp-includes/js/mediaelement/wp-mediaelement.css" type="text/css" media="all">
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/plugins/iFrameMultiplayer/playlist.js"></script>
<link type="text/css" rel="stylesheet" href="<?php echo site_url(); ?>/wp-content/plugins/iFrameMultiplayer/playlist.css" />
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/plugins/iFrameMultiplayer/js/iframeResizer.contentWindow.min.js"></script> 
</body>
</html>	
<?php

	} else {
		#Keine Angaben der Methode
		if ( !is_user_logged_in() ) {
     		//Weiterleitung aktiv
			header ( "location: " . site_url() ); 
		} else {
     		echo '<div style="padding: 20px; background: #fefefe; border:1px solid #eee;">
				<h2>iFrameMultiplayer manuell bearbeiten?</h2>';
     			edit_post_link('Jetzt bearbeiten', '<p>', '</p>');
     		echo '<p><i>(i) Diese Seiten können nur angemeldete Nutzer sehen! Beim Aufruf dieser Seite werden Leser auf die Startseite weitergeleitet.</i></p>';
     		echo '</div>';
		}
	}


  } else {	
	#Keine Angaben der Methode
	if ( !is_user_logged_in() ) {
     	//Weiterleitung aktiv
		header ( "location: " . site_url() ); 
	} else {
     	echo '<div style="padding: 20px; background: #fefefe; border:1px solid #eee;">
			<h2>iFramePlayer manuell bearbeiten?</h2>';
     		edit_post_link('Jetzt bearbeiten', '<p>', '</p>');
     		echo '<p><i>(i) Diese Seiten können nur angemeldete Nutzer sehen! Beim Aufruf dieser Seite werden Leser auf die Startseite weitergeleitet.</i></p>';
     	echo '</div>';
	}
	
  }

} else {
	#Keine Angaben der Methode
	if ( !is_user_logged_in() ) {
     	//Weiterleitung aktiv
		header ( "location: " . site_url() ); 
	} else {
     	echo '<div style="padding: 20px; background: #fefefe; border:1px solid #eee;">
			<h2>iFramePlayer manuell bearbeiten?</h2>';
     		edit_post_link('Jetzt bearbeiten', '<p>', '</p>');
     		echo '<p><i>(i) Diese Seiten können nur angemeldete Nutzer sehen! Beim Aufruf dieser Seite werden Leser auf die Startseite weitergeleitet.</i></p>';
     	echo '</div>';
	}
}
		
?>