[![CircleCI](https://circleci.com/gh/BinaryStudioAcademy/bsa-2018-hedonist.svg?style=svg)](https://circleci.com/gh/BinaryStudioAcademy/bsa-2018-hedonist)

## BSA PHP 2018 Hedonist project

## Getting started

Install the following packages prior to standing up your development environment:

- [Git](https://git-scm.com/)
- [docker](https://docs.docker.com/engine/installation/)
- [docker-compose](https://docs.docker.com/compose/install/)
- [node](https://nodejs.org/en/)


Set your .env vars and then type:
```
git clone <this_repo>
cp .env.example .env
docker-compose up -d
docker exec -it bsa-app-php composer install
docker exec -it bsa-app-php php artisan key:generate
docker exec -it bsa-app-php php artisan migrate
```

### Frontend part (SPA)

You need to install [yarn](https://yarnpkg.com/lang/en/) first.

Install all javascript packages:  

```
yarn install
```

_Development_  
``` 
yarn run dev
```

_Production_  
``` 
yarn run prod
```

Ready.
```
http://localhost:<your_port>
```

## Usage

To start your containers you have only type next command:
```
docker-compose up -d
```

Run composer command you should use it within docker:
```
docker exec -it bsa-app-php composer <your command>
```

In order to execute artisan command use next syntax:
```
docker exec -it bsa-app-php php artisan <your command>
```