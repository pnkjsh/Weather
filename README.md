***Weather API***
Weather will provide you with the weather information fast and easy without any authentication or API key. It is completely free to use and simple to implement.

**Request Endpoint**
GET   https://piuli.iblogger.org/api/weather/{location}
Use this to send requests and replace {location} with your desired location like kolkata, newyork, london, etc. Try to avoid spaces and other unwanted characters.

**Javascript Usage**
fetch("https://piuli.iblogger.org/api/weather/Mumbai")
    .then(res=>res.json())
    .then(json=>console.log(json))

**Output**
{
    "city": {string} -- city name provided
    "temp_c": {number} -- temperature in celsius  
    "week_day": {string} -- week days like Sunday
    "local_time": {string} -- local time of the provided city like 19:45
    "condition": {string} -- weather condition as Sunny
    "weather_img": {string} -- url of the weather image in png 64X64 pixels
}

**Response**

The requested URL should have a valid city name. Then the response should be as follows.

GET   https://piuli.iblogger.org/api/weather/Kolkata

Response: 200 - OK
{
    "city": "Kolkata",
    "temp_c": 29,
    "week_day": "Friday",
    "local_time": "13:35",
    "condition": "Light thunderstorms and rain",
    "weather_img": "https://ssl.gstatic.com/onebox/weather/64/.png"
}


**Error**
Error occurs when the specified location does not exists, weather data for that location is not available or there is a spelling error.

GET   https://piuli.iblogger.org/api/weather/hello

Response:
200 - OK
{
    "status": "fail",
    "message": "No city found",
    "city": "hello"
}
