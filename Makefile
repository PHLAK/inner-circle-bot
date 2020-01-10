NGROK_URL="$$(curl --silent http://localhost:4040/api/tunnels/command_line | jq --raw-output '.public_url')"
TELEGRAM_TOKEN="$$(grep 'TELEGRAM_TOKEN' .env | awk -F = '{print $$2}')"

build: # Build the application
	@composer install --no-dev

dev: # Build the application with dev dependencies
	@compser install --dev

update upgrade: # Upgrade application dependencies
	@composer update

tunnel: # Expose the application via a secure tunnel
	@ngrok http -host-header=rewrite http://icbot.local:80

webhook: # Register the Telegram webhook URL
	@curl --request POST --header 'content-type: application/json' \
		--url https://api.telegram.org/bot$(TELEGRAM_TOKEN)/setWebhook \
		--data "{\"url\": \"$(NGROK_URL)/$(TELEGRAM_TOKEN)\""
	@echo
