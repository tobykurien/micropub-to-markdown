#!/bin/sh
CMS_ROOT=/home/user/pelican
POSTS_ROOT=/home/user/posts
cwd=$(pwd)

inotifywait -mr \
  --timefmt '%d/%m/%y %H:%M' --format '%T %w %f' \
  -e close_write $POSTS_ROOT/microblog |
while read -r date time dir file; do
       changed_abs=${dir}${file}
       changed_rel=${changed_abs#"$cwd"/}

       sleep 1 && $CMS_ROOT/scripts/publish.sh && \
       echo "At ${time} on ${date}, file $changed_abs was published" >&2
done
