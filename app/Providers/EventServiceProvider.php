<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use SocialiteProviders\Discord\DiscordExtendSocialite;
use SocialiteProviders\GitHub\GitHubExtendSocialite;
use SocialiteProviders\Google\GoogleExtendSocialite;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Reddit\RedditExtendSocialite;
use SocialiteProviders\Slack\SlackExtendSocialite;
use SocialiteProviders\Steam\SteamExtendSocialite;
use SocialiteProviders\Twitch\TwitchExtendSocialite;
use SocialiteProviders\Twitter\TwitterExtendSocialite;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
        ],
        SocialiteWasCalled::class => [
            // DiscordExtendSocialite::class,
            // GitHubExtendSocialite::class,
            // GoogleExtendSocialite::class,
            // RedditExtendSocialite::class,
            // SlackExtendSocialite::class,
            // SteamExtendSocialite::class,
            // TwitchExtendSocialite::class,
            // TwitterExtendSocialite::class,
        ],
    ];

    public function boot()
    {
        parent::boot();

        //
    }
}
