# Corpuscle Framework #
It's very small middleware framework for fast building API micro services apps. 

Can be installed with composer

    composer require jakulov/corpuscle
   

## 1. What's included ##

- [Container and dependency injection Container](https://github.com/jakulov/container)
- [Corpuscle Router](https://github.com/jakulov/corpuscle_router)
- [EventDispatcher](https://github.com/jakulov/event)
- [Logger](https://github.com/jakulov/corpuscle_log)
- ControllerInterface and AbstractController for implementing application logic
- Config loader for loading php configuration files
- AppInterface and App for middleware itself, can handle HTTP requests, send response and provide containers for you

## 2. Third party components ##

- Symfony HTTP Foundation [symfony/psr-http-message-bridge](https://packagist.org/packages/symfony/psr-http-message-bridge)
- PSR Log [psr/log](https://packagist.org/packages/psr/log)

## 3. TODO ##

- Composer hooks for building config files / standalone
- Console App for creating and building projects / standalone
- Storage abstraction layer (generate model for object, find objects with filter & sort, creating & updating object, dispatching events) / standalone
- API Controller (easy to write own API controller, standard functions, request handler and response builder, generating API documentation) / included
- API Accessor (easy access to remote micro services API, abstraction for working with remote objects, generate models by remote API documentation, multiple parallel requests) / standalone
- Response Cache / standalone
- Micro service logger / standalone + app
- Micro service supervisor / app
- File Storage micro service / standalone + app
- Authentication micro service / standalone + app
- Data mining micro service / standalone + app
- Payments micro service / app
- Comments micro service / app
- Geo micro service / app
- Administration / app + frontend
    
## Tests ##

Run:
vendor/bin/phpunit tests/

Tests are also examples for usage library