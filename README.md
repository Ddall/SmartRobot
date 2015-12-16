# DdxSmartRobot
Rework of DdxDumbRobot, don't get your hopes up just yet :-)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/62593c62-56b0-492d-b375-bbb4aa20cb1e/big.png)](https://insight.sensiolabs.com/projects/62593c62-56b0-492d-b375-bbb4aa20cb1e)
[![Build Status](https://travis-ci.org/Ddall/SmartRobot.svg)](https://travis-ci.org/Ddall/SmartRobot)

## First start
* composer update ``php composer update``
* doctrine update ``php app\console doctrine:schema:update --force``
* load fixtures    ``php app\console doctrine:fixtures:load --append``
* load tradingpairs ``php app\console kraken:tradingpairs:update``
* #Enable at least one trading pair.
* run market update ``php app\console kraken:tradehistory:update``

## Commands
```bash
/usr/bin/php app/console kraken:orderbook:update
```

## ADD TO CRONTAB 
```
* * * * * /usr/bin/php /home/ubuntu/DumbRobot/app/console kraken:tradehistory:update >/dev/null 2>&1
*/5 * * * * /usr/bin/php /home/ubuntu/DumbRobot/app/console kraken:orderbook:update >/dev/null 2>&1
0 * * * *  /usr/bin/php /home/ubuntu/backup2mail.php >/dev/null 2>&1
```
