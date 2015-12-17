# DdxSmartRobot
Rework of DdxDumbRobot, don't get your hopes up just yet :-)

[![SensioLabsInsight](https://insight.sensiolabs.com/projects/62593c62-56b0-492d-b375-bbb4aa20cb1e/big.png)](https://insight.sensiolabs.com/projects/62593c62-56b0-492d-b375-bbb4aa20cb1e)
[![Build Status](https://travis-ci.org/Ddall/SmartRobot.svg)](https://travis-ci.org/Ddall/SmartRobot)

## First start
* composer update ``php composer update``
* doctrine update ``php app\console doctrine:schema:update --force``
* load fixtures    ``php app\console doctrine:fixtures:load --append``

## Commands
```bash
/usr/bin/php app/console kraken:orderbook:update
```

## ADD TO CRONTAB 
```
* * * * * /usr/bin/php app/console markets:refresh > /dev/null 2>&1
```
