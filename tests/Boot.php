<?php

/**
 * Class Boot
 */
class Boot {

    public static function before($app)
    {
        $app['config']->set('database.default', 'tests');
        $app['config']->set('database.connections.tests', [
            'driver'   => 'sqlite',
            'database' => __DIR__ . '/tests.sqlite',
            'prefix'   => '',
        ]);
    }

    public static function migrate($context)
    {
        if ( ! file_exists(__DIR__ . '/tests.sqlite') )
        {
            exec('touch ' . __DIR__ . '/tests.sqlite');

            $context->artisan('migrate', [
                '--database' => 'tests',
                '--realpath' => realpath(__DIR__ . '/migrations'),
            ]);

            self::seed();
        }
    }

    protected static function seed()
    {
        Classes\User::create([
            "first_name" => "David",
            "last_name" => "Barker",
            "username" => "daveawb",
            "email" => "daveawb@hotmail.com",
            "password" => 'secret'
        ]);

        Classes\User::create([
            "first_name" => "Iva",
            "last_name" => "Stoyanova",
            "username" => "istoyanova",
            "email" => "iva@example.com",
            "password" => 'secret'
        ]);
    }
}