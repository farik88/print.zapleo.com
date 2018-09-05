<?php

return [
    'class' => 'yii\swiftmailer\Mailer',
    'useFileTransport' => false,
    'transport' => [
        'class' => 'Swift_SmtpTransport',
        'host' => 'smtp.gmail.com',
        'username' => 'catomik.test.mail@gmail.com',
        'password' => 'catomik-test',
        'port' => '587',
        'encryption' => 'tls',
    ],
];