build: # Build the application
	@composer install --no-dev

dev: # Build the application with dev dependencies
	@compser install

hash: # Generate an endpoint hash
	@dd if=/dev/urandom bs=4096 count=1 status=none | sha1sum

update upgrade: # Upgrade application dependencies
	@composer update

ngrok: # Expose the application via ngrok
	@ngrok http -host-header=rewrite http://icbot.local:80
