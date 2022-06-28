<?php
require './WeatherxService.php';

class WeatherxController
{
    private $requestMethod;
    private $id;

    public function __construct($requestMethod, $id)
    {
        $this->requestMethod = $requestMethod;
        $this->id = $id;
    }

    public function processRequest()
    {
        switch ($this->requestMethod)
        {
            case 'GET':
                if ($this->id)
                {
                    $response = $this->getLiveWeather($this->id);
                };
            break;
            default:
                $response = $this->notFoundResponse();
            break;
        }
        header($response['status_code_header']);
        if ($response['body'])
        {
            echo $response['body'];
        }
    }

    private function getLiveWeather($id)
    {
        $service = new WeatherxService();
        $result = $service->getWeatherByCity($id);
        if (!$result)
        {
            return $this->notFoundResponse();
        }
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        return $response;
    }

    private function notFoundResponse()
    {
        $response['status_code_header'] = 'HTTP/1.1 200 OK';
        $response['body'] = null;
        return $response;
    }
}
?>
