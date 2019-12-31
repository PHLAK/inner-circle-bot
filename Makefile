build: # Build the application
	@composer install --no-dev

dev: # Build the application with dev dependencies
	@compser install

update upgrade: # Upgrade application dependencies
	@composer update

ngrok: # Expose the application via ngrok
	@ngrok http -host-header=rewrite http://icbot.local:80
