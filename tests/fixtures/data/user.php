<?php

/**
* UserFixture dpends on AuthItemFixture & AuthAssigmentFixture
*/

$time = time();
return [
    'user1' => [
        'username' => 'admin',
        'email' => 'admin@gmail.com',
        'auth_key' => 'TgT_B_7gG0XiNa8BPvR28bdQzGN0py9Q',
        'password_hash' => '$2y$10$2z65MvjnT3b4qLAv3Ioz5OluYqFdyNoQpcHVYmlOxTARYmBMnE1N.',
        'flags' => 0,
        'confirmed_at' => $time,
        'created_at' => $time,
        'updated_at' => $time,
    ],
    'user2' => [
        'username' => 'approbateur1',
        'email' => 'approbateur1@example.com',
        'auth_key' => '5-JiNbe6jWCqhcjJJeBDSfd4oBlD-kTi',
        'password_hash' => '$2y$10$eYVT04LO7gKwOaYFhNIwuOATgH7f0tKk4lE0bo2GJYEmkFAifSEmK',
        'flags' => 0,
        'confirmed_at' => $time,
        'created_at' => $time,
        'updated_at' => $time,
    ],
];
