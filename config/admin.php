<?php

return [

    'side_nav' => [
        [
            'label' => 'Dashboard',
            'icon' => 'dashboard',
            'route' => 'admin.dashboard'
        ],
        [
            'label' => 'Users',
            'icon' => 'people',
            'route' => 'admin.user.index'
        ],
        [
            'label' => 'Sellers',
            'icon' => 'people',
            'route' => 'admin.seller.index'
        ],
        [
            'label' => 'Saved Meters',
            'icon' => 'bolt',
            'route' => 'admin.savedmeter.index'

        ],
                [
            'label' => 'Saved DSTV Recharge Cards',
            'icon' => 'bolt',
            'route' => 'admin.saveddstvrechargecard.index'

        ],
        // [
        //     'label' => 'EDSA Transactions',
        //     'icon' => 'money',
        //     'route' => 'admin.edsatransaction.index'

        // ],
        [
            'label' => 'Transactions',
            'icon' => 'money',
            'role' => 'admin',
            'children' => [
                [
                    'label' => 'EDSA',
                    'route' => 'admin.edsatransaction.index'
                ],
                [
                    'label' => 'DSTV',
                    'route' => 'admin.dstvtransaction.index'
                ],
                [
                    'label' => 'STAR TIMES',
                    'route' => 'admin.startransaction.index'
                ]
            ]
        ],
        [
            'label' => 'Advertisement Management',
            'icon' => 'extension',
            'route' => 'admin.ad-detail.index',

        ],
        [
            'label' => 'Attributes',
            'icon' => 'people',
            'role' => 'admin',
            'children' => [
                [
                    'label' => 'Attribute Sets',
                    'route' => 'admin.attribute-set.index'
                ],
                [
                    'label' => 'Attribute Group',
                    'route' => 'admin.attribute-group.index'
                ],
                [
                    'label' => 'Attributes',
                    'route' => 'admin.attribute.index'
                ]
            ]
        ],
        [
            'label' => 'Address',
            'icon' => 'space_bar',
            'route' => 'admin.address-area.index',

        ],
        [
            'label' => 'System Users',
            'icon' => 'accessible',
            'role' => 'admin',
            'children' => [
                [
                    'label' => 'List',
                    'route' => 'admin.system-user.list',
                ],
                [
                    'label' => 'Create',
                    'route' => 'admin.system-user.create',
                ],

            ]
        ],
        [
            'label' => 'Places',
            'icon' => 'place',
            'route' => 'admin.place.index',

        ],
        [
            'label' => 'Places Category',
            'icon' => 'spa',
            'route' => 'admin.place-category.index',

        ],
        [
            'label' => 'Autos',
            'icon' => 'place',
            'route' => 'admin.auto.index',

        ],
        [
            'label' => 'Autos Category',
            'icon' => 'spa',
            'route' => 'admin.auto-category.index',

        ],
        [
            'label' => 'Real Estate',
            'icon' => 'place',
            'route' => 'admin.real-estate.index',

        ],
        [
            'label' => 'Real Estate Category',
            'icon' => 'spa',
            'route' => 'admin.real-estate-category.index',

        ],
        [
            'label' => 'Fun & Games',
            'icon' => 'extension',
            'route' => 'admin.question.index',

        ],
        [
            'label' => 'Fun & Games Category',
            'icon' => 'extension',
            'route' => 'admin.knowledgebase-category.index',

        ],
        [
            'label' => 'Product',
            'icon' => 'shopping_basket',
            'route' => 'admin.product.index',

        ],
        [
            'label' => 'Product Category',
            'icon' => 'shopping_basket',
            'route' => 'admin.product-category.index',

        ],

        [
            'label' => 'System Settings',
            'icon' => 'settings',
            'children' => [
                [
                    'label' => 'Sponsor text',
                    'route' => 'admin.config.sponsor'
                ],
                [
                    'label' => 'TAX',
                    'route' => 'admin.config.tax'
                ],
            ],
        ],
        [
            'label' => 'Orders',
            'icon' => 'reorder',
            'route' => 'admin.order.index',
        ],
        [
            'label' => 'Reporting',
            'icon' => 'settings',
            'children' => [
                [
                    'label' => 'Orders Report',
                    'route' => 'admin.order-report.index'
                ],
                [
                    'label' => 'Digital Addresses Report',
                    'route' => 'admin.digitl-address.index'
                ],
                [
                    'label' => 'Autos Report',
                    'route' => 'admin.auto-report.index'
                ],
                [
                    'label' => 'Real Estate Report',
                    'route' => 'admin.real-estate-report.index'
                ],
            ],
        ],

    ]
];
