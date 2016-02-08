# dana/bitap Makefile

.SILENT:

default:    vendor/bin/phpunit
build:      vendor/bin/phpunit
build_dev:  vendor/bin/phpunit
vendor_dev: vendor/bin/phpunit

# Install Composer
composer:
	php -r "readfile('https://getcomposer.org/installer');" | php -- --filename=composer
	chmod a+x ./composer
	touch     ./composer

# Install non-dev dependencies
vendor: composer
	./composer -n --no-dev install
	touch vendor

# Install dev dependencies
vendor/bin/phpunit: composer
	./composer -n install
	touch vendor vendor/bin vendor/bin/phpunit

# Clean generated folders and phars
distclean: clean
clean:
	rm -rf ./coverage ./vendor ./.phpintel/
	rm -f  ./composer ./*.phar

# Perform PHPUnit tests
test: vendor/bin/phpunit
	./vendor/bin/phpunit --color

PHONY := default
PHONY += build build_dev vendor_dev
PHONY += clean distclean
PHONY += test

.PHONY: $(PHONY)

