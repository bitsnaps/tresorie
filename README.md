# Simple Cash Management

[![Build Status](https://travis-ci.com/CorpoSense/tresorie.svg?branch=master)](https://travis-ci.com/CorpoSense/tresorie)

This software is used to apply a simple Cash Management using a simple approval workflow business processes in your company's hierarchy.


## Variable environment
Needed for testing:
```
export CHROME_DRIVER =  /path/to/chromedriver
```

## Migrations
Required to run the app:
```
./yii migrate --migrationNamespaces=Da\\User\\Migration --interactive=0
./yii migrate --migrationPath=@yii/rbac/migrations --interactive=0
./yii migrate --interactive=0
```
