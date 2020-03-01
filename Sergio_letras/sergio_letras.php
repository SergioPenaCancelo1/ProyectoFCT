<?php
/*
Plugin Name: Letras de canciones
Plugin URI: 
Description: Pasandole el titulo de una cancion devuelve la letra de dicha cancion
Version: 1.0
Author: Sergio
Author URI:
License: GPL2
*/

add_action('init','sergio_registrer_shortcodes');


	function sergio_registrer_shortcodes() {
			add_shortcode('letra','obtener_letra');
	}

	function obtener_letra($args,$content){
          // return "esto es una prueba del plugin de letras";

           //return $content.' '.$args['cancion'].' '.$args['artista'] ;

           //$result = wp_remote_get('La URL'.$args['cancion'].$args['artista'].'continuacion de la URL');


            

        
            //$result = wp_remote_get('https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track=iron%20maiden&q_artist=iron%20maiden&apikey=f37bb1f59ec257857a2086c7bdb4a1ea');

            //$result = wp_remote_get('https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track='.$args['cancion'].'.&q_artist='.$args['artista'].'&apikey=f37bb1f59ec257857a2086c7bdb4a1ea');

             //return result['body'];
           
             $url="https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track=".$args['cancion'].".&q_artist=".$args['artista']."&apikey=f37bb1f59ec257857a2086c7bdb4a1ea";
          
            $result = file_get_contents($url);
              
             $datos = json_decode($result,true);

           return $datos;

           
	}

?>