# Artisan RunX
Run multiple Laravel Artisan commands with a single command


## INSTALLATION
```shell
composer require monurakkaya/artisan-runx
```
## USAGE
```shell
php artisan runx --commands="migrate --seed && cache:clear && storage:link"
```
## Tests
To run the tests, execute the following from the command line, while in the project root directory:

```shell
./vendor/bin/phpunit
```
