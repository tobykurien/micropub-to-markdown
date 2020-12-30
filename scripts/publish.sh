#!/bin/sh
CMS_ROOT="/home/user/pelican"
POSTS_ROOT="/home/user/posts"
WEB_ROOT="/var/www/yourwebsite"
USER="user"

mv $POSTS_ROOT/microblog/*.md $CMS_ROOT/content/microblog/

cd $POSTS_ROOT/images/microblog
sudo mogrify -strip -resize 800x600 *
sudo mv $POSTS_ROOT/images/microblog/* $CMS_ROOT/content/images/microblog/

cd $CMS_ROOT
sudo chown -R $USER:$USER content
git pull
git add .
git commit -a -m "new post"
git push

make publish
sudo chown -R www-data:www-data $CMS_ROOT/output/*
sudo cp -Ra $CMS_ROOT/output/* $WEB_ROOT/
