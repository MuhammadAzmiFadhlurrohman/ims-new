<?php

return [
    'api_url' => env('WA_API_URL', 'https://api.whatsapp-gateway.com/send'),
    'api_key' => env('WA_API_KEY', ''),
    'sender_phone' => env('WA_SENDER_PHONE', ''),
];
