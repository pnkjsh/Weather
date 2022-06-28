<?php
function getWeatherImageURL($condition)
{

    if (!$condition)
    {
        return false;
    }
    switch ($condition)
    {
        case "haze":
            $weather_img = "fog.png";
        break;
        case "party cloudy":
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
            $weather_img = "sunny.png";
    }

    return "https://ssl.gstatic.com/onebox/weather/64/" . $weather_img;
}
?>
