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
//add_shortcode('grafic','crear_grafico');
function crear_grafico($apertura,$responsabilidad,$extraversion,$simpatia,$rango_emocional,$necesidad_retos,$necesidad_cercania,$conservacion,$apertura_cambio){

           

            /*$grafico='<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {"packages":["bar"]});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ["Opening Move", "Percentage"],
          ["King,s pawn (e4)", 44],
          ["Queen,s pawn (d4)", 31],
          ["Knight to King 3 (Nf3)", 12],
          ["Queen,s bishop pawn (c4)", 10],
          ["Other", 3]
        ]);

        var options = {
          title: "Chess opening moves",
          width: 900,
          legend: { position: "none" },
          chart: { title: "Chess opening moves",
                   subtitle: "popularity by percentage" },
          bars: "horizontal", // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: "top", label: "Percentage"} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById("top_x_div2"));
        chart.draw(data, options);
      };
    </script>';*/
            



            /*$apertura=77.797118890578;
            $responsabilidad=8.7076127044805;
            $extraversion=46.6688028547;
            $simpatia=1.3351174613923;
            $rango_emocional=71.320157325545;
            $necesidad_retos=80.466331025777;
            $necesidad_cercania=23.79940876259;
            $conservacion=6.9091169639653;
            $apertura_cambios=94.687049951594;*/

            //$apertura,$responsabilidad,$extraversion,$simpatia,$rango_emocional,$necesidad_retos,$necesidad_cercania,$conservacion,$apertura_cambios

            //[grafic][/grafic]


            $grafico='<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {"packages":["bar"]});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ["Datos emocionales", "Porcentage"],
          ["Apertura", '.$apertura.'],
          ["Responsabilidad",'.$responsabilidad.'],
          ["Extraversion", '.$extraversion.'],
          ["Simpatia", '.$simpatia.'],
          ["Rango emocional", '.$rango_emocional.'],
          ["Necesidad retos", '.$necesidad_retos.'],
          ["Necesidad cercania", '.$necesidad_cercania.'],
          ["Conservacion", '.$conservacion.'],
          ["Apertura a cambios", '.$apertura_cambio.']
        ]);

        var options = {
          title: "Chess opening moves",
          width: 900,
          legend: { position: "none" },
          chart: { title: "Chess opening moves",
                   subtitle: "popularity by percentage" },
          bars: "horizontal", // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: "top", label: "Percentage"} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById("top_x_div2"));
        chart.draw(data, options);
      };
    </script>';

            return $grafico;
           

            

  }
add_shortcode('lyrics','print_lyrics');
function print_lyrics($args,$content) 
{
  /*$artista= $_POST['artista'];
  $cancion= $_POST['cancion'];


  $jsonLetras = get_song_data($artista, $cancion); //devuelve json

  $letra = $jsonLetras['message']['body']['lyrics']['lyrics_body'];

  

  if (isset($letra)) {
    $jsonWatson = call_to_watson($letra);//llamada a watson 
}

  */

  //get_watson_request_from_text($letra);
  
  $letra_simple=get_song_data();
  
  $letra_ordenada = str_replace("\n", "</br>", $letra_simple);

  //$output = "<div><p><strong>".$cancion."-".$artista."</strong></p><p>".$letra_ordenada."</p></div>";
  $output = "<div><p>".$letra_ordenada."</p></div>";

//cosas con el json de watson


return $output;

}



add_shortcode('watson','print_watson');
function print_watson($args,$content) {

    $lyrics_text=get_song_data();


    /*if(isset($_POST['Submit'])){

         if (isset($lyrics_text)) {

              $jsonWatson = call_to_watson($letra);//llamada a watson 
          }
    }*/
    
      if (isset($lyrics_text)) {

              $jsonWatson = call_to_watson($lyrics_text);//llamada a watson 


              $datos_watson = json_decode($jsonWatson,true);

              
              $dato1 = $datos_watson['personality'][0]['percentile'] * 100;
              $dato2 = $datos_watson['personality'][1]['percentile'] * 100;
              $dato3 = $datos_watson['personality'][2]['percentile'] * 100;
              $dato4 = $datos_watson['personality'][3]['percentile'] * 100;
              $dato5 = $datos_watson['personality'][4]['percentile'] * 100;


              $dato6 = $datos_watson['needs'][0]['percentile'] * 100;
              $dato7 = $datos_watson['needs'][1]['percentile'] * 100;
              $dato8 = $datos_watson['values'][0]['percentile'] * 100;
              $dato9 = $datos_watson['values'][1]['percentile'] * 100;


              $prueba1 = "Openness : ".$dato1;
              $prueba2 = "Conscientiousness : ".$dato2;
              $prueba3 = "Extraversion : ".$dato3;
              $prueba4 = "Agreeableness : ".$dato4;
              $prueba5 = "Emotional range : ".$dato5;


              $prueba6 = "Need challenge : ".$dato6;
              $prueba7 = "Need closeness : ".$dato7;
              $prueba8 = "Conservation : ".$dato8;
              $prueba9 = "Openness to change : ".$dato9;
             



              //$salida = "<div>".$prueba1."</br>".$prueba2."</br>".$prueba3."</br>".$prueba4."</br>".$prueba5."</br>".$prueba6."</br>".$prueba7."</br>".$prueba8."</br>".$prueba9."</div>";
              $grafico_datos=crear_grafico($dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7,$dato8,$dato9);

              //return $salida;

              return $grafico_datos;





            /*$apertura=$dato1;
            $responsabilidad=$dato2;
            $extraversion=$dato3;
            $simpatia=$dato4;
            $rango_emocional=$dato5;
            $necesidad_retos=$dato6;
            $necesidad_cercania=$dato7;
            $conservacion=$dato8;
            $apertura_cambios=$dato9;*/

            //$apertura,$responsabilidad,$extraversion,$simpatia,$rango_emocional,$necesidad_retos,$necesidad_cercania,$conservacion,$apertura_cambios

            //[grafic][/grafic]


            /*$grafico='<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load("current", {"packages":["bar"]});
      google.charts.setOnLoadCallback(drawStuff);

      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ["Datos emocionales", "Porcentage"],
          ["Apertura", '.$apertura.'],
          ["Responsabilidad",'.$responsabilidad.'],
          ["Extraversion", '.$extraversion.'],
          ["Simpatia", '.$simpatia.'],
          ["Rango emocional", '.$rango_emocional.'],
          ["Necesidad retos", '.$necesidad_retos.'],
          ["Necesidad cercania", '.$necesidad_cercania.'],
          ["Conservacion", '.$conservacion.'],
          ["Apertura a cambios", '.$apertura_cambios.']
        ]);

        var options = {
          title: "Chess opening moves",
          width: 900,
          legend: { position: "none" },
          chart: { title: "Chess opening moves",
                   subtitle: "popularity by percentage" },
          bars: "horizontal", // Required for Material Bar Charts.
          axes: {
            x: {
              0: { side: "top", label: "Percentage"} // Top x-axis.
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById("top_x_div2"));
        chart.draw(data, options);
      };
    </script>';

            return $grafico;*/

              
          }

      return"";
    
}

function get_watson_request_from_text($text) {

  // Watson information and structures to make a request to Watson API
  $content_contenttype = "text/plain";
  $content_language = "en";
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
  $headers = array('Accept: application/json','Content-Type: application/json;charset=utf-8', "Content-Language: en", "Accept-Language: en");

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


function get_song_data(){  

  $artista= $_POST['artista'];
  $cancion= $_POST['cancion'];                

  $artista_noespacios = str_replace(" ", "%20", $artista);

  $cancion_noespacios = str_replace(" ", "%20", $cancion);


  $url="https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track=".$cancion_noespacios.".&q_artist=".$artista_noespacios."&apikey=f37bb1f59ec257857a2086c7bdb4a1ea";

  $result = file_get_contents($url);

  $datos = json_decode($result,true);


  $letra = $datos['message']['body']['lyrics']['lyrics_body'];

  return $letra;
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