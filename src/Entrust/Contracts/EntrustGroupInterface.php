<?php

namespace Zizaco\Entrust\Contracts;

/**
 * This file is part of Entrust,
 * a permission management solution for Laravel.
 *
 * @license MIT
 */
interface EntrustGroupInterface
{
    /**
     * Many-to-Many relations with the user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users();

    /**
     * Many-to-Many relations with the permissions model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function perms();

}
