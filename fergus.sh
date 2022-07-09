#!/usr/bin/env bash

export PROJECT_DIR=${PWD}

case $1 in
    artisan)
        ARGS_STR=${*:2}
        echo "Running php artisan $ARGS_STR"
        docker exec -it application-fpm php artisan "${@:2}"
        ;;
    up)
        echo 'Bring up docker containers.'
        ./.docker/scripts/local.sh up -d ${@:2}
        ;;
    down)
        echo 'Bring down docker containers.'
        ./.docker/scripts/local.sh down --remove-orphans
        ;;
    logs)
        echo 'Logs on the container.'
        ./.docker/scripts/local.sh logs -f ${@:2}
        ;;
    test)
        echo 'Running both e2e and unit tests'
        docker exec application-fpm vendor/bin/phpunit ${@:2}
        ;;
    test:e2e)
        echo 'Running e2e tests'
        docker exec application-fpm vendor/bin/phpunit --testsuite=Feature ${@:2}
        ;;
    test:unit)
        echo 'Running unit tests'
        docker exec application-fpm vendor/bin/phpunit --testsuite=Unit ${@:2}
        ;;
    pint)
        echo 'Fixing php files using pint'
        docker exec application-fpm vendor/bin/pint
        ;;
    composer)
        echo "Running composer ${@:2}."
        ./.docker/scripts/composer.sh ${@:2}
        ;;

    *)
    echo "Unknown command."
    ;;
esac
