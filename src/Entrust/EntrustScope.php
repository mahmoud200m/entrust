<?php

namespace Zizaco\Entrust;

/*
 * This file is part of Entrust,
 * a Scope & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

use Zizaco\Entrust\Contracts\EntrustScopeInterface;
use Zizaco\Entrust\Traits\EntrustScopeTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class EntrustScope extends Model implements EntrustScopeInterface
{
    use EntrustScopeTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table;

    /**
     * Creates a new instance of the model.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = Config::get('entrust.scopes_table');
    }
}
