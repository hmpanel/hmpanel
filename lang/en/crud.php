<?php

return [
    'common' => [
        'actions' => 'Actions',
        'create' => 'Create',
        'edit' => 'Edit',
        'update' => 'Update',
        'new' => 'New',
        'cancel' => 'Cancel',
        'attach' => 'Attach',
        'detach' => 'Detach',
        'save' => 'Save',
        'delete' => 'Delete',
        'delete_selected' => 'Delete selected',
        'search' => 'Search...',
        'back' => 'Back to Index',
        'are_you_sure' => 'Are you sure?',
        'no_items_found' => 'No items found',
        'created' => 'Successfully created',
        'saved' => 'Saved successfully',
        'removed' => 'Successfully removed',
    ],

    'web_apps' => [
        'name' => 'Web Apps',
        'index_title' => 'WebApps List',
        'new_title' => 'New Web app',
        'create_title' => 'Create WebApp',
        'edit_title' => 'Edit WebApp',
        'show_title' => 'Show WebApp',
        'inputs' => [
            'name' => 'Name',
            'path' => 'Path',
            'domain_id' => 'Domain',
        ],
    ],

    'domains' => [
        'name' => 'Domains',
        'index_title' => 'Domains List',
        'new_title' => 'New Domain',
        'create_title' => 'Create Domain',
        'edit_title' => 'Edit Domain',
        'show_title' => 'Show Domain',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'databases' => [
        'name' => 'Databases',
        'index_title' => 'Databases List',
        'new_title' => 'New Database',
        'create_title' => 'Create Database',
        'edit_title' => 'Edit Database',
        'show_title' => 'Show Database',
        'inputs' => [
            'name' => 'Name',
            'username' => 'Username',
            'password' => 'Password',
        ],
    ],

    'email_accounts' => [
        'name' => 'Email Accounts',
        'index_title' => 'EmailAccounts List',
        'new_title' => 'New Email account',
        'create_title' => 'Create EmailAccount',
        'edit_title' => 'Edit EmailAccount',
        'show_title' => 'Show EmailAccount',
        'inputs' => [
            'email' => 'Email',
            'password' => 'Password',
            'web_app_id' => 'Web App',
        ],
    ],

    'ftp_accounts' => [
        'name' => 'Ftp Accounts',
        'index_title' => 'FtpAccounts List',
        'new_title' => 'New Ftp account',
        'create_title' => 'Create FtpAccount',
        'edit_title' => 'Edit FtpAccount',
        'show_title' => 'Show FtpAccount',
        'inputs' => [
            'username' => 'Username',
            'password' => 'Password',
            'web_app_id' => 'Web App',
        ],
    ],

    'ssh_accesses' => [
        'name' => 'Ssh Accesses',
        'index_title' => 'SshAccesses List',
        'new_title' => 'New Ssh access',
        'create_title' => 'Create SshAccess',
        'edit_title' => 'Edit SshAccess',
        'show_title' => 'Show SshAccess',
        'inputs' => [
            'username' => 'Username',
            'password' => 'Password',
            'web_app_id' => 'Web App',
        ],
    ],

    'users' => [
        'name' => 'Users',
        'index_title' => 'Users List',
        'new_title' => 'New User',
        'create_title' => 'Create User',
        'edit_title' => 'Edit User',
        'show_title' => 'Show User',
        'inputs' => [
            'name' => 'Name',
            'email' => 'Email',
            'password' => 'Password',
        ],
    ],

    'roles' => [
        'name' => 'Roles',
        'index_title' => 'Roles List',
        'create_title' => 'Create Role',
        'edit_title' => 'Edit Role',
        'show_title' => 'Show Role',
        'inputs' => [
            'name' => 'Name',
        ],
    ],

    'permissions' => [
        'name' => 'Permissions',
        'index_title' => 'Permissions List',
        'create_title' => 'Create Permission',
        'edit_title' => 'Edit Permission',
        'show_title' => 'Show Permission',
        'inputs' => [
            'name' => 'Name',
        ],
    ],
];
