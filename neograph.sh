#!/bin/bash

cd /var/www/localhost/htdocs/irc/neograph

# remote example
#wget -O - "http://trevorjay.net/irc/channels.php"|neato -Tjpg -o users.jpg

php channels.php|neato -Tjpg -o ../channels.jpg
php combo.php|neato -Tjpg -o ../combo.jpg
php users.php|neato -Tjpg -o ../users.jpg
php servers.php|neato -Tjpg -o ../servers.jpg


