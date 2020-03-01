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
      add_shortcode('formulario','realizar_formulario');
	}



  function realizar_formulario($args){
           $formulario='<form action="" method="post">
                <label><b>Dinos tu artista favorito</b></label> 
                <p>Artista: <input type="text" name="artista"></p>
                <p>Canción: <input type="text" name="cancion"></p>
                <p>
                  <input type="submit" value="Enviar">
                  <input type="reset" value="Borrar">
                </p>
            </form>';

            return $formulario;

            

  }

	function obtener_letra($args,$content){

                /*$formulario='<div><form action="" method="post">
                <label>Dinos tu artista favorito</label> 
                <p>Artista: <input type="text" name="artista"></p>
                <p>Canción: <input type="text" name="cancion"></p>
                <p>
                  <input type="submit" value="Enviar">
                  <input type="reset" value="Borrar">
                </p>
            </form></div>';

                echo $formulario;*/

              $artista= $_POST['artista'];

              $cancion= $_POST['cancion'];

              $artista_noespacios = str_replace(" ", "%20", $artista);

              $cancion_noespacios = str_replace(" ", "%20", $cancion);

             
            //$url="https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track=".$args['cancion'].".&q_artist=".$args['artista']."&apikey=f37bb1f59ec257857a2086c7bdb4a1ea";

            $url="https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track=".$cancion_noespacios.".&q_artist=".$artista_noespacios."&apikey=f37bb1f59ec257857a2086c7bdb4a1ea";
          
            $result = file_get_contents($url);
              
            $datos = json_decode($result,true);


            $letra = $datos['message']['body']['lyrics']['lyrics_body'];

            $letra_ordenada = str_replace("\n", "</br>", $letra);




            return  "<div><p><strong>".$cancion."-".$artista."</strong></p><p>".$letra_ordenada."</p></div>";
           // return $datos['message']['body']['lyrics']['lyrics_body'];
                      
	}

?>
