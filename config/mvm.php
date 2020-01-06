<?php

return [

    'auth' => [
        'password' => [
            'min_length'        => 12,
            'bad_passwords_url' => 'https://raw.githubusercontent.com/danielmiessler/SecLists/master/Passwords/Common-Credentials/10-million-password-list-top-1000000.txt',
        ],
        'verify_email' => [
            'token_length' => 100,
            'expiry_hours' => 24,
        ],
        'password_reset' => [
            'token_length' => 100,
            'expiry_hours' => 1,
        ],
    ],

    'pagination' => [
        'keys' => [
            'index' => 20,
        ],
        'pathways' => [
            'index' => 20,
        ],
        'projects' => [
            'index' => 20,
        ],
        'rooms' => [
            'index' => 20,
        ],
    ],

];
