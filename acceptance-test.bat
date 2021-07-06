echo "You need to serve the app (e.g. ./tests/bin/yii serve)"
java -jar -Dwebdriver.chrome.driver=$SELENIUM/chromedriver $SELENIUM/selenium-server-standalone-3.141.59.jar
