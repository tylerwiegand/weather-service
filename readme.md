Weather Service
The business wants a web service developed that returns current weather information for a mobile client user based on their current zipcode.
Constraints

* Framework: Laravel 5.5 or Lumen 5.5
* HTTP Library: Guzzle
* Dependency Manager: Composer
* Hydration: Symfony Serializer or JMS Serializer
* Test Framework: PHPUnit
* Coding Style Guide: PSR-2

Design Considerations

* Keep controllers skinny; meaning, strive for loosely coupled design.
* Code your weather client functionality to an interface; not an implementation.
* Implement cache functionality for your weather client through composition, rather than inheritance.
* Bind services to an interface (not an implementation) in the service container.

Functional Requirements

* Consume weather data from https://openweathermap.org/.
* Provide a RESTful endpoint that takes a zipcode as a required parameter and returns a wind resource.
* Validates input data.
* Response format should be JSON.
* Cache the resource for 15 minutes to avoid expensive calls to the OpenWeatherMap API.
* Wind resource response contains:
* Wind Speed
* Wind Direction

Unit Testing Requirements

* Use mock responses from the OpenWeatherMap API.
* Use mocks when interacting with the cache layer.

How To Run

1. Clone the repository.
2. Install dependencies:

$ composer install

3. Run the built-in web server:

$ php artisan serve

4. The wind resource should now be accessible by running a curl command:

$ curl -x http://localhost:8000/api/v1/wind/89101
NOTE: All code challenges should be hosted on a publicly accessible git repository (i.e. GitHub, BitBucket, etc).

