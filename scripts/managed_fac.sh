#!/bin/sh

printf "use anonymousboard;\nDELETE FROM logged_in WHERE time < (NOW() - INTERVAL 15 MINUTE);\nexit" | mysql -u root
