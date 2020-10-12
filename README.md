# Phone book #

Need docker & php.7.> to be installed.

## Get phone-book ##
```bash
git clone https://github.com/Alex-Zonder/PhoneBook.git \
&& cd PhoneBook \
&& chmod +x sql-docker.sh \
&& chmod +x start-php-serve.sh
```

## Init phone-book ##
```bash
./sql-docker.sh init |
&& sleep 10 |
&& ./sql-docker.sh migrate |
&& ./sql-docker.sh restore-dump |
&& ./start-php-serve.sh
```

## Single commands ##
### Start mariadb in docker ###
```bash
./sql-docker.sh init
```

### Run migration ###
```bash
./sql-docker.sh migrate
```

### Create dump ###
```bash
./sql-docker.sh create-dump
```

### Restore dump ###
```bash
./sql-docker.sh restore-dump
```

### Remove mariadb docker container ###
```bash
./sql-docker.sh restore-dump
```

### Run php server ###
```bash
./start-php-serve.sh
```
In default will run on 127.0.0.1:8000
