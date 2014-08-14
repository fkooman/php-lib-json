#!/bin/sh

if [ "$#" -eq 1 ]
then
    VERSION=$1
else
    VERSION=0.0.1
fi

ARCHIVE_NAME=php-fkooman-json
REPO_NAME=php-lib-json

git clone https://github.com/fkooman/${REPO_NAME}.git ${ARCHIVE_NAME}-${VERSION}
(
cd ${ARCHIVE_NAME}-${VERSION}
composer.phar install --no-dev
)
tar -cJf ${ARCHIVE_NAME}-${VERSION}.tar.xz ${ARCHIVE_NAME}-${VERSION}
