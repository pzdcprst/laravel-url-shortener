<?php

return [

    'base_url' => rtrim(env('SHORT_URL_BASE', env('APP_URL', 'http://localhost')), '/'),

    'short_code_length' => (int) env('SHORT_CODE_LENGTH', 7),

    'short_code_min_length' => 6,

    'short_code_max_length' => 8,

];
