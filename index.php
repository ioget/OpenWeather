


<?php 
$key_api = "88e95bf8b08f85b284d7b41b11570256";

require "header.php";



/* --------------------- logique geologalisation ----------------------*/

/*
$ip = $_SERVER['REMOTE_ADDR'];
$query = @unserialize(file_get_contents("http://ip-api.com/php/".$ip));

if( $query["status"] == "success")
{
      $ville = $query["city"];
      $country = $query["country"];
      $long = "__val__";
      $lat = "__val__";
}else{

     $ville = "yaounde";
     $country = "cm";
     $long = "__val__";
      $lat = "__val__";
}
*/

$list = file_get_contents("CountryCodes.json");
   $file = json_decode($list);

   $country_name = "cameroon";
if(isset($_POST["ville"]))
{
      $pays = htmlentities($_POST["pays"]);
      $city = $_POST["ville"];
      for ($i=0; $i < 241; $i++)
       { 
           if( $file[$i]->name == $pays)
           {
                 $country = strtolower($file[$i]->code);
                 $country_name = strtolower($file[$i]->name);
                 break;
           }
       }
}else{
      $country = "cm";
      $city = "douala";
}




/**--------- connexion a APP et traitement de donnees------------------ */

$url = "https://api.openweathermap.org/data/2.5/weather?q=".$city.",".$country."&appid=".$key_api."&units=metric";

$curl = curl_init($url);
curl_setopt($curl,CURLOPT_CAINFO, __DIR__.DIRECTORY_SEPARATOR."Builtin Object Token_USERTrust RSA Certification Authority.cer");
curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curl,CURLOPT_TIMEOUT,5);
$data = curl_exec($curl);

$url_illus = "img/illus/"  .  "03n@2x.png";


if( $data == false)
{
    /*
      while($data == false)
      {
            $curl = curl_init($url);
            curl_setopt($curl,CURLOPT_CAINFO, __DIR__.DIRECTORY_SEPARATOR."Builtin Object Token_USERTrust RSA Certification Authority.cer");
            curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl,CURLOPT_TIMEOUT,5);
            $data = curl_exec($curl);
      }
*/

// attention Ros
 $error = curl_error($curl);
     
}else{
      if (curl_getinfo($curl,CURLINFO_HTTP_CODE) === 200)
      {
            $data = json_decode($data,true);

            // ----localisation -----
            $longitude = $data["coord"]["lon"];
            $latitude = $data["coord"]["lat"];
            $pays = $data["sys"]["country"];
            $ville = $data["sys"]["name"];
            //-----info meteo-------
            $temperature = $data["main"]["temp"];
            $description = $data["weather"]["0"]["description"];
            $main = $data["weather"]["0"]["main"];
            $temp_min = $data["main"]["temp_min"] - 1.25;
            $pression = $data["main"]["pressure"];
            $temp_max = $data["main"]["temp_max"] + 1.62;
            $humidite = $data["main"]["humidity"];
            $speed = $data["wind"]["speed"];
            $tab_illus =  array( 
         
                  "clear sky" => "Screenshot from 2022-07-04 19-29-41.png",
                  "few clouds" => "Screenshot from 2022-07-04 19-27-35.png",
                  "scattered clouds" => "Screenshot from 2022-07-04 19-29-27.png",
                  "broken clouds"  => "Screenshot from 2022-07-04 19-28-25.png",
                  "shower rain"  =>  "Screenshot from 2022-07-04 19-27-18.png",
                  "rain"  => "Screenshot from 2022-07-04 19-26-31.png",
                  "thunderstorm" => "Screenshot from 2022-07-04 19-28-07.png",
                  "snow" => "Screenshot from 2022-07-04 19-25-59.png",
                   "mist" => "50d@2x.png",
                   "light rain"  => "10d@2x.png",
                   "overcast clouds" => "etipi.png",
                   "broken clouds" => "broken_clouds.png",
                   "moderate rain"  => "10d@2x.png"
         ) ;

         $tab_main_illus = array (
                       	"Thunderstorm" => "11n@2x.png",
                             "Drizzle" => "09d@2x.png",
                             "Snow" => "13n@2x.png",
                             "Smoke" => "150d@2x.png",
                             "Haze" => "50d@2x.png",
                             "Dust" =>"50d@2x.png",
                             "Fog" => "50d@2x.png",
                             "Sand" => "50d@2x.png",
                             "Ash" => "50d@2x.png",
                             "Squall" => "50d@2x.png",
                             "Tornado" => "50d@2x.png",
                             "Clear" => "01d@2x.png",
                             "Clouds" => "02d@2x.png"

         );
         
         $view = false;
         foreach( $tab_illus as $cle => $elt )
         {
               if($cle == $description)
               {
                     $url_illus  =  "img/illus/" .$elt;
                     $view = true;
               }
         }  
         
         if($view === true )
         {
            foreach( $tab_main_illus as $cle => $elt )
            {
                  if($cle == $description)
                  {
                        $url_illus  =  "img/illus/" .$elt;
                  }
            }  
         }
          
      }
}





?>


<link rel="stylesheet" href="style/index.css">
<link rel="stylesheet" media="screen and (max-width: 500px)" href="style/mobile_index.css" />
<script src="scriptJs/index.js" async></script>

<section class="all">

<div class="image_zone">

   <div class="back"> 
         <
   </div>


   <div class="image_text">
        La chaine Météo  est une platforme  <br/>ou vous pouvez avoir les informations   sur la météo <br/>courante de votre region et partout ailleurs  dans le monde  

   </div>


   <div class="after">
        >
   </div>
</div>


<section class="conteneur">
        
  
          <div class="B">
                   <article class="article">
                        <div class="illustration">

                              <div class="div_weather">
                            
                                       <img src=<?php echo $url_illus; ?> class="image_weather" alt="climat"/>
                                      <!-- <legend> Illusration  </legend>   -->
                              </div>
                              
                              <div class="div_nature">
                                       <img src="img/lightning-1056419_1920.jpg" class="image_nature" alt="">
                              </div>
                              <legend> Ciel  </legend>
                        </div>

                        <div class="information">
                               
                             <?php 
                                        if(isset($error))
                                        {
                                             echo "<div class='error'>". " Le serveur est surcharge veuillez actualiser la page apres 1(min) minute  Merci "." </div>";
                                        }else{

                                        

                             ?>

                        <div class="localisation">
                                     <table>
                                          <tr>
                                               <td> Ville : </td>
                                               <td> <?php  echo $city ?></td>
                                          </tr>
                                          <tr>
                                              <td> Pays : </td>
                                              <td> <?php  echo    $country_name ?> </td>
                                          </tr>
                                     </table>

                                     <table>
                                           <tr> 
                                                  <td> Longitude : </td>
                                                  <td> <?php  echo  $longitude;  ?> </td>
                                           </tr>
                                           <tr>
                                                   <td> Latitude : </td>
                                                   <td> <?php  echo $latitude; ?> </td>
                                           </tr>
                                     </table>
                                    
                                </div>  
                                 
                                <?php  } ?>

                                <div class="info">
                                    <h3>La Météo du    <?php echo strftime('%A %d %B %Y a %H' ); ?>:Heur </h3>  
                                    <div class="meteo">
                                          <label > Temperature (courante) : <?php echo $temperature ?>  ºC</label>  <br/>
                                          <label > Description : <?php echo $description ?></label> <br/>
                                          <label > Pression : <?php echo $pression ?> Pa</label> <br/>
                                          <label > Humidite : <?php echo $humidite ?> g/m3 </label> <br/>
                                          <label > Vent : <?php echo $speed ?> Km/h </label> <br/>
                                          <label >  Intervale de temperature : [<?php echo $temp_min ; ?> ºC ; <?php echo $temp_max; ?> ºC] </label> <br/>
                                     </div>
                                </div>
                        </div>
                  </article>


             
                  <article class="article2">
                       
                         <div class="formulaire">
                              <h2> Recherche une Region  </h2>
                                    <form action="index.php" method="POST"> 
                                          <table>
                                                            
                                                                  <tr class="no_name"> 
                                                                        <td>  
                                                                              <label for="ville"> Ville : 
                                                                                    <input type="text" id="ville" name="ville" required/>  
                                                                                    </label> 
                                                                        </td> 
                                                                  </tr>


                                                                  <tr>
                                                                        <td> 
                                                                                    <label for="pays"> Pays :  </label>
                                                                                    <select name="pays" id="pays" class="select" required> 
                                                                                                <?php 
                                                                                                
                                                                                                      
                                                                                                      for ($i=0; $i < 241 ; $i++) 
                                                                                                      { 
                                                                                                            echo "<option value=".$file[$i]->name.">".$file[$i]->name."</option> <br/>" ;
                                                                                                      }
                                                                                                ?>
                                                                                    </select> 
                                                                        </td>
                                                                        
                                                                  </tr>
                                          
                                                      <tr class="send">
                                                      
                                                           <td>  <input type="submit" value="Recherche" class="submit" > </td>
                                                      </tr>
                                          </table>
                                    </form>
                              </div>
                  </article>
          </div>
          
                                                                                         
      
</section>




















<?php
/*    Exemple call API 
http://api.openweathermap.org/geo/1.0/direct?q=London&limit=5&appid=88e95bf8b08f85b284d7b41b11570256


16 jours

api.openweathermap.org/data/2.5/forecast/daily?lat=35&lon=139&cnt=10&appid=88e95bf8b08f85b284d7b41b11570256



https://pro.openweathermap.org/data/2.5/forecast/climate?lat=35&lon=139&appid=88e95bf8b08f85b284d7b41b11570256&units=metric


https://api.openweathermap.org/data/2.5/weather?lat=35&lon=139&appid=88e95bf8b08f85b284d7b41b11570256&lang=fr&units=metric

 ----parametre valeur 

 lang = {fr}
 units = metric
 appid = {valeur_id}
 lon = {longitude}
 lat = {latitude}

  q = {ville}{pays_code}

*/
?>

    
</section>

<?php
  require "footer.php";
?>