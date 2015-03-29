<?php
/*
Template Name: iFrame Multiplayer
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
		
		  echo '<style>.mejs-playlist { height: 280px !important; }</style>	
		  		<div id="mediawrapper" style="height: 365px; width: 100%;">
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
				  </div>
				  <br><br><br>';
				  
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
					<h2>iFramePlayer manuell bearbeiten?</h2>
					<p>';
     					edit_post_link('Jetzt bearbeiten'); echo ' | <a target="_blank" href="?method=ml&iframeplayer=1">Vorschau</a>
     				</p>
     				<p><i>(i) Diese Seiten können nur angemeldete Nutzer sehen! Beim Aufruf dieser Seite werden Leser auf die Startseite weitergeleitet.</i></p>';
     				
     				echo '<hr />
     				<h4>Automatische Liste durch Podlove Pubisher</h4>
     				<p>
     					<a target="_blank" href="?method=pl&iframeplayer=1">iFrameMeultiplayer Ansehen</a></li>
     				</p>';
     			echo '</div>';
			}
		  	
		}

?>
<script>$(function(){$('video,audio').mediaelementplayer({loop: false,shuffle: false,playlist: true,audioHeight: 30,playlistposition: 'bottom', features: ['playlistfeature', 'prevtrack', 'playpause', 'nexttrack', 'loop', 'shuffle', 'playlist', 'current', 'progress', 'duration', 'volume'],keyActions: []});});</script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/mediaelement/mediaelement-and-player.min.js"></script>
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-includes/js/mediaelement/wp-mediaelement.js"></script>
<link rel="stylesheet" id="mediaelement-css" href="<?php echo site_url(); ?>/wp-includes/js/mediaelement/mediaelementplayer.min.css" type="text/css" media="all">
<link rel="stylesheet" id="wp-mediaelement-css" href="<?php echo site_url(); ?>/wp-includes/js/mediaelement/wp-mediaelement.css" type="text/css" media="all">
<?
//out of scop
#<script type="text/javascript" src="<?php echo site_url(); /wp-content/plugins/iFrameMultiplayer/playlist.js"></script>
?>
<script>
(function($) {
  $.extend(mejs.MepDefaults, {
    loopText: 'Repeat On/Off',
    shuffleText: 'Shuffle On/Off',
    nextText: 'Next Track',
    prevText: 'Previous Track',
    playlistText: 'Show/Hide Playlist'
  });

  $.extend(MediaElementPlayer.prototype, {
    // LOOP TOGGLE
    buildloop: function(player, controls, layers, media) {
      var t = this;

      var loop = $('<div class="mejs-button mejs-loop-button ' + ((player.options.loop) ? 'mejs-loop-on' : 'mejs-loop-off') + '">' +
        '<button type="button" aria-controls="' + player.id + '" title="' + player.options.loopText + '"></button>' +
        '</div>')
        // append it to the toolbar
        .appendTo(controls)
        // add a click toggle event
        .click(function(e) {
          player.options.loop = !player.options.loop;
          $(media).trigger('mep-looptoggle', [player.options.loop]);
          if (player.options.loop) {
            loop.removeClass('mejs-loop-off').addClass('mejs-loop-on');
            //media.setAttribute('loop', 'loop');
          }
          else {
            loop.removeClass('mejs-loop-on').addClass('mejs-loop-off');
            //media.removeAttribute('loop');
          }
        });

      t.loopToggle = t.controls.find('.mejs-loop-button');
    },
    loopToggleClick: function() {
      var t = this;
      t.loopToggle.trigger('click');
    },
    // SHUFFLE TOGGLE
    buildshuffle: function(player, controls, layers, media) {
      var t = this;

      var shuffle = $('<div class="mejs-button mejs-shuffle-button ' + ((player.options.shuffle) ? 'mejs-shuffle-on' : 'mejs-shuffle-off') + '">' +
        '<button type="button" aria-controls="' + player.id + '" title="' + player.options.shuffleText + '"></button>' +
        '</div>')
        // append it to the toolbar
        .appendTo(controls)
        // add a click toggle event
        .click(function(e) {
          player.options.shuffle = !player.options.shuffle;
          $(media).trigger('mep-shuffletoggle', [player.options.shuffle]);
          if (player.options.shuffle) {
            shuffle.removeClass('mejs-shuffle-off').addClass('mejs-shuffle-on');
          }
          else {
            shuffle.removeClass('mejs-shuffle-on').addClass('mejs-shuffle-off');
          }
        });

      t.shuffleToggle = t.controls.find('.mejs-shuffle-button');
    },
    shuffleToggleClick: function() {
      var t = this;
      t.shuffleToggle.trigger('click');
    },
    // PREVIOUS TRACK BUTTON
    buildprevtrack: function(player, controls, layers, media) {
      var t = this;

      var prevTrack = $('<div class="mejs-button mejs-prevtrack-button mejs-prevtrack">' +
        '<button type="button" aria-controls="' + player.id + '" title="' + player.options.prevText + '"></button>' +
        '</div>')
        .appendTo(controls)
        .click(function(e){
          $(media).trigger('mep-playprevtrack');
          player.playPrevTrack();
        });

      t.prevTrack = t.controls.find('.mejs-prevtrack-button');
    },
    prevTrackClick: function() {
      var t = this;
      t.prevTrack.trigger('click');
    },
    // NEXT TRACK BUTTON
    buildnexttrack: function(player, controls, layers, media) {
      var t = this;

      var nextTrack = $('<div class="mejs-button mejs-nexttrack-button mejs-nexttrack">' +
        '<button type="button" aria-controls="' + player.id + '" title="' + player.options.nextText + '"></button>' +
        '</div>')
        .appendTo(controls)
        .click(function(e){
          $(media).trigger('mep-playnexttrack');
          player.playNextTrack();
        });

      t.nextTrack = t.controls.find('.mejs-nexttrack-button');
    },
    nextTrackClick: function() {
      var t = this;
      t.nextTrack.trigger('click');
    },
    // PLAYLIST TOGGLE
    buildplaylist: function(player, controls, layers, media) {
      var t = this;

      var playlistToggle = $('<div class="mejs-button mejs-playlist-button ' + ((player.options.playlist) ? 'mejs-hide-playlist' : 'mejs-show-playlist') + '">' +
        '<button type="button" aria-controls="' + player.id + '" title="' + player.options.playlistText + '"></button>' +
        '</div>')
        .appendTo(controls)
        .click(function(e) {
          player.options.playlist = !player.options.playlist;
          $(media).trigger('mep-playlisttoggle', [player.options.playlist]);
          if (player.options.playlist) {
            layers.children('.mejs-playlist').show();
            playlistToggle.removeClass('mejs-show-playlist').addClass('mejs-hide-playlist');
          }
          else {
            layers.children('.mejs-playlist').hide();
            playlistToggle.removeClass('mejs-hide-playlist').addClass('mejs-show-playlist');
          }
        });

      t.playlistToggle = t.controls.find('.mejs-playlist-button');
    },
    playlistToggleClick: function() {
      var t = this;
      t.playlistToggle.trigger('click');
    },
    // PLAYLIST WINDOW
    buildplaylistfeature: function(player, controls, layers, media) {
      var playlist = $('<div class="mejs-playlist mejs-layer">' +
        '<ul class="mejs"></ul>' +
        '</div>')
        .appendTo(layers);
      if (!player.options.playlist) {
        playlist.hide();
      }
      if (player.options.playlistposition == 'bottom') {
        playlist.css('top', player.options.audioHeight + 'px');
      }
      else {
        playlist.css('bottom', player.options.audioHeight + 'px');
      }
      var getTrackName = function(trackUrl) {
        var trackUrlParts = trackUrl.split("/");
        if (trackUrlParts.length > 0) {
          return decodeURIComponent(trackUrlParts[trackUrlParts.length-1]);
        }
        else {
          return '';
        }
      };

      // calculate tracks and build playlist
      var tracks = [];
      //$(media).children('source').each(function(index, element) { // doesn't work in Opera 12.12
      $('#'+player.id).find('.mejs-mediaelement source').each(function(index, element) {
        if ($.trim(this.src) != '') {
          var track = {};
          track.source = $.trim(this.src);
          if ($.trim(this.title) != '') {
            track.name = $.trim(this.title);
          }
          else {
            track.name = getTrackName(track.source);
          }
          tracks.push(track);
        }
      });
      for (var track in tracks) {
        layers.find('.mejs-playlist > ul').append('<li data-url="' + tracks[track].source + '" title="' + tracks[track].name + '"><img style="width:20px;" src="<?php echo site_url(); ?>/wp-content/plugins/iFrameMultiplayer/logo.jpg"> <div id="lemmer">' + tracks[track].name + '</div></li>');
      }

      // set the first track as current
      layers.find('li:first').addClass('current played');
      // play track from playlist when clicking it
      layers.find('.mejs-playlist > ul li').click(function(e) {
        if (!$(this).hasClass('current')) {
          $(this).addClass('played');
          player.playTrack($(this));
        }
        else {
          player.play();
        }
      });

      // when current track ends - play the next one
      media.addEventListener('ended', function(e) {
        player.playNextTrack();
      }, false);
    },
    playNextTrack: function() {
      var t = this;
      var tracks = t.layers.find('.mejs-playlist > ul > li');
      var current = tracks.filter('.current');
      var notplayed = tracks.not('.played');
      if (notplayed.length < 1) {
        current.removeClass('played').siblings().removeClass('played');
        notplayed = tracks.not('.current');
      }
      if (t.options.shuffle) {
        var random = Math.floor(Math.random()*notplayed.length);
        var nxt = notplayed.eq(random);
      }
      else {
        var nxt = current.next();
        if (nxt.length < 1 && t.options.loop) {
          nxt = current.siblings().first();
        }
      }
      if (nxt.length == 1) {
        nxt.addClass('played');
        t.playTrack(nxt);
      }
    },
    playPrevTrack: function() {
      var t = this;
      var tracks = t.layers.find('.mejs-playlist > ul > li');
      var current = tracks.filter('.current');
      var played = tracks.filter('.played').not('.current');
      if (played.length < 1) {
        current.removeClass('played');
        played = tracks.not('.current');
      }
      if (t.options.shuffle) {
        var random = Math.floor(Math.random()*played.length);
        var prev = played.eq(random);
      }
      else {
        var prev = current.prev();
        if (prev.length < 1 && t.options.loop) {
          prev = current.siblings().last();
        }
      }
      if (prev.length == 1) {
        current.removeClass('played');
        t.playTrack(prev);
      }
    },
    playTrack: function(track) {
      var t = this;
      t.pause();
      t.setSrc(track.attr('data-url'));
      t.load();
      t.play();
      track.addClass('current').siblings().removeClass('current');
    },
    playTrackURL: function(url) {
      var t = this;
      var tracks = t.layers.find('.mejs-playlist > ul > li');
      var track = tracks.filter('[data-url="'+url+'"]');
      t.playTrack(track);
    }
  });

})(mejs.$);
</script>

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
					<h2>iFramePlayer manuell bearbeiten?</h2>
					<p>';
     					edit_post_link('Jetzt bearbeiten'); echo ' | <a target="_blank" href="?method=ml&iframeplayer=1">Vorschau</a>
     				</p>
     				<p><i>(i) Diese Seiten können nur angemeldete Nutzer sehen! Beim Aufruf dieser Seite werden Leser auf die Startseite weitergeleitet.</i></p>';
     				
     				echo '<hr />
     				<h4>Automatische Liste durch Podlove Pubisher</h4>
     				<p>
     					<a target="_blank" href="?method=pl&iframeplayer=1">iFrameMeultiplayer Ansehen</a></li>
     				</p>';
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
				<h2>iFramePlayer manuell bearbeiten?</h2>
				<p>';
     				edit_post_link('Jetzt bearbeiten'); echo ' | <a target="_blank" href="?method=ml&iframeplayer=1">Vorschau</a>
     			</p>
     			<p><i>(i) Diese Seiten können nur angemeldete Nutzer sehen! Beim Aufruf dieser Seite werden Leser auf die Startseite weitergeleitet.</i></p>';
     				
     			echo '<hr />
     			<h4>Automatische Liste durch Podlove Pubisher</h4>
     			<p>
     				<a target="_blank" href="?method=pl&iframeplayer=1">iFrameMeultiplayer Ansehen</a></li>
     			</p>';
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
				<h2>iFramePlayer manuell bearbeiten?</h2>
				<p>';
     				edit_post_link('Jetzt bearbeiten'); echo ' | <a target="_blank" href="?method=ml&iframeplayer=1">Vorschau</a>
     			</p>
     			<p><i>(i) Diese Seiten können nur angemeldete Nutzer sehen! Beim Aufruf dieser Seite werden Leser auf die Startseite weitergeleitet.</i></p>';
     				
     			echo '<hr />
     			<h4>Automatische Liste durch Podlove Pubisher</h4>
     			<p>
     				<a target="_blank" href="?method=pl&iframeplayer=1">iFrameMeultiplayer Ansehen</a></li>
     			</p>';
     	echo '</div>';
	}
}
		
?>