#!/bin/bash

if [ ! $1 ]; then
  echo "Choice: (init|start|stop|bash|migrate|create-dump|restore-dump|remove)"
  exit
fi



case "$1" in
  init)
    docker run --name phone-mariadb --mount type=bind,source=$(pwd)/sql-dump,target=/sql-dump -e MYSQL_ROOT_PASSWORD=phone -p 3307:3306 -d mariadb
    ;;
  start)
    docker container start phone-mariadb
    ;;
  stop)
    docker container stop phone-mariadb
    ;;
  bash)
    docker exec -it phone-mariadb bash
    ;;
  migrate)
    docker exec -i phone-mariadb sh -c 'mysql -u root --password="phone"' < config/migration/001-CreateBaseAndTables.sql
    ;;
  create-dump)
    docker exec -i phone-mariadb sh -c 'mysqldump phone -u root --password="phone"' > sql-dump/phone.sql
    ;;
  restore-dump)
    docker exec -i phone-mariadb sh -c 'mysql -u root --password="phone" phone' < sql-dump/phone.sql
    ;;
  remove)
    docker container rm phone-mariadb
    ;;
  *)
    echo "Wrong input: " $1
    ;;
esac
