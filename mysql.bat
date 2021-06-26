docker pull mysql/mysql-server:latest
docker run --name=mysql1 -d mysql/mysql-server:latest

docker ps
docker logs mysql1

docker exec -it mysql1 bash
docker exec -it mysql1 mysql -uroot -p
docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=hP/E4Z45lQ1r1Y*zxsIQ0ob^6_@k%^5 -d mysql:latest

ALTER USER 'root'@'localhost' IDENTIFIED BY '123456';
CREATE DATABASE  yalitresoredb;

