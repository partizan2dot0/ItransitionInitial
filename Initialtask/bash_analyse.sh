echo "Starting php-sc fixer..."
./vendor/bin/php-cs-fixer fix ./src
./vendor/bin/php-cs-fixer fix ./tests

echo "Starting phpstan analyse..."
./vendor/bin/phpstan analyse src tests

echo "Starting unit tests..."
php ./vendor/bin/phpunit
