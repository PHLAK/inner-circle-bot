NGROK_URL="$$(curl --silent http://localhost:4040/api/tunnels/command_line | jq --raw-output '.public_url')"
TELEGRAM_TOKEN="$$(grep 'TELEGRAM_TOKEN' .env | awk -F = '{print $$2}')"

dev development: # Build application for development
	@composer install --no-interaction

prod production: # Build application for production
	@composer install --no-dev --no-interaction --prefer-dist

update upgrade: # Upgrade application dependencies
	@composer update

test: #: Run coding standards/static analysis checks and tests
	@vendor/bin/php-cs-fixer fix --diff --dry-run \
		&& vendor/bin/psalm --show-info=false \
		&& vendor/bin/phpunit --coverage-text

coverage: # Generate an HTML coverage report
	@vendor/bin/phpunit --coverage-html .coverage

tunnel: # Expose the application via a secure tunnel
	@ngrok http -host-header=rewrite http://icbot.local:80

webhook: # Register the Telegram webhook URL
	@curl --request POST --header 'content-type: application/json' \
		--url https://api.telegram.org/bot$(TELEGRAM_TOKEN)/setWebhook \
		--data "{\"url\": \"$(NGROK_URL)/$(TELEGRAM_TOKEN)\""
	@echo
