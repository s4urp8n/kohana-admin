#!/usr/bin/env bash
#
# Set default safe rights to web folder
#

SITENAME=${2%/}
DIR=${1%/}

# files
STATUS="Setting 644 for files $DIR"
echo -n $STATUS
find $DIR -type f -exec chmod 644 {} \;
echo -e "\r$STATUS [OK]"

# dirs
STATUS='Setting 755 for directories'
echo -n $STATUS
find $DIR -type d -exec chmod 755 {} \;
echo -e "\r$STATUS [OK]"

#user and group
DATE=`date +%S%N`
FILE="$DATE.php"

cd $DIR
mkdir $DATE
echo "<?php\n" > $DIR/$DATE/$FILE
echo "echo exec('id');" >> $DIR/$DATE/$FILE

USER=`curl -s "$SITENAME/$DATE/$FILE" | cut -d ' '  -f 1 | cut -d '(' -f 2 | cut -d ')' -f 1`

GROUP=`curl -s "$SITENAME/$DATE/$FILE" | cut -d ' '  -f 2 | cut -d '(' -f 2 | cut -d ')' -f 1`

rm -f $DIR/$DATE/$FILE
rmdir $DIR/$DATE

STATUS="Setting owner of directory to user: $USER and group: $GROUP ";
echo -n $STATUS
chown -R $USER:$GROUP $DIR
echo -e "\r$STATUS [OK]\n\n"









