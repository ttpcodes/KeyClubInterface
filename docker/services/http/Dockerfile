FROM nginx:alpine

LABEL maintainer="tehtotalpwnage@gmail.com"

ARG gid=9999
ARG uid=9999

COPY nginx.conf /etc/nginx/nginx.conf
RUN mkdir -p /srv/www/

RUN mkdir -p /srv/logs/

RUN addgroup -g $gid keyclub
RUN adduser -D -g '' -G keyclub -s /bin/ash -u $uid keyclub
RUN chown -R keyclub:keyclub /srv
