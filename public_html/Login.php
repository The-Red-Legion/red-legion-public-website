<?php
include __DIR__ . '/../app/bootstrap.php';
include __DIR__ . '/../app/discord.php';
include __DIR__ . '/../app/functions.php';

//Set the redirect URL based on environment.
switch($_ENV['APP_ENV'])
{
    case 'prod':
        $redirect_url = $_ENV['DISCORD_APPLY_REDIRECT_PROD'];
        break;
    case 'dev':
        $redirect_url = $_ENV['DISCORD_APPLY_REDIRECT_DEV'];
        break;
    case 'local':
        $redirect_url = $_ENV['DISCORD_APPLY_REDIRECT_LOCAL'];
        break;
    default:
        die('Invalid APP_ENV value. Must be one of: local, dev, prod.');
}

//Verify the state to protect against CSRF.
if(!$_SESSION['access_token'] || $_GET['state'] !== $_SESSION['state'])
{
        redirect('/');
        exit;
}


d($_GET);
//Initialize Discord Oauth2 process.
init($redirect_url, $_ENV['DISCORD_CLIENT_ID'], $_ENV['DISCORD_CLIENT_SECRET'], $_ENV['DISCORD_BOT_TOKEN']);

get_user(); // Fetch user details.
d($_SESSION['user']);

$_SESSION['guilds'] = get_guilds();

d($_SESSION['guilds']);


