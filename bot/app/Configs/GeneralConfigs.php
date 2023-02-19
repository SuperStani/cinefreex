<?php

namespace superbot\App\Configs;

class GeneralConfigs
{
    public static string $domain = "https://xohosting.it";
    public static string $webapp = "https://netfluzmax-webapp.xohosting.it";
    public static string $bot_token = "5809907151:AAHSajl7p5xgu5Q7J_AVuk6J2bP4ezK6ltY";
    public static string $bot_owner = "";

    public static int $episodes_channel = -1001660241298;

    public static string $api_url = "https://xohosting.it/tmdbapi/";
    public static string $photo_path = "https://xohosting.it/netfluzmax/photoshop/?poster=";
    public static string $photoshop_uri = "https://xohosting.it/netfluzmax/photoshop/";
    public static string $tmdb_photo_path = "https://image.tmdb.org/t/p/original";
    public static string $episodes_photo_path = "https://xohosting.it/netfluzmax/img/episodes";
    public static array $admins = [
        406343901, //SuperStani
        170172016,
        545549685
    ];

}

interface MovieCategory {
    public const TV_SERIES = 'TV_SERIES';
    public const FILM = 'FILM';
}
