<?php
/**
 * Created by PhpStorm.
 * User: Ehsan Hsnzd Azad
 * Date: 05/05/2019
 * Time: 12:16 PM
 */
return [

    'meta' => [
        'meta' => [
            'status',
            'message'
        ],
    ],

    'sentence' => [
        '200' => [
            'data' => [
                'sentence' => [
                    '_id',
                    'form_id',
                    'slug',
                    'translate',
                ]
            ]
        ],
        'delete' => [
            'data' => [
                'delete'
            ]
        ]
    ],

    'sentences' => [
        '200' => [
            'data' => [
                'sentences' => [
                    'current_page',
                    'data' => [[
                        '_id',
                        'form_id',
                        'slug',
                        'translate',
                        ]
                    ]
                ]
            ]
        ]
    ]

];