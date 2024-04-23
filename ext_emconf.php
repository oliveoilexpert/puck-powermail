<?php

$EM_CONF[$_EXTKEY] = [
    'title' => 'Puck Powermail Extension',
    'description' => 'Custom configuration for the powermail extension, including xclasses and flexform changes.',
    'version' => '1.0.0',
    'state' => 'stable',
    'author' => 'Amadeus Kiener',
    'author_email' => 'amd.kiener@gmail.com',
    'constraints' => [
        'depends' => [
            'typo3' => '12.4.0-12.4.99',
            'powermail' => '^12',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];