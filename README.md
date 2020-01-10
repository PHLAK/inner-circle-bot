<p align="center">
  <img src="the-inner-circle-bot.svg" alt="The Inner Circle Bot" width="80%">
</p>

---

Requirements
------------

  - [PHP](https://secure.php.net/) >= 7.3

#### For development

  - [Composer](https://getcomposer.org/)
  - [Docker](https://www.docker.com/)
    - [Docker Compose](https://docs.docker.com/compose/)

Setting up a Local Development Environment
------------------------------------------

### Create a Telegram Bot

In order to test the application locally you will first need to create your own 
Telegram bot to interact with. See the [Telegram docs](https://core.telegram.org/bots#creating-a-new-bot)
for instructions on creating and configuring your own bot.

### Create the Docker `development` Network

    docker network create development

### Run the `jwilder/nginx-proxy` Container

    docker run -d -p 80:80 --network development --restart unless-stopped --volume /var/run/docker.sock:/tmp/docker.sock:ro --name dev-proxy jwilder/nginx-proxy

### Configure the Hostname

Add the following entry to `/etc/hosts`:

    127.0.0.1  icbot.local

### Set Environment Variables

To set up your local environment variables copy `.env.example` to `.env` then
set the variables in the `.env` file.

    cp .env.example .env

### Start the Docker Environment

To build and start the containers on your system for the first time run the
following from the project's root directory:

    docker-compose up -d

### Install PHP dependencies

    composer install

or from within the Docker container:

    docker run -it --rm --env-file ${PWD}/.env --user $(id -u):$(id -g) --volume ${PWD}:/app composer:1.9 \
        && composer install --working-dir /app --ignore-platform-reqs --no-cache --no-interaction --no-scripts

### Create application tunnel via ngrok

    ngrok http -host-header=rewrite http://icbot.local:80

### Set the Telegram bot webhook URL

    curl --request POST --header 'content-type: application/json' \
        --url https://api.telegram.org/bot{{ TELEGRAM_TOKEN }}/setWebhook \
        --data '{"url": "{{ NGROK_URL }}/{{ TELEGRAM_TOKEN }}"'

For more info, see <https://core.telegram.org/bots/api#setwebhook>

List of Commands
----------------

    busy - Generate a random "busy" message
    dilbert - Get a Dilbert comic (`/dilbert [YYYY-MM-DD | random]`)
    eightball - Consult the Magic Eightball (`/eightball <question>`)
    ping - Verify bot connectivity
    roll - Roll some dice (`/bot roll [ 2d6 | 1d10 | etc ]`)
    slap - Slap somone around a bit (`slap <name>`)
    smbc - Fetch the latest smbc comic
    xkcd - Retrieve an XKCD comic (`/xkcd [id]`)

Troubleshooting
---------------

Please report bugs to the [GitHub Issue Tracker](https://github.com/TheInnerCircleO/icbot-2/issues).

Copyright
---------

This project is licensed under the [MIT License](https://github.com/TheInnerCircleO/icbot-2/blob/master/LICENSE).
