<?php

/**
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Entrust Scope Model
    |--------------------------------------------------------------------------
    |
    | This is the Scope model used by Entrust to create correct relations.  Update
    | the scope if it is in a different namespace.
    |
    */
    'scope' => 'Livit\Build\Scope',

    /*
    |--------------------------------------------------------------------------
    | Entrust Scopes Table
    |--------------------------------------------------------------------------
    |
    | This is the scopes table used by Entrust to save scopes to the database.
    |
    */
    'scopes_table' => 'scopes',

    /*
    |--------------------------------------------------------------------------
    | Entrust scope_user Table
    |--------------------------------------------------------------------------
    |
    | This is the scopes table used by Entrust to save scopes to the database.
    |
    */
    'scope_user_table' => 'scope_user',

    /*
    |--------------------------------------------------------------------------
    | Entrust Role Model
    |--------------------------------------------------------------------------
    |
    | This is the Role model used by Entrust to create correct relations.  Update
    | the role if it is in a different namespace.
    |
    */
    'role' => 'Livit\Build\Role',

    /*
    |--------------------------------------------------------------------------
    | Entrust Roles Table
    |--------------------------------------------------------------------------
    |
    | This is the roles table used by Entrust to save roles to the database.
    |
    */
    'roles_table' => 'roles',

    /*
    |--------------------------------------------------------------------------
    | Entrust Permission Model
    |--------------------------------------------------------------------------
    |
    | This is the Permission model used by Entrust to create correct relations.
    | Update the permission if it is in a different namespace.
    |
    */
    'permission' => 'Livit\Build\Permission',

    /*
    |--------------------------------------------------------------------------
    | Entrust Permissions Table
    |--------------------------------------------------------------------------
    |
    | This is the permissions table used by Entrust to save permissions to the
    | database.
    |
    */
    'permissions_table' => 'permissions',

    /*
    |--------------------------------------------------------------------------
    | Entrust permission_role Table
    |--------------------------------------------------------------------------
    |
    | This is the permission_role table used by Entrust to save relationship
    | between permissions and roles to the database.
    |
    */
    'permission_role_table' => 'permission_role',

    /*
    |--------------------------------------------------------------------------
    | Entrust permission_scope Table
    |--------------------------------------------------------------------------
    |
    | This is the permission_scope table used by Entrust to save relationship
    | between permissions and scopes to the database.
    |
    */
    'permission_scope_table' => 'permission_scope',

];
