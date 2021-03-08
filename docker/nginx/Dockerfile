FROM nginx:stable-alpine

RUN apk upgrade --update-cache --available && \
    apk add openssl && \
    rm -rf /var/cache/apk/*

RUN mkdir -p /etc/nginx/certs/self-signed/
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/nginx/certs/self-signed/app.test.key -out /etc/nginx/certs/self-signed/app.test.crt -subj "/C=US/ST=Florida/L=Orlando/O=Development/OU=Dev/CN=app.test"
RUN openssl dhparam -out /etc/nginx/certs/dhparam.pem 2048