<?php

return [
	'mode'                  => 'utf-8',
	'format'                => 'A4',
	'author'                => '',
	'subject'               => '',
	'keywords'              => '',
	'creator'               => 'Laravel Pdf',
	'display_mode'          => 'fullpage',
	'tempDir'               => base_path('../temp/'),
    'font_path' => base_path('public/fonts/'),
    'font_data' => [
        'googlesans' => [
            'R'  => 'GoogleSans-Regular.ttf',    // regular font
            'B'  => 'GoogleSans-Bold.ttf',       // optional: bold font
            'I'  => 'GoogleSans-Italic.ttf',     // optional: italic font
            'BI' => 'GoogleSans-Bold-Italic.ttf' // optional: bold-italic font
            //'useOTL' => 0xFF,    // required for complicated langs like Persian, Arabic and Chinese
            //'useKashida' => 75,  // required for complicated langs like Persian, Arabic and Chinese
        ]
        // ...add as many as you want.
    ]
];
