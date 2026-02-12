<?php

// config/onesignal.php

return [

    /*
    |--------------------------------------------------------------------------
    | OneSignal App ID
    |--------------------------------------------------------------------------
    | Encuéntralo en: OneSignal Dashboard → Settings → Keys & IDs
    */
    'app_id' => env('ONESIGNAL_APP_ID', ''),

    /*
    |--------------------------------------------------------------------------
    | OneSignal REST API Key
    |--------------------------------------------------------------------------
    | Encuéntrala en: OneSignal Dashboard → Settings → Keys & IDs
    | ⚠️  Nunca expongas esta clave en el frontend.
    */
    'api_key' => env('ONESIGNAL_API_KEY', ''),

];
