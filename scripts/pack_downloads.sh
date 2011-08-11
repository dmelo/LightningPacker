#!/bin/bash

# Pack all downloadable content

VERSION=`cat VERSION`
DOWNLOAD_PATH=public/download
PUBLIC=public/
ZEND_VIEW=application/views/helpers
DRUPAL=drupal

rm -rf ${DOWNLOAD_PATH}/*

# Packing PHP.
PACK_PHP=lightningpacker-php-${VERSION}
mkdir ${DOWNLOAD_PATH}/${PACK_PHP}
cp ${PUBLIC}/LightningPacker.php COPYING ${DOWNLOAD_PATH}/${PACK_PHP}
cd ${DOWNLOAD_PATH}
tar -jcvf ${PACK_PHP}.tar.bz2 ${PACK_PHP}
cd -

# Packing Zend Framework
PACK_ZEND=lightningpacker-zend-${VERSION}
mkdir ${DOWNLOAD_PATH}/${PACK_ZEND}
cp COPYING ${ZEND_VIEW}/LightningPackerScript.php ${ZEND_VIEW}/LightningPackerLink.php ${PUBLIC}/LightningPacker.php ${DOWNLOAD_PATH}/${PACK_ZEND}
cd ${DOWNLOAD_PATH}
tar -jcvf ${PACK_ZEND}.tar.bz2 ${PACK_ZEND}
cd -

# Packing Drupal Module
PACK_DRUPAL=lightningpacker-drupal-${VERSION}
mkdir ${DOWNLOAD_PATH}/${PACK_DRUPAL}
cp COPYING ${DRUPAL}/lightningpacker.module ${DRUPAL}/lightningpacker.info ${PUBLIC}/LightningPacker.php ${DOWNLOAD_PATH}/${PACK_DRUPAL}/
cd ${DOWNLOAD_PATH}
tar -jcvf ${PACK_DRUPAL}.tar.bz2 ${PACK_DRUPAL}
cd -
