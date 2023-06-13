<?php
include_once ('./lib/HtmlDom.php');
include_once ('./WeatherUtil.php');

class WeatherService
{

    public function getWeatherByCity($city)
    {
        if ($city)
        {
            $url = base64_decode($this->getBaseUrl()) . strtolower($city);

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
        $weather_img_url = getWeatherImageURL($weather_status);

        if ($today_temp)
        {
            $weather_arr = array(
                "location" => $location,
                "temp_c" => $today_temp,
                "week_day" => $day,
                "local_time" => $localTime,
                "condition" => $status[2],
                "weather_img" => $weather_img_url
            );
        }
        else
        {
            $weather_arr = array(
                "message" => "Error! No data found"
            );
        }

        $html->clear();
        unset($html);

        return $weather_arr;
    }

    private function getBaseUrl(){
      return "aHR0cHM6Ly93d3cuZ29vZ2xlLmNvbS9zZWFyY2g/cT13ZWF0aGVyKw==";      
    }
}
?>
