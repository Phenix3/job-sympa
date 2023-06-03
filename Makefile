db-start:
    sudo systemctl start mysql
.PHONY: db-start

sf-start:
    $(MAKE) db-start
    symfony serve
.PHONY: sf-start
