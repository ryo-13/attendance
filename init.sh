#!/bin/bash

SCRIPT_DIR=$(cd $(dirname $0); pwd)

cp $SCRIPT_DIR/laradock/env-example $SCRIPT_DIR/laradock/.env
sed -i '' 's!^APP_CODE_PATH_HOST=.*$!APP_CODE_PATH_HOST=../attendance!' $SCRIPT_DIR/laradock/.env
sed -i '' 's!^DATA_PATH_HOST=.*$!DATA_PATH_HOST=../.laradock/data!' $SCRIPT_DIR/laradock/.env
