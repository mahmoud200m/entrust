<?php

namespace Zizaco\Entrust\Contracts;

/**
 * This file is part of Entrust,
 * a Scope & permission management solution for Laravel.
 *
 * @license MIT
 */
interface EntrustScopeInterface
{
    /**
     * Many-to-Many relations with the user model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users();

}
