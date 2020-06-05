
## 初期化手順
```
git submodule init
git submodule update

./init.sh

cd laradock

docker-compose up -d nginx mysql mailhog

docker-compose exec workspace bash

composer install

php artisan key:generate
```
## 工数見積書
https://docs.google.com/document/d/1PtYkR7-vfyIT5G5lDx7xwMPljhhbntM-64SZmlvWGP4/edit

## テーブル設計書
https://docs.google.com/spreadsheets/d/1tZamlpYuKgOCwba5tutny7GIsGrLCHslnrcOdIWQrFU/edit#gid=0

## 管理者設計書
https://docs.google.com/spreadsheets/d/198Jo-7X80gCkCKQrzplJoHY00MCVgxbmwXw3UN7m5Zc/edit#gid=0

## 管理者画面遷移図
https://docs.google.com/drawings/d/1y8G0h9Z391SqLz5f4DNK7-BbTdwD8RVcSztepikzc_Q/edit?ts=5ed5be38

## 作業者設計書
https://docs.google.com/spreadsheets/d/1kISYFnmmUYpKtI7WZU9uIvAoZoTdq3w0qwp89uwTq-k/edit#gid=1995920039

## 作業者画面遷移図
https://docs.google.com/drawings/d/1ikgTky88CJV-G6H14XQlVaEfltZNiK_3chwGtBCkuY4/edit?ts=5ed5be00
