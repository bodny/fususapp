#!/bin/bash
# argument can be used to e.g. delete volumes: -v
if [ "$1" != "" ]; then
    ARGUMENT="$1"
fi

docker-compose --project-name=fususapp down $ARGUMENT
