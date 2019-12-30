<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain'   => env('MAILGUN_DOMAIN'),
        'secret'   => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key'    => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'discord' => [
        'client_id'     => env('DISCORD_KEY'),
        'client_secret' => env('DISCORD_SECRET'),
        'redirect'      => env('DISCORD_REDIRECT_URI'),
    ],

    'github' => [
        'client_id'     => env('GITHUB_KEY'),
        'client_secret' => env('GITHUB_SECRET'),
        'redirect'      => env('GITHUB_REDIRECT_URI'),
    ],

    'google' => [
        'client_id'     => env('GOOGLE_CLIENT_ID'),
        'client_secret' => env('GOOGLE_CLIENT_SECRET'),
        'redirect'      => env('GOOGLE_CALLBACK_URL'),
    ],

    'reddit' => [
        'client_id'     => env('REDDIT_KEY'),
        'client_secret' => env('REDDIT_SECRET'),
        'redirect'      => env('REDDIT_REDIRECT_URI'),
    ],

    'slack' => [
        'client_id'     => env('SLACK_KEY'),
        'client_secret' => env('SLACK_SECRET'),
        'redirect'      => env('SLACK_REDIRECT_URI'),
    ],

    'steam' => [
        'client_id'     => env('STEAM_KEY'),
        'client_secret' => env('STEAM_SECRET'),
        'redirect'      => env('STEAM_REDIRECT_URI'),
    ],

    'twitch' => [
        'client_id'     => env('TWITCH_KEY'),
        'client_secret' => env('TWITCH_SECRET'),
        'redirect'      => env('TWITCH_REDIRECT_URI'),
    ],

    'twitter' => [
        'client_id'     => env('TWITTER_KEY'),
        'client_secret' => env('TWITTER_SECRET'),
        'redirect'      => env('TWITTER_REDIRECT_URI'),
    ],
];
