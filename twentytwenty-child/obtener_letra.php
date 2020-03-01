<?php










    
    
	

	


add_shortcode('form','crear_formulario');
function crear_formulario($args){
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
add_shortcode('lyrics','start');

function start($args,$content) 
{
  $artista= $_POST['artista'];
  $cancion= $_POST['cancion'];


  $jsonLetras = get_song_data($artista, $cancion); //devuelve json

  $letra = $jsonLetras['message']['body']['lyrics']['lyrics_body'];

  //$jsonWatson = call_to_watson($letra);

  //get_watson_request_from_text($letra);
  
  $letra_ordenada = str_replace("\n", "</br>", $letra);

  $output = "<div><p><strong>".$cancion."-".$artista."</strong></p><p>".$letra_ordenada."</p></div>";

//cosas con el json de watson


return $output;

}


function get_watson_request_from_text($text) {

  // Watson information and structures to make a request to Watson API
  $content_contenttype = "text/plain";
  $content_language = "es";
  $contentItemsArray = array();

  // Store the requested information
  $contentData = array(
      "content" => $text,
      "contenttype" => $content_contenttype,
      "created" => (new DateTime('now'))->getTimestamp(),
      "id" => 1,
      "language" => $content_language
   );
  $contentItemsArray[] = $contentData;

  $contentArray = array('contentItems' => $contentItemsArray);
  $watson_request_json = array_to_json($contentArray);


  return $watson_request_json;
}


function call_to_watson($watson_request) {

  // IAM authentication, api url, arguments and headers variables definitions
  $ibm_api_key = 'Pjh6MVRYQbPk3jm62n3tmXoY0ykoELjFgSl2DgIzd57I';
  $ibm_userpwd = "apikey:" . $ibm_api_key;
  $ibm_api_url = 'https://api.eu-gb.personality-insights.watson.cloud.ibm.com';
  $ibm_method = "v3/profile";
  $ibm_url = $ibm_api_url . '/' . $ibm_method;
  $post_args = array(
    'version' => '2017-10-13'
  );
  //   'consumption_preferences' => true,
  //   'raw_scores' => true
  $ibm_url = $ibm_url . '?' . http_build_query($post_args, '', '&amp;');
  $headers = array('Accept: application/json','Content-Type: application/json;charset=utf-8', "Content-Language: es", "Accept-Language: es");

  // Open curl handle
  $curl = curl_init(); 

  // Set curl operators
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_USERPWD, $ibm_userpwd);
  curl_setopt($curl, CURLOPT_URL, $ibm_url); 
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_POSTFIELDS, get_watson_request_from_text($watson_request));
  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Do not output directly, use a variable

  // Request
  $result = curl_exec($curl); //store the content in variable

  // Get request information
  $info = curl_getinfo($curl);
  $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  if (curl_error($curl)) {
      $error_msg = curl_error($curl);
  }

  // Close curl handle
  curl_close($curl);

  // Manage errors
  if (isset($error_msg)) {
    echo '<p>Unnable to request data to Watson Personality Insights. A curl error has ocurred.</p>';
    exit;
  } 

  if($httpStatus != 200){
    echo '</br><p>Unnable to request data to Watson Personality Insights. A Watson API error has ocurred:</p>';
      
      echo '<ul>';
      echo '<li>' . 'Description: ' . $info['description'] . '</li>';
      echo '<li>' . 'Error code: ' . $info['code'] . '</li>';
      echo '<li>' . 'httpStatus: ' . $httpStatus . '</li>';
      echo '</ul>';

      echo '</br>';

      exit;
  }
  //var_dump($result);

  return $result;
}

function array_to_json($array) {

  $json = json_encode($array, JSON_UNESCAPED_UNICODE);

  switch (json_last_error()) {
      case JSON_ERROR_NONE: 
      // Ignore
      break;
      case JSON_ERROR_DEPTH:
          echo ' - JSON_ERROR_DEPTH';
      break;
      case JSON_ERROR_STATE_MISMATCH:
          echo ' - JSON_ERROR_STATE_MISMATCH';
      break;
      case JSON_ERROR_CTRL_CHAR:
          echo ' -  JSON_ERROR_CTRL_CHAR';
      break;
      case JSON_ERROR_SYNTAX:
          echo "\r\n\r\n - SYNTAX ERROR \r\n\r\n";
      break;
      case JSON_ERROR_UTF8:
          echo ' - JSON_ERROR_UTF8';
      break;
      default:
          echo ' - Unknown error';
      break;
  }
  //var_dump($json);

  return $json;
}


function get_song_data($artista, $cancion){                  

  $artista_noespacios = str_replace(" ", "%20", $artista);

  $cancion_noespacios = str_replace(" ", "%20", $cancion);


  $url="https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track=".$cancion_noespacios.".&q_artist=".$artista_noespacios."&apikey=f37bb1f59ec257857a2086c7bdb4a1ea";

  $result = file_get_contents($url);

  $datos = json_decode($result,true);

  return $datos;
}

/*function obtener_letra_canciones($args,$content){
           
           
           
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
  }*/




?>