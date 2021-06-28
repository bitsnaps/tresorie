<?php

return [
    'bsDependencyEnabled' => false, // this will not load Bootstrap CSS and JS for all Krajee extensions 
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'noreply@example.com',
    'senderName' => 'Example.com mailer',
    'maskMoneyOptions' => [
        'prefix' => 'Dzd ',
        'suffix' => '',
        'affixesStay' => false,
        'thousands' => '',
        'decimal' => '.',
        'precision' => 2, 
        'allowZero' => false,
        'allowNegative' => false,
    ]
    
];
