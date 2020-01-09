build: # Build the application
	@composer install --no-dev

dev: # Build the application with dev dependencies
	@compser install --dev

update upgrade: # Upgrade application dependencies
	@composer update

tunnel: # Expose the application via a secure tunnel
	@ngrok http -host-header=rewrite http://icbot.local:80
