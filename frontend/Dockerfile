# Base image cho Vue.js build
FROM node:18 AS build-stage

WORKDIR /app

COPY . .

RUN npm install

RUN npm run build

# Base image cho production
FROM nginx:latest AS production-stage

# Copy file build vào Nginx
COPY --from=build-stage /app/dist /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
