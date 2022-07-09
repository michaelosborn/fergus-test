#!/usr/bin/env bash

[[ "$*" == *"require"* ]] && \
echo -e "
IMPORTANT: This will run a standalone composer Docker image, which is not aware of PHP Docker image's PHP extensions.
"

if [  -z ${PROJECT_DIR+x} ]
then
    echo 'PROJECT_DIR not set';
    exit 0;
fi;
COMPOSER_VERSION=2.0
THIS_DIR=${PROJECT_DIR}

echo PROJECT_DIR is $PROJECT_DIR
docker run --rm --interactive --tty \
  --volume ${THIS_DIR}:/app \
  composer:${COMPOSER_VERSION} ${@}
