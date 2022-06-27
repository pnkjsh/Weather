<?php
include_once('./lib/HtmlDom.php');

class WeatherService {
    
public function getWeatherByCity($city){
    if($city){
        $url = 'https://www.google.com/search?q=weather+'.strtolower($city); 

	$html = file_get_html($url);
    $div = $html->find('div[class="kvKEAb"]', 0);
    
    $location = $html->find('span[class="BNeawe tAd8D AP7Wnd"]', 0)->plaintext; 
    $today_temp = $div->find('.iBp4i', 0)->plaintext;
    $_today_update = $div->find('.tAd8D', 0)->plaintext;
    
    preg_match_all('!\d+!', $today_temp, $live_temp); //iconv("ISO-8859-1","UTF-8", $today_temp);
    $today_temp = (int)$live_temp[0][0];
    $_list = explode(' ', $_today_update);
    $day = $_list[0];
    $localTime = $_list[1];
    $status = explode(' ', $_today_update, 3);
    }
    $weather_status = strtolower($status[2]);
    switch ($weather_status) {
    case "haze":
        $weather_img = "fog.png";
        break;
	case "party":
        $weather_img = "partly_cloudy.png";
        break;
    case "mostly cloudy":
        $weather_img = "partly_cloudy.png";
        break;
    case "rain":
        $weather_img = "rain.png";
        break;
    case "scattered showers":
        $weather_img = "rain_s_cloudy.png";
        break;
    case "scattered thunderstorms":
        $weather_img = "rain_s_cloudy.png";
        break;
    case "showers":
        $weather_img = "rain_light.png";
        break;
    case "Light thunderstorms and rain":
        $weather_img = "rain_light.png";
        break;
    case "light rain showers":
        $weather_img = "rain_light.png";
        break;
    case "clear":
            $weather_img = "sunny.png";
        break;
    case "sunny":
        $weather_img = "sunny.png";
        break;
    case "thunderstorms":
        $weather_img = "thunderstorms.png";
        break;
    case "cloudy":
        $weather_img = "thunderstorms.png";
        break;
    default:
        $weather_img = ".png";
    }

    $weather_img_url = "https://ssl.gstatic.com/onebox/weather/64/".$weather_img;

        if($today_temp){
			$weather_arr = array("location"=>$location, "temp_c"=>$today_temp, "week_day"=>$day, "local_time"=>$localTime, "condition"=>$status[2], "weather_img"=>$weather_img_url);	
			}
			else{
			$weather_arr = array("message"=>"Error! No data found");
			}

            $html->clear();
            unset($html);	

		return $weather_arr;
	}
}
?>
