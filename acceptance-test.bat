echo "You need to serve the app (e.g. ./tests/bin/yii serve)"
java -jar -Dwebdriver.chrome.driver=$CHROME_DRIVER/chromedriver $SELENIUM/selenium-server-standalone-3.141.59.jar
