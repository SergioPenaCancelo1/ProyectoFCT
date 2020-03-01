<?php










    add_shortcode('lyrics','obtener_letra_canciones');
	

	function obtener_letra_canciones($args,$content){
           
           /*$formulario="<form action="" method="get">
  							<label>Dinos tu artista favorito</label> 
  							<p>Artista: <input type="text" name="artista"></p>
  							<p>Canción: <input type="text" name="cancion"></p>
  							<p>
    							<input type="submit" value="Enviar">
    							<input type="reset" value="Borrar">
  							</p>
						</form>";*/
              

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
              <?php*/
           
            $url="https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track=".$args['cancion'].".&q_artist=".$args['artista']."&apikey=f37bb1f59ec257857a2086c7bdb4a1ea";
          
            $result = file_get_contents($url);
              
            $datos = json_decode($result,true);

            $letra = $datos['message']['body']['lyrics']['lyrics_body']
           // return $datos['message']['body']['lyrics']['lyrics_body'];
            return $letra;           
	}





	/*add_shortcode( 'add_fields', 'input_fields' ); 
			function input_fields( $atts ) {
    			if ( isset( $_POST['gg'] ) ) {
        		$post = array(
            'post_content' => $_POST['content'], 
            'post_title'   => $_POST['title']
       			 );
        	$id = wp_insert_post( $post, $wp_error );
    		}
    		?> 
    		<form method = "post">
        		<input type="text" name="title">
       			 <input type="text" name="content">
        		<input type="submit" name="gg">
   			 </form>
    	<?php*/
}




?>