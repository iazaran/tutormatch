## About Project

This is a Laravel project, without any SQL based DB like MySQL. There is a simple CRUD example, web based and API based, that work with Redis server as a NoSQL file based DB. You can see more about the using Redis in Laravel in [here](https://laravel.com/docs/7.x/redis) and in [here](https://github.com/phpredis/phpredis).

## Build and Run Project

This project dockerized to use independent of your OS and covers all requirements. Check your docker & docker-compose version by `docker -v` and `docker-compose -v`. If needed, install them on your system.

- Now running `docker-compose up -d` (add `--build` to rebuild containers if needed) will populate the webapp on containers, include Nginx server, app container and Redis server.
- Now make a copy from _.env.example_ to _.env_ file.
- Run `docker exec -it app composer install` to install composer dependencies.
- Run `docker exec -it app php artisan key:generate` to set your application key to a random string.
- Finally, you can see the result at [http://localhost:8080/](http://localhost:8080/) on your browser.

You can see the most important codes in _app/Http/Controllers/TutorController.php_ for web CRUD codes, _app/Http/Controllers/API/TutorController.php_ for API CRUD codes, _routes/web.php_ for web routes, _routes/api.php_ for RESTful API routes and _resources/views_ for blade views.

To access Restful APIs, use these methods/endpoints:
```
GET       | api/tutors          | index
POST      | api/tutors          | store
PUT|PATCH | api/tutors/{tutor}  | update
DELETE    | api/tutors/{tutor}  | destroy
```
like [http://localhost:8080/api/tutors](http://localhost:8080/api/tutors) in browser or other ones in an API builder like PostMan. This is a cURL example for POST request:

`curl --location --request POST 'http://localhost:8080/api/tutors?title=Test%20Title&description=Test%20Description%20...'`

If you want to interact with images, you can use something like this for Laravel part: `docker exec -it app composer ...` or `docker exec -it app php artisan ...` or like this for Redis server: `docker exec -it redis redis-cli`. Redis data will save in redis folder, and you can use Redis server for caching purposes too.
