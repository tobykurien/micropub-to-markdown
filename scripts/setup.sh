#!/bin/sh
sudo apt install imagemagick inotify-tools

# create the POSTS_ROOT directory structure where posts are saved
mkdir -p /home/user/posts/microblog
mkdir -p /home/user/posts/images/microblog

# set owner so that the web server can write to these directories
chown -R www-data:www-data /home/user/posts
