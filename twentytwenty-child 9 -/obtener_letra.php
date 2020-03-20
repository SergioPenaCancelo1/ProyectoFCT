<?php





add_shortcode('form','crear_formulario');//Crea un shortcode a partir de crear_formulario

//Funcion que imprime un formulario html 
function crear_formulario($args){  


//dentro de una variable metemos el codigo html entre comillas y creo un formulario para insertar la cancion y el artista en la aplicacion
           $formulario='<form action="" method="post">
                <label><b>Dinos tu artista favorito</b></label> 
                <p>Artista: <input type="text" name="artista"></p>
                <p>Canción: <input type="text" name="cancion"></p>
                <p>
                  <input type="submit" value="Buscar">
                  <input type="reset" value="Borrar">
                </p>
            </form>';

          
            return $formulario;

            

  }
//funcion que crea el grafico a partir de los datos que recojo de watson
function crear_grafico($apertura,$responsabilidad,$extraversion,$simpatia,$rango_emocional,$necesidad_retos,$necesidad_cercania,$conservacion,$apertura_cambio){

           


         //dentro de una variable creamos el grafico  a partir de codigo javascript entre comillas  

        //Primero creamos el contenedor por html donde va pintarse el grafico

        //Dentro del script  cargamos los paquetes de stylos de google charts
        //Recojo en una variable el boton para pintar el grafico

        //Recojo el evento de click del boton y creo una funcion en la cual dentro envia los parametros se devuelven en la funcion de drawStuff() a  google charts para su muestreo

        //  la funcion de drawStuff() hace las siguientes cosas:
        // -crea una variable array siguiendo las directrices de google para insertar dentro los datos que se muestran  en el grafico 
        // - crea una variable para los parametros necesarios a la otra de crear el grafico como el ancho del grafico la posicion de las barras etc...
        // -seleciona el conetedor antes creado  en una variable y con  esa variable usamos el metodo draw con los datos y las opciones antes mercionadas para pintar el grafico
          $grafico='
                    <div id="top_x_div" style="width: 900px; height: 500px;"></div>
                    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
                    <script type="text/javascript">


      google.charts.load("current", {"packages":["bar"]});
      
      const boton = document.querySelector("#miBoton");



      boton.addEventListener("click", function(evento){
        
      google.charts.setOnLoadCallback(drawStuff);
     
      });



      function drawStuff() {
        var data = new google.visualization.arrayToDataTable([
          ["Datos emocionales", "Porcentaje"],
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
          title: "Datos del escaner de Watson",
          width: 900,
          legend: { position: "none" },
          chart: { title: "Datos del escaner de Watson",
                   subtitle: "Rango por percentage" },
          bars: "horizontal", 
          axes: {
            x: {
              0: { side: "top", label: "Porcentaje"} 
            }
          },
          bar: { groupWidth: "90%" }
        };

        var chart = new google.charts.Bar(document.getElementById("top_x_div"));
        chart.draw(data, options);
      };


</script>';

            return $grafico;
            

  }
add_shortcode('lyrics','print_lyrics');
function print_lyrics($args,$content) 
{
  
  //Llamamos a la funcion get_song_data() y cargamos la letra que nos devuelve en una variable
  $letra_simple=get_song_data();


  //cogemos la letra que ya tenemos y le sustituimos los "\n" que tiene intercalados por saltos de linea html para ordenar de manera correcta la letra de la canción
  $letra_ordenada = str_replace("\n", "</br>", $letra_simple);

  //imprimimos la letra ya ordenada y con los saltos de linea dentro de un parrafo en un contenedor
  $output = "<div><p>".$letra_ordenada."</p></div>";




return $output;

}



add_shortcode('watson','print_watson');
function print_watson($args,$content) {
    
    //llamamos a la funcion get_song_data() para obtener la letra de la cancion 
    $lyrics_text=get_song_data();
      
      //comprobamos que lo que nos devuelva la funcion antes dicha no este vacio para poder empezar a  trabajar con watson
      if (isset($lyrics_text)) {

              //llamamos a la funcion de call_to_watson() mandandole la letra de la cancion para obtener el json hecho por watson

              $jsonWatson = call_to_watson($lyrics_text);

              //decodificamos el json obtenido de watson para trabajar con el 
              $datos_watson = json_decode($jsonWatson,true);

              //parseamos el array para obtenr los datos co los que quiero trabajar 
              $dato1 = $datos_watson['personality'][0]['percentile'] * 100;
              $dato2 = $datos_watson['personality'][1]['percentile'] * 100;
              $dato3 = $datos_watson['personality'][2]['percentile'] * 100;
              $dato4 = $datos_watson['personality'][3]['percentile'] * 100;
              $dato5 = $datos_watson['personality'][4]['percentile'] * 100;


              $dato6 = $datos_watson['needs'][0]['percentile'] * 100;
              $dato7 = $datos_watson['needs'][1]['percentile'] * 100;
              $dato8 = $datos_watson['values'][0]['percentile'] * 100;
              $dato9 = $datos_watson['values'][1]['percentile'] * 100;


              //le pasamos los datos obtenidos a la funcion crear_grafico para pintarlo
              $grafico_datos=crear_grafico($dato1,$dato2,$dato3,$dato4,$dato5,$dato6,$dato7,$dato8,$dato9);

              
              //devolvemos el grafico obtenido por pantalla 
              return $grafico_datos;
    
          }
      //si la letra no contiene nada no mostramos nada
      return"";
    
}

function get_watson_request_from_text($text) {

  //Información y estructuras de Watson para realizar una solicitud a la API de Watson
  $content_contenttype = "text/plain";
  $content_language = "en";
  $contentItemsArray = array();

  // Almacenar la información solicitada en un array pasandole dentro la letra 
  $contentData = array(
      "content" => $text,
      "contenttype" => $content_contenttype,
      "created" => (new DateTime('now'))->getTimestamp(),
      "id" => 1,
      "language" => $content_language
   );
  $contentItemsArray[] = $contentData;//igualamos un array con ¡los valores que hemos creado anteriormente

  $contentArray = array('contentItems' => $contentItemsArray);//metemos el array dentro de otro 
  $watson_request_json = array_to_json($contentArray);//combertimos el array en json enviandolo  a la funcion array_to_json()


  return $watson_request_json;
}


function call_to_watson($watson_request) {

  
  // Establecemos los parametros encesarios para la llamada a watson como la autenticación IAM, URL de API, argumentos y definiciones de variables de encabezados
  $ibm_api_key = 'Pjh6MVRYQbPk3jm62n3tmXoY0ykoELjFgSl2DgIzd57I';
  $ibm_userpwd = "apikey:" . $ibm_api_key;
  $ibm_api_url = 'https://api.eu-gb.personality-insights.watson.cloud.ibm.com';
  $ibm_method = "v3/profile";
  $ibm_url = $ibm_api_url . '/' . $ibm_method;
  $post_args = array(
    'version' => '2017-10-13'
  );

  $ibm_url = $ibm_url . '?' . http_build_query($post_args, '', '&amp;');//Generamos una cadena de consulta codificada estilo URL

  $headers = array('Accept: application/json','Content-Type: application/json;charset=utf-8', "Content-Language: en", "Accept-Language: en");//establecemos los encabezadosn de watson en un array

  // Iniciamos la llamada de curl
  $curl = curl_init(); 

  //Establecemos los operadores del curl
  curl_setopt($curl, CURLOPT_POST, true);
  curl_setopt($curl, CURLOPT_USERPWD, $ibm_userpwd);
  curl_setopt($curl, CURLOPT_URL, $ibm_url); 
  curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
  curl_setopt($curl, CURLOPT_POSTFIELDS, get_watson_request_from_text($watson_request));//en los datos que enviamos primero llamamamos a la funcion get_watson_request_from_text() pasandole el texto de la cancion
                                                                                        //porque el contenido a enviar tiene que estar en formato json con una distribucion espefica

  curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // No enviamos directamente,usamos una variable

  
  $result = curl_exec($curl); //Almacenamos el contenido de la repsuesta json en una variable

  // Obtenemos informacin de la resuesta
  $info = curl_getinfo($curl);
  $httpStatus = curl_getinfo($curl, CURLINFO_HTTP_CODE);//obtenemos la repsuesta htttp de la llamada
  //comprobamos si hay algun error en la llamada del curl
  if (curl_error($curl)) {
      $error_msg = curl_error($curl);//si hay errroes los cargamos en una variable
  }

  // Cerramos la llamada de curl
  curl_close($curl);

  // Comprobamos si la variable donde cargamos los errores del curl esta vacia o no y si no lo esta emitimos un mensaje de error
  if (isset($error_msg)) {
    echo '<p>Unnable to request data to Watson Personality Insights. A curl error has ocurred.</p>';
    exit;
  } 
 //comprobamos si la respuesta http es diferente de 200 y si es asi imprimimos la respuesta del error en detalle
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
  

  return $result;
}

function array_to_json($array) {

  //Codificamos el array en json 

  $json = json_encode($array, JSON_UNESCAPED_UNICODE);
  //controlamos si hay errores en la creacion del json y si es asi los mostramos en pantalla
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
  
//devolvemos el json creado
  return $json;
}


function get_song_data(){  

  //recogemos los datos insertados en los campos del formulario despues de darle al boton de buscar

  $artista= $_POST['artista'];
  $cancion= $_POST['cancion'];                


  // controlamos que los espacios que puedan existir en el nombre del artista o el titulo de la canción sean sustituidos por "%20" 
  // para que la api a la que le vamos a enviar los parametros pueda trabajar con ellos
  $artista_noespacios = str_replace(" ", "%20", $artista);

  $cancion_noespacios = str_replace(" ", "%20", $cancion);

  //escribimos la url de llada a la api concatenando el artista y la cancion asi como la api key
  $url="https://api.musixmatch.com/ws/1.1/matcher.lyrics.get?format=json&callback=callback&q_track=".$cancion_noespacios.".&q_artist=".$artista_noespacios."&apikey=f37bb1f59ec257857a2086c7bdb4a1ea";

  //hacemos la llamada a la api con la url antes compuesta y obtenemos un json de respuesta
  $result = file_get_contents($url);
  //decodicifcamos el json que nos da como resuesta para poder trabajar bien con su datos
  $datos = json_decode($result,true);

  //parseamos el array del ya decoficado json hasta poder obtener los datos que necesitamos,es decir la letra de la cancion
  $letra = $datos['message']['body']['lyrics']['lyrics_body'];

 //devolvemos la letra ya decodificada
  return $letra;
}






?>