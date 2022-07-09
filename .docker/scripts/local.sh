#!/usr/bin/env bash

INCLUDE_INTEGRATIONS_CONTAINERS=${INCLUDE_INTEGRATIONS_CONTAINERS:-0}

if [  -z ${PROJECT_DIR+x} ]
then
    echo 'PROJECT_DIR not set';
    exit 0;
fi;
THIS_DIR=${PWD}

## work out some extra variables for docker containers
source $THIS_DIR/.docker/scripts/common/config.sh

##override the IMAGE_TAG
export IMAGE_TAG="local";

ARGS="-f $THIS_DIR/.docker/docker-compose-common.yml -f $THIS_DIR/.docker/docker-compose-local.yml --env-file=$THIS_DIR/.docker/.env"

docker-compose $ARGS $@

exit 0;
