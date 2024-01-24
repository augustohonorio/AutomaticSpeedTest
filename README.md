# AutomaticSpeedTest
Speedtest Logger

This set of scripts automates Speedtest CLI speed tests on an Ubuntu server. Results are recorded in CSV, including timestamp, server, latency, download/upload speeds, packet loss, and result URL. The HTML template offers user-friendly viewing with hyperlinks.

It will need some installations to function properly.

1 - Speedtest CLI installation:
Follow the instructions contained at: https://www.speedtest.net/apps/cli

The server used in this case was based on Debian

2 - Installation of Dependencies:
Make sure you have jq, bc, Apache2 and PHP installed:

sudo apt-get install jq bc apache2 php

Also, enable the php module in Apache:
sudo a2enmod php

Restart apache service:
sudo service apache2 restart

3 - Adjust the time zone to reflect your location:
sudo timedatectl set-timezone YOUR_TIME_ZONE_NAME


4 - File location:
The speedtest.sh file can be located in your user's home page on your Debian-based server. The Index.php file must be located in /var/www/html so that we can access it via the browser using the link: ip_do_seu_servidor:index.php

5 - Run the speedtest.sh script manually to test, or configure a scheduled task to run automatically.

6 (optional) - Schedule periodic execution:
You can use cron to schedule the script to run periodically. Open cron for editing:
crontab -e

Add the line below to run the script every hour, for example:
0 * * * * /path/to/script/speedtest.sh

Edit the script execution period as needed

If you have any difficulties with Crontab, these links will be useful:
https://en.wikipedia.org/wiki/Cron
https://crontab.guru/

Comments
Make sure you have appropriate permissions to write to the directory where the results are saved.
Customize the HTML template or scripts as needed to suit your preferences.
