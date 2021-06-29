sudo apt-get update
sudo apt-get install mysql-server
sudo /etc/init.d/mysql stop
sudo mkdir /var/run/mysqld
sudo chown mysql /var/run/mysqld
sudo mysqld_safe --skip-grant-tables&
sudo mysql --user=root mysql
create database yalitresoredb;