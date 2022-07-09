#!/usr/bin/env bash

docker-compose --file=../.docker/docker-compose.yml --env-file=../docker/.env down $@