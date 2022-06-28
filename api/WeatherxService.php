<?php
require './lib/HtmlDom.php';

/**
 * WeatherxService class provides the entire weather data set. *
 * @author Pankaj Saha (mr.pankajsaha[@]gmail.com)
 * @license MIT
 */
class WeatherxService{
    
    /**
    * getWeatherByCity provides the entire weather data set
    * @param {string} cityName - name of the any valid city
    * @return {object} weatherx - entire weatherx data
    */
    public function getWeatherByCity($cityName){      
            if($cityName){                
                $country_city = $this->findCountryByCityName(strtolower($cityName)); //calling findCountryByCityName()       
            }            
            if(null == $country_city){
              return array("status"=> 400, "message"=>"No city found", "city_req"=>$cityName);
            }

            $_base = $this->findBase(); // calling findBase()
            $resource = base64_decode($_base).$country_city;
            $html= file_get_html($resource);

            $location = $html->find('h1[class="headline-banner__title"]', 0)->plaintext;
            

            /******* Today forecast ************/
            $section = $html->find('section[class="bk-focus"]', 0);
            $feels_maxmin_wind = explode(':', $section->find('p', 1)->plaintext);
            $feels_like_c = preg_replace('/[^0-9]/', '', $feels_maxmin_wind[1]); //feels like
            preg_match_all('!\d+!', $feels_maxmin_wind[2], $forecast_temp_arr);
            $wind_mph = preg_replace('/[^0-9]/', '', $feels_maxmin_wind[3]);  //wind
            $fc_temp_max_c = $forecast_temp_arr[0][0]; // forecast max
            $fc_temp_min_c = $forecast_temp_arr[0][1]; // forecast min
            $wind_direction = $section->find('p span', 1)->title; // wind direction
            if(null == $wind_direction){
               $wind_direction = "No wind";
            }
            else{
                $wind_direction = str_replace("°","-degree",$wind_direction);
            }

            $curr_dt = $section->find('div[class="bk-focus__info"] tr td', 1)->plaintext;
            $humidity = $section->find('div[class="bk-focus__info"] tr td', 5)->plaintext; // humidity
            $pressure = $section->find('div[class="bk-focus__info"] tr td', 4)->plaintext; // pressure
            $dew_point = $section->find('div[class="bk-focus__info"] tr td', 6)->plaintext; // dew point
            $visibility = $section->find('div[class="bk-focus__info"] tr td', 3)->plaintext;

            $weather_today = array(               
                "temp_now_c" => (int)str_replace("&nbsp;°C","", $section->find('div[class="h2"]', 0)->plaintext),
                "condition"=> $section->find('img[class="mtt"]', 0)->title,
                "img_src"=> basename($section->find('img[class="mtt"]', 0)->src),
                "feels_like_c"=> (int)$feels_like_c,                
                "temp_max_c"=>(int)$fc_temp_max_c,
                "temp_min_c"=>(int)$fc_temp_min_c,
                "wind_mph"=>(int)$wind_mph,
                "wind_dir"=> $wind_direction,
                "humidity"=>$humidity,
                "pressure"=>$pressure,
                "dew_point_c"=>(int)str_replace("&nbsp;°C","",$dew_point),
                "visibility"=>str_replace("&nbsp;"," ",$visibility)
            );
          

            /*** Next 5 hour data ******/
            $nexthours_data = $html->find('table[id="wt-5hr"]');                       
            $next_5hours = array();
            foreach($nexthours_data as $nexthours){                
              for($key=0; $key<=5; $key++){
                $nexthrs = array(
                    "time"=>$nexthours->find('tr[class="h2"] td', $key)->plaintext,
                    "condition"=>$nexthours->find('img', $key)->title,
                    "temp_c"=>(int)str_replace("&nbsp;°C", "", $nexthours->find('tr[class="h2 soft"] td', $key)->plaintext),
                    "img_src"=>basename($nexthours->find('img', $key)->src),
                );
                array_push($next_5hours, $nexthrs);  
              }           
            } 
            
            /*** Forecast for next 5 days ********/
            $upcoming_14days = $html->find('table[id="wt-14d"]', 0);
            $forecast_5days = array();
           for($i=1; $i<=5; $i++){
                $upcoming_data = $upcoming_14days->find('td[class="wa"]', $i);
                $temp_max_min = str_replace("&nbsp;°C", "", $upcoming_data->find('p', 0)->plaintext);
                $temp_max_min_arr = explode("/", $temp_max_min);
                $upcoming_5days = array(
                    "day_dt"=> (int)$upcoming_data->find('div[class="wt-dn"]', 0)->plaintext,
                    "condition"=> str_replace("tstorms", "thunderstorms", $upcoming_data->find('img[class="mtt"]', 0)->getAttribute('title')),
                    "img_src"=>basename($upcoming_data->find('img[class="mtt"]', 0)->src),
                    "max_temp_c"=> (int)trim($temp_max_min_arr[0]),
                    "min_temp_c"=> (int)trim($temp_max_min_arr[1])                   
                );
                array_push($forecast_5days, $upcoming_5days);               
           }
            
           /******** data preparation ************/
           $weatherx = array(
                "location" => str_replace("Weather in ", "", $location),
                "local_dt_tm" => $curr_dt,
                "img_base_url" => "https://piuli.iblogger.org/api/images/",
                "forecast_today" => $weather_today,
                "forecast_5hrs" => $next_5hours,
                "forecast_5days" => $forecast_5days
           );

        // clear data
        $html->clear();
        unset($html);

        return $weatherx;
    }

    /**
    * findCountryByCityName provides the country name based on city
    * @param {string} city - name of the any valid city
    * @return {string} countryCityStr - entire country/city name
    */
    private function findCountryByCityName($city){
        $countryCityStr = null;
       
        $cityStr = strtolower(str_replace("%20", "-", trim($city))); //validate and filter city name
                     
        $obj_lines = file("./db/country_city_mst");
        foreach($obj_lines as $single_line){
		$obj_arr = explode("|", $single_line);
        $db_city = preg_replace("/\r|\n/", "", $obj_arr[1]);
			if($db_city == $cityStr){
             $country = $obj_arr[0];
			 $city = preg_replace("/\r|\n/", "", $obj_arr[1]);			 
             $countryCityStr = strtolower($country."/".$city);        
             break;
			}			
		}
        return $countryCityStr;
    }

    private function findBase(){
        return 'aHR0cHM6Ly93d3cudGltZWFuZGRhdGUuY29tL3dlYXRoZXIv';
    }
}
?>
