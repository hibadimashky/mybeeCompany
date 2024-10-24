<?php
return [
    [
        'name' => 'dashboard',
        'url' => 'dashboard',
        'icon' => 'fas fa-home',
        'permission' => '',
        'subMenu' => []
    ],
    [
        'name' => 'product_module',
        'url' => 'category',
        'icon' => 'fas fa-shopping-cart',
        'permission' => '',
        'subMenu' => [
            [

                'name' => 'products',
                'url' => 'category',
                'permission' => '' ,

            ],
            [
                'name' => 'modifiers',
                'url' => 'modifier',
                'permission' => '',

            ],
            [
                'name' => 'attribute',
                'url' => 'attribute',
                'permission' => '',

            ],
            [
                'name' => 'customMenu',
                'url' => 'customMenu',
                'permission' => '',

            ],
        ]
    ],
    [
        'name' => 'accounting_module',
        'url' => 'dashboard',
        'icon' => 'fas fa-calculator',
        'permission' => '',
        'subMenu' => [
            [
                'name' => 'accounting_dashboard',
                'url' => 'accounting-dashboard',
                'permission' => '',
            ],
            [
                'name' => 'chart_of_accounts',
                'url' => 'tree-of-accounts',
                'permission' => '',
            ],
            [
                'name' => 'journalEntry',
                'url' => 'journal-entry-index',
                'permission' => '',
            ],
            [
                'name' => 'costCenter',
                'url' => 'cost-center-index',
                'permission' => '',
            ],

        ]
    ],

    [
        'name' => 'establishments_module',
        'url' => 'dashboard',
        'permission' => '',
        'icon' => 'fas fa-building',
        'subMenu' => []
    ],


    [

        'name' => 'crm',
        'url' => '/',
        'icon' => 'fas fa-cogs',
        'permission' => '',
        'subMenu' => []
    ],
    [

        'name' => 'employees_management_module',
        'url' => '',
        'icon' => 'fas fa-id-card',
        'permission' => '',
        'subMenu' => [
            [
                'name' => 'employees',
                'url' => 'employee',
                'permission' => '',
            ],
            [
                'name' => 'pos_roles',
                'url' => 'pos-role',
                'permission' => '',
            ],
            [
                'name' => 'dashboard_roles',
                'url' => 'dashboard-role',
                'permission' => '',
            ],
            [
                'name' => 'employees_working_hours',
                'url' => 'timecard',
                'permission' => '',
            ],
        ]
    ],
    [
        'name' => 'reports_module',
        'url' => '/',
        'icon' => 'fas fa-bar-chart',
        'permission' => '',
        'subMenu' => []
    ],
];