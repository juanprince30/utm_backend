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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    // IA de verification de la description du local (ex: FastAPI / LLM).
    // Laissez vide pour utiliser l'analyse heuristique locale.
    'description_ai' => [
        'url' => env('DESCRIPTION_AI_URL'),
    ],

    // IA chatbot de recherche de produits/services (FastAPI -> base de donnees).
    'chatbot_ai' => [
        'url' => env('CHATBOT_AI_URL'),
        'key' => env('CHATBOT_AI_KEY'),
    ],

    // IA de scoring (1 a 5 etoiles) des commerces/services via les commentaires.
    'scoring_ai' => [
        'url' => env('SCORING_AI_URL'),
        'key' => env('SCORING_AI_KEY'),
    ],

];
