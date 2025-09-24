<?php
include __DIR__ . '/../app/bootstrap.php';
include __DIR__ . '/../app/discord.php';
include __DIR__ . '/../app/functions.php';


function testBotToken(): array {
    // pull from either source and TRIM to kill CRLF/whitespace
    $raw = $_ENV['DISCORD_BOT_TOKEN'] ?? getenv('DISCORD_BOT_TOKEN') ?? '';
    $token = trim((string)$raw);

    // quick debug so you can see if something is off, without leaking the full token
    $preview = ($token !== '') ? (substr($token, 0, 6) . '...' . substr($token, -6)) : '(empty)';
    $len     = strlen($token);
    error_log("BOT TOKEN len={$len} preview={$preview}");

    if ($token === '') {
        return ['ok' => false, 'why' => 'No token loaded. Is .env in the right folder and loaded here?'];
    }

    $ch = curl_init('https://discord.com/api/v10/users/@me');
    curl_setopt_array($ch, [
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: Bot ' . $token,
            'Accept: application/json',
            // Optional but tidy:
            'User-Agent: YourAppName (yourdomain, 1.0)'
        ],
    ]);
    $resp = curl_exec($ch);
    $http = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $err  = curl_error($ch);
    curl_close($ch);

    return ['ok' => $http === 200, 'http' => $http, 'body' => json_decode($resp, true) ?: $resp, 'curl_error' => $err ?: null];
}

header('Content-Type: application/json');
echo json_encode(testBotToken(), JSON_PRETTY_PRINT);
exit;








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

