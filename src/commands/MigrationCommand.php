<?php

namespace Zizaco\Entrust;

/*
 * This file is part of Entrust,
 * a role & permission management solution for Laravel.
 *
 * @license MIT
 * @package Zizaco\Entrust
 */

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Config\Repository as Config;

class MigrationCommand extends Command
{
    /**
     * Configuaration.
     *
     * @var [type]
     */
    protected $config;

    /**
     * Entrust configuration & options.
     *
     * @var [type]
     */
    protected $options;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'entrust:migration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates a migration following the Entrust specifications.';

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->options = $config->get('entrust');
        parent::__construct();
    }

    /**
     * Get authentication provider.
     *
     * @return array
     */
    public function getAuthProvider()
    {
        $guards = $this->config->get('auth.guards');
        if (!$guards) {
            throw new Exception('Guard(s) not found');
        }
        $guard = $this->choice('Which guard would you like to use?', array_keys($guards), 0);
        $guard = $this->config->get("auth.guards.{$guard}");
        if (!isset($guard['provider'])) {
            throw new Exception('Provider not found');
        }
        $provider = $guard['provider'];

        return $this->config->get("auth.providers.{$provider}");
    }

    /**
     * Execute the console command.
     */
    public function fire()
    {
        try {
            $this->options['provider'] = $this->getAuthProvider();
            $this->laravel->view->addNamespace('entrust', substr(__DIR__, 0, -8).'views');
            print_r($this->options);

            if ($this->confirm('Proceed with the migration creation?', 'yes')) {
                $this->line('');
                $this->info('Creating migration...');
                $path = base_path('/database/migrations').'/'.date('Y_m_d_His').'_entrust_setup_tables.php';
                if ($this->createMigration($path)) {
                    return $this->info('Migration successfully created!');
                }

                return $this->error("Couldn't create migration.");
            }
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }

    /**
     * Create the migration.
     *
     * @param string $name
     *
     * @return bool
     */
    protected function createMigration($migrationFile)
    {
        $provider = $this->options['provider'];

        $driver = $provider['driver'];

        if ($driver === 'eloquent' && isset($provider['model'])) {
            $model = with(new $provider['model']());
            $usersTable = [
                'name' => $model->getTable(),
                'pkey' => $model->getKeyName(),
            ];
        } elseif ($driver === 'database' && isset($provider['table'])) {
            $usersTable = [
                'name' => $provider['table'],
                'pkey' => $this->anticipate('What is your primary key?', ['id']),
            ];
        } else {
            return false;
        }

        $usersTable['singular'] = str_singular($usersTable['name']);
        $usersTable['fkey'] = $usersTable['singular'].'_id';

        $roleUserFKeys = array(
            $usersTable,
            [
                'name' => $this->options['roles_table'],
                'pkey' => 'id',
                'fkey' => 'role_id',
                'singular' => 'role',
            ],
        );

        $this->options['roleUserPivotTable'] = array(
            'name' => implode('_', array_pluck($roleUserFKeys, 'singular')),
            'fkeys' => $roleUserFKeys,
        );

        $output = $this->laravel->view->make('entrust::generators.migration')->with($this->options)->render();

        if (!file_exists($migrationFile) && $fs = fopen($migrationFile, 'x')) {
            fwrite($fs, $output);
            fclose($fs);

            return true;
        }

        return false;
    }
}
