<?php

return [
    'default' => 'default',

    'documentations' => [
        'default' => [
            'api' => [
                'title' => 'Pokemon Card API',
            ],

            'routes' => [
                'api' => 'api/documentation',
            ],

            'paths' => [
                'use_absolute_path' => true,

                'swagger_ui_assets_path' => 'vendor/swagger-api/swagger-ui/dist/',

                'docs_json' => 'api-docs.json',
                'docs_yaml' => 'api-docs.yaml',

                'format_to_use_for_docs' => 'json',

                // 🔥 INI PENTING BANGET
                'annotations' => [
                    app_path(), // scan seluruh app
                ],
            ],
        ],
    ],

    'defaults' => [
        'routes' => [
            'docs' => 'docs',
            'oauth2_callback' => 'api/oauth2-callback',

            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],

            'group_options' => [],
        ],

        'paths' => [
            'docs' => storage_path('api-docs'),
            'views' => resource_path('views/vendor/l5-swagger'),
            'base' => null,
            'excludes' => [],
        ],

        // 🔥 FORCE SCAN SEMUA FILE PHP
        'scanOptions' => [
            'pattern' => '*.php',
            'analyser' => new \OpenApi\Analysers\ReflectionAnalyser([
                new \OpenApi\Analysers\AttributeAnnotationFactory(),
                new \OpenApi\Analysers\DocBlockAnnotationFactory(),
            ]),
        ],

        'securityDefinitions' => [
            'securitySchemes' => [],
            'security' => [],
        ],

        'generate_always' => true,
        'generate_yaml_copy' => false,
        'proxy' => false,
        'additional_config_url' => null,
        'operations_sort' => null,
        'validator_url' => null,

        'ui' => [
            'display' => [
                'dark_mode' => true,
                'doc_expansion' => 'none',
                'filter' => true,
            ],

            'authorization' => [
                'persist_authorization' => false,
                'oauth2' => [
                    'use_pkce_with_authorization_code_grant' => false,
                ],
            ],
        ],

        'constants' => [
            'L5_SWAGGER_CONST_HOST' => 'http://127.0.0.1:8000',
        ],
    ],
];