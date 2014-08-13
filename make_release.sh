#!/bin/sh
VERSION=$1
NAME=php-lib-json

git clone https://github.com/fkooman/${NAME}.git ${NAME}-${VERSION}
(
cd ${NAME}-${VERSION}
composer.phar install --no-dev
)
tar -cJf ${NAME}-${VERSION}.tar.xz ${NAME}-${VERSION}
