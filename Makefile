BASE = $(realpath ./)
SRC_DIR = $(BASE)/src
BIN_DIR = $(BASE)/vendor/bin

sniff:
	$(BIN_DIR)/phpcs --standard=PSR2 --extensions=php --ignore=logs --colors $(SRC_DIR)

sniff-fix:
	$(BIN_DIR)/phpcbf --standard=PSR2 --extensions=php --ignore=logs,views $(SRC_DIR)
