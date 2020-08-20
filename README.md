## About Project

This is a Laravel project, without any SQL based DB like MySQL. There is a simple CRUD example that works with Redis server as a NoSQL file based DB. You can see more about the using Redis in Laravel in [here](https://laravel.com/docs/7.x/redis) and in [here](https://github.com/phpredis/phpredis).

## Build and run Project

After cloning this repository, make sure make a copy from _.env.example_ to _.env_ file and change DB connection to Redis like `DB_CONNECTION=redis`. Other settings available on `config/database.php`, and no need to change.

This project dockerized to use independent of your OS and covers all requirements. Check you docker & docker-compose version by `docker -v` and `docker-compose -v`. If needed, install them on your system.

- Now running `docker-compose up -d` (add `--build` to rebuild containers) will populate the webapp on containers, include a Nginx server, app container and Redis server.
- Now make a copy from _.env.example_ to _.env_ file.
- Run `docker exec -it app composer install` to install composer dependencies.
- Run `docker exec -it app php artisan key:generate` to set your application key to a random string.
- Finally, you can see the result at [http://localhost:8080/](http://localhost:8080/) on your browser.

You can see the most important codes in _app/Http/Controllers/TutorController.php_ for CRUD codes, _routes/api.php_ for RESTful API routes, _routes/web.php_ for web routes and _resources/views_ for blade views.

To access Restful APIs, use these methods/endpoints:
```
GET       | api/tutors          | index
POST      | api/tutors          | store
PUT|PATCH | api/tutors/{tutor}  | update
DELETE    | api/tutors/{tutor}  | destroy
```

If you want to interact with them you can use something like this for Laravel part: `docker exec -it app composer ...` or `docker exec -it app php artisan ...` or like this for Redis server: `docker exec -it redis redis-cli`. Redis data will save in redis folder, and you can use Redis server for caching purposes too.
