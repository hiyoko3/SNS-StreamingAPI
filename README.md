# SNS-StreamingAPI

An api to acquire data from SNS(eg. Twitter, Facebook, Instagram).

## How to use

This app use with Disaster API.

```bash
# library install
$ composer install

# build a web socket server
$ composer start:ws

# start streaming from Twitter
$ composer curl:ws
```