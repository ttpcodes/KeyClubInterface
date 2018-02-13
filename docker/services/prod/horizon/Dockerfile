FROM 127.0.0.1:5000/keyclubinterface_php

RUN apk add --no-cache supervisor

COPY supervisord.conf /etc/supervisord.conf

ENTRYPOINT ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisord.conf"]

WORKDIR /etc/supervisor/conf.d/
