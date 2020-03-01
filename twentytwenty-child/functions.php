<?php 
//CARGA EL STYLE.CSS DEL TEMA PADRE EN EL TEMA HIJO
 
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
}
 //require('obtener_letra.php');

  /*add_shortcode('lyrics','obtener_letra_canciones');
	

	function obtener_letra_canciones($args,$content){
           
           $formulario='<div><form action="" method="post">
                <label>Dinos tu artista favorito</label> 
                <p>Artista: <input type="text" name="artista"></p>
                <p>Canción: <input type="text" name="cancion"></p>
                <p>
                  <input type="submit" value="Enviar">
                  <input type="reset" value="Borrar">
                </p>
            </form></div>';

                echo $formulario;
              

              /*?> 
                          <form action="" method="get">
  							<label>Dinos tu artista favorito</label> 
  							<p>Artista: <input type="text" name="artista"></p>
  							<p>Canción: <input type="text" name="cancion"></p>
  							<p>
    							<input type="submit" value="Enviar">
    							<input type="reset" value="Borrar">
  							</p>
						</form>
              <?php
           
            $url="https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track=".$args['cancion'].".&q_artist=".$args['artista']."&apikey=f37bb1f59ec257857a2086c7bdb4a1ea";
          
            $result = file_get_contents($url);
              
            $datos = json_decode($result,true);

            $letra = $datos['message']['body']['lyrics']['lyrics_body']
           // return $datos['message']['body']['lyrics']['lyrics_body'];
            return $letra;           
	}*/
 ?>