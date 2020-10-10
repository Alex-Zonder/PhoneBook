# Phone book #

Need docker & php.7.> to be installed.

## Get phone-book ##
```bash
git clone https://github.com/Alex-Zonder/PhoneBook.git
cd phonebook
chmod +x sql-docker.sh
chmod +x start-php-serve.sh
```

### Start mariadb in docker ###
```bash
./sql-docker.sh init
```

### Run migration ###
```bash
./sql-docker.sh migrate
```

### Restore dump ###
```bash
./sql-docker.sh restore-dump
```

### Run php server ###
```bash
./start-php-serve.sh
```
