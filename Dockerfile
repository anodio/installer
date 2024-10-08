FROM vladitot/php83-swow-alpine-local
LABEL maintainer="Zakotnev Vladimir"

USER root
RUN mkdir -p /installer
RUN chown -R 1000:1000 /installer

USER 1000

COPY --chown=1000:1000 ./installer-http.php /installer/installer-http.php
COPY --chown=1000:1000 ./docker-compose.yaml /installer/docker-compose.yaml
COPY --chown=1000:1000 ./xc.md /installer/xc.md


#ENTRYPOINT ["php", "/installer/installer-http.php"]
ENTRYPOINT ["php"]