#!/bin/sh
POSTS_ROOT=/home/user/posts

sudo apt install imagemagick inotify-tools

# create the POSTS_ROOT directory structure where posts are saved
mkdir -p $POSTS_ROOT/microblog
mkdir -p $POSTS_ROOT/images/microblog

# set owner so that the web server can write to these directories
chown -R www-data:www-data $POSTS_ROOT
