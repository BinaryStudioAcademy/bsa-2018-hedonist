FROM node:10.9.0-jessie

RUN apt-get update \
    && apt-get -y --no-install-recommends install libpng-dev autoconf automake make g++ libtool nasm libpng-dev \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
