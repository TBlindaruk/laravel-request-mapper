.PHONY: test coverage

coverage:
	vendor/bin/phpunit --coverage-text="./tests/coverage.txt"

test: vendor
	vendor/bin/phpunit
