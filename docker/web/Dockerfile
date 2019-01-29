FROM nginx

ARG UID
ARG GUID
ARG TZ

ENV UID "${UID}"
ENV GUID "${GUID}"
ENV TZ "${TZ}"

RUN usermod -u $UID www-data && groupmod -g $GUID www-data
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

WORKDIR /var/www/app
