FROM vladitot/php83-swow-ubuntu-local
LABEL maintainer="Zakotnev Vladimir"

ENV DEBIAN_FRONTEND noninteractive
USER root
RUN mkdir -p /installer
RUN chown -R 1000:1000 /installer

USER 1000

COPY --chown=1000:1000 ./installer-http.php /installer/installer-http.php
COPY --chown=1000:1000 ./frock.override.yaml /installer/frock.override.yaml
COPY --chown=1000:1000 ./frock.yaml /installer/frock.yaml

#ENTRYPOINT ["php", "/installer/installer-http.php"]
ENTRYPOINT ["php"]