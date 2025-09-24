<?php
include __DIR__ . '/../app/bootstrap.php';
include __DIR__ . '/../app/discord.php';
include __DIR__ . '/../app/functions.php';




//Set the redirect URL based on environment.
$redirect_url = getApplyURI();

//Verify the state to protect against CSRF.
if($_GET['state'] !== $_SESSION['state'])
{
        redirect('/');
        exit;
}

//Initialize Discord Oauth2 process.
init($redirect_url, $_ENV['DISCORD_CLIENT_ID'], $_ENV['DISCORD_CLIENT_SECRET'], $_ENV['DISCORD_BOT_TOKEN']);

get_user(); // Fetch user details.
d($_SESSION['user']);

$_SESSION['guilds'] = get_guilds();

d($_SESSION['guilds']);

//If no access token, redirect to home.
if(!$_SESSION['access_token'])
{
        redirect('/');
        exit;
}


//Adding user to guild | (guilds.join scope)
join_guild($_ENV['DISCORD_RED_LEGION_SERVERID']);

