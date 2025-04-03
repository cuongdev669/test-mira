# Laravel & Vue.js (TypeScript) Project

This project is a web application built with Laravel as the backend API and Vue.js (TypeScript) as the frontend.

## Features
- **Docker Support**: Easily run the project with Docker Compose.

## Setup Instructions
### Prerequisites
- Docker & Docker Compose installed.

## Directory structure
```
laravel-vue-docker/
│── backend/          # Laravel project
│── frontend/         # Vue.js project
│── docker/           # Docker config files
│   ├── nginx/
│   │   └── default.conf
│   ├── php/
│   │   └── Dockerfile
│   ├── mysql/
│   │   └── my.cnf
│── docker-compose.yml
│── .env
│── .gitignore
```

## Author

[Cuong Nguyen] :email: [Email Me](mailto:cuongcm198@gmail.com)

## License

This project is licensed under the MIT License - see the [License File](LICENSE) for details

## Install project
```
docker run --rm -v $(pwd)/backend:/app composer create-project --prefer-dist laravel/laravel .
```
```
cp backend/.env.example backend/.env
```
### Update env
```
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=user
DB_PASSWORD=password
```
```
docker run --rm -v $(pwd)/frontend:/app node:18 bash -c "cd /app && npm create vite@latest . --template vue"
```
### Build frontend
```
cd frontend
npm run build
```