Weather API Documentation    

Weather API Reference
=====================

Weather API provides the weather information fast and easy way without any authentication or API key. It is completely free to use and simple to implement. The Weather API is organized around [REST](http://en.wikipedia.org/wiki/Representational_State_Transfer). Our API has predictable resource-oriented URLs, accepts json request, returns [JSON-encoded](https://www.json.org/json-en.html) responses, and uses standard HTTP response codes, and verbs.
[More read](https://piuli.iblogger.org/docs/weather)

##Data on UI

![weather screen](https://piuli.iblogger.org/docs/weather-api.png)

#####Base URL

    https://yourserver.org/api

##Request Endpoints

Use these enspoints to send requests and replace {location} with your desired location like kolkata, newyork, london, etc. Try to avoid spaces and other unwanted characters.

#####ENDPOINTS

        GET /weather/{location}           
        GET /weatherx/{location

##Request-Response

#####Request
| Method | URI |
| ------ | ------ |
| GET | [/weather/kolkata](https://piuli.iblogger.org/api/weather/kolkata) |

#####Response

        {
            "location": "Kolkata, West Bengal, India",
            "temp_c": 31,
            "week_day": "Sunday",
            "local_time": "17:11",
            "condition": "Rain",
            "weather_img": "https://ssl.gstatic.com/onebox/weather/64/rain.png"
        }

#####Request
| Method | URI |
| ------ | ------ |
| GET | [/weather/london](https://piuli.iblogger.org/api/weatherx/london) |
#####Response

    {
            "location": "London, England, United Kingdom",
            "local_dt_tm": "26 Jun 2022, 12:50:10",
            "img_base_url": "https://piuli.iblogger.org/api/images/",
            "forecast_today": {
                "temp_now_c": 20,
                "condition": "Scattered clouds.",
                "img_src": "wt-2.svg",
                "feels_like_c": 20,
                "temp_max_c": 19,
                "temp_min_c": 12,
                "wind_mph": 17,
                "wind_dir": "Wind blowing from 200-degree South-southwest to North-northeast",
                "humidity": "46%",
                "pressure": "1012 mbar",
                "dew_point_c": 8,
                "visibility": "N/A"
            },
            "forecast_5hrs": [
                {
                    "time": "Now",
                    "condition": "Scattered clouds.",
                    "temp_c": 20,
                    "img_src": "wt-2.svg"
                },
                {
                    "time": "13:00",
                    "condition": "Mostly sunny.",
                    "temp_c": 21,
                    "img_src": "wt-2.svg"
                },
                {
                    "time": "14:00",
                    "condition": "Partly cloudy.",
                    "temp_c": 22,
                    "img_src": "wt-4.svg"
                },
                {
                    "time": "15:00",
                    "condition": "More sun than clouds.",
                    "temp_c": 22,
                    "img_src": "wt-2.svg"
                },
                {
                    "time": "16:00",
                    "condition": "More sun than clouds.",
                    "temp_c": 21,
                    "img_src": "wt-2.svg"
                },
                {
                    "time": "17:00",
                    "condition": "More sun than clouds.",
                    "temp_c": 21,
                    "img_src": "wt-2.svg"
                }
            ],
            "forecast_5days": [
                {
                    "day_dt": 27,
                    "condition": "Light showers. Mostly cloudy.",
                    "img_src": "wt-33.svg",
                    "max_temp_c": 19,
                    "min_temp_c": 12
                },
                {
                    "day_dt": 28,
                    "condition": "Broken clouds.",
                    "img_src": "wt-6.svg",
                    "max_temp_c": 21,
                    "min_temp_c": 11
                },
                {
                    "day_dt": 29,
                    "condition": "Overcast.",
                    "img_src": "wt-7.svg",
                    "max_temp_c": 20,
                    "min_temp_c": 14
                },
                {
                    "day_dt": 30,
                    "condition": "Rain. Overcast.",
                    "img_src": "wt-19.svg",
                    "max_temp_c": 20,
                    "min_temp_c": 13
                },
                {
                    "day_dt": 1,
                    "condition": "Isolated thunderstorms. Partly cloudy.",
                    "img_src": "wt-21.svg",
                    "max_temp_c": 19,
                    "min_temp_c": 12
                }
            ]
        }

##Javascript Usage

The fetch() method in JavaScript is used to request to the server and load the information on the webpages. The request can be of any APIs that return the data of the format JSON. XMLHttpRequest, JQuery.ajax, Http-client, Axios, etc. can also be used.

CODE: fetch() example

    fetch("[base_url]/api/weather/paris")
            .then(res=>res.json())
            .then(json=>console.log(json))

CODE: axios example

    const axios = require('axios');
            axios.get('[base_url]/api/weather/paris').then(res => {        
                console.log(res.data);
            });

CODE: xhr example

    let xhr = new XMLHttpRequest();
            xhr.open('GET', '[base_url]/api/weather/paris');
            xhr.responseType = 'json';
            xhr.send();
            
            xhr.onload = function() {
              console(xhr.response);
            };

##Command-line Usage

curl is a command-line tool for transferring data, and it supports almost all protocols, including HTTP. In verbose (-v) mode, the commands provide helpful information such as the resolved IP address, the port we're trying to connect to, and the headers.

CODE: curl example

    curl -v [base_url]/api/weather/paris  //verbose mode on
            curl [base_url]/api/weather/paris

Weather
=======

##### Weather request format

**location** REQUIRED

The search location string. The location must be a valid location name.

##### Weather response format

**location** string

The location of the provided weather with state and country name.

**temp\_c** number

Current temperature of the location in celcius.

**week\_day** string

Week day in string. example Friday

**local\_time** string

Local time of the location in hh:mm 24hrs format.

**condition** string

Current weather condition of the location.

**weather\_img** string

The current weather condition image url to show on UI.

Weatherx
========

##### Weather request format

**location** REQUIRED

The search location string. The location must be a valid location name.

##### Weather response format

**location** string

The location of the provided weather with state and country name.

**local\_dt\_tm** string

Local date-time of the location.

**img\_base\_url** string

Base image url of the current weather condition.

**forecast\_today** object

Today's forecast object.

**forecast\_5hrs** array

Forecast of the next five(5) hours.

**time** string

Time in hh:mm 24hrs format or Now.

**condition** string

Weather condition of that date.

**temp\_c** number

Temperature of the hour in celcius.

**img\_src** string

Weather condition image file name to show on UI.

**forecast\_5days** array

Forecast of the next five(5) days.

**day\_dt** number

Calendar day from \[1-31]\.

**condition** string

Weather condition of that date.

**img\_src** string

Weather condition image file name to show on UI.

**max\_temp\_c** number

Maximum temperature of the day in celcius.

**min\_temp\_c** number

Minimum temperature of the day in celcius.

##Error
Error occurs when the specified location does not exists, weather data for that location is not available or there is a spelling error.

####Request-Response

    
    GET   [base_url]/api/weather/hello
    
    200 - OK
    {
        "status": "fail",
        "message": "No city found",
        "city": "hello"
    }