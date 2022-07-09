#!/usr/bin/bash
#set -ex
THIS_DIR=$PWD
[[ -f common/config.sh ]] && THIS_DIR=$PWD/../..
[[ -f scripts/common/config.sh ]] && THIS_DIR=$PWD/..

PROJECT_DIR=$THIS_DIR

export APPLICATION=fergus
if [ -z "$APP_ENV" ]; then
    export APP_ENV=$(egrep "APP_ENV=" $PROJECT_DIR/.env | cut -d '=' -f 2)
fi
export APP_VERSION=$( egrep "\s+'version' => '" $PROJECT_DIR/config/app.php | cut -d \' -f 4 )
export IMAGE_PREFIX=$CONTAINER_REGISTRY_URL

# IMPORTANT: using the same project name means compose volumes are shared
export COMPOSE_PROJECT_NAME=${USER}-${APPLICATION}
export COMPOSE_CONVERT_WINDOWS_PATHS=1

export BUILD_DATE=$( date -u +'%Y-%m-%dT%H:%M:%SZ' )
# The Version Control System reference is the commit hash or "NONE"
export VCS_REF="$CI_COMMIT_SHORT_SHA"
export VCS_BRANCH="$CI_COMMIT_REF_NAME"


if [ -z "$IMAGE_PREFIX" ]; then
    export IMAGE_PREFIX=fergus-local # fallback if URL is not present
fi

if [ -z "$VCS_REF" ]; then
    LOCAL_BRANCH_NAME=$( git branch --show-current )
    LOCAL_BRANCH_NAME=${LOCAL_BRANCH_NAME#epic/}
    export VCS_REF=${LOCAL_BRANCH_NAME#feature/}
fi

if [ -z "$VCS_BRANCH" ]; then
   LOCAL_COMMIT_SHORT_SHA=$( git rev-parse --short HEAD )
   export VCS_BRANCH="$LOCAL_COMMIT_SHORT_SHA-local"
fi

export IMAGE_TAG="${VCS_REF}"

# The application files relative to the project root directory
export APPLICATION_SOURCE_FOLDER=./
export APPLICATION_BUILD_SCRIPT=./scripts/build-release.sh

