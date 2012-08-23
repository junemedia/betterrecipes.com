# Better Recipes

## URLs

### Production

http://www.betterrecipes.com/

### Staging

http://betterrecipes.mydevstaging.com/


## Installation

### Cloning Project:

    cd /srv/sites
    git clone git@github.com:resolute/betterrecipes.git
    cd betterrecipes
    mkdir cache log
    chmod -R a+rw cache log

### Incoming Directories:

    # uploads
    mkdir -p /srv/incoming/betterrecipes/uploads
    chmod -R a+rw /srv/incoming/betterrecipes/uploads
    cd /srv/sites/betterrecipes/web && ln -s /srv/incoming/betterrecipes/uploads uploads

    # sitemaps
    mkdir -p /srv/incoming/betterrecipes/sitemaps
    chmod -R a+rw /srv/incoming/betterrecipes/sitemaps
    cd /srv/sites/betterrecipes/web && ln -s /srv/incoming/betterrecipes/sitemaps sitemaps

### Database Import:

    mysql -e 'create database betterrecipes'
    mysqldump -Ch rd7 betterrecipes | mysql betterrecipes

## Cron Jobs

    # betterrecipes: Export Baynote XML Catalog at 02:15
    15   2 * * * root /srv/sites/betterrecipes/data/bin/baynote_xml.php | gzip -c9 > /srv/incoming/betterrecipes/uploads/ftp/baynote_resolute.xml.gz

    # betterrecipes: Download OneSite's Baynote XML Catalog at 02:15
    15   2 * * * root /srv/sites/betterrecipes/data/bin/onesite_baynote_download.php

    # betterrecipes: Send out emails from message table every hour
    10   * * * * root /srv/sites/betterrecies/symfony br:send-message

    # betterrecipes: should be run nightly to update the contestants rankings
    #   will also update the unofficial contest winner for each week
    15   2 * * * root /srv/sites/betterrecipes/symfony br:rankings

## Notes

More documentation on the [Resolute wiki](http://toc.resolute.com/wiki) for additional documentation including **OneSite**.

