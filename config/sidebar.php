<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'menu' => [
        [
            'icon' => 'fa fa-th-large',
            'title' => 'Dashboard',
            'url' => '/dashboard',
	    ],
        [
            'icon' => 'fa fa-user-md',
            'title' => 'Workers',
            'url' => '/workers',
	    ],
        [
            'icon' => 'fa fa-users',
            'title' => 'Patientes',
            'url' => '/patientes',
	    ],
        [
            'icon' => 'fa fa-cogs',
            'title' => 'Settings',
            'url' => 'javascript:;',
            'caret' => true,
            'sub_menu' => [
                [
                    'url' => '/settings/roles',
                    'title' => 'Roles'
                ],
                [
                    'url' => '/settings/status',
                    'title' => 'Status'
                ],
                [
                    'url' => '/settings/maritalStatuses',
                    'title' => 'Marital Status'
                ],
                [
                    'url' => '/settings/titleJobs',
                    'title' => 'Jobs'
                ],
                [
                    'url' => '/settings/typeDocs',
                    'title' => 'Documents'
                ],
                [
                    'url' => '/settings/locations',
                    'title' => 'Locations'
                ],
                [
                    'url' => '/settings/services',
                    'title' => 'Services'
                ],
                [
                    'url' => 'javascript:;',
                    'title' => 'PDFs',
                    'caret' => true,
                    'sub_menu' => [
                        [
                            'url' => '/settings/PDFs/imagesDocuments',
                            'title' => 'Images'
                        ],
                        [
                            'url' => '/settings/PDFs/documentsEditors',
                            'title' => 'Create Documents PDFs'
                        ],
                    ],
                ],
            ]
        ],
    ]
];