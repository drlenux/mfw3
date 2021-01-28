<?php

namespace src\console;

use core\Console;
use Medoo\Medoo;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CreateDB extends Console
{
    protected static $defaultName = 'create:db';

    public function exec(): bool
    {
        /** @var Medoo $medoo */
        $medoo = $this->container->get(Medoo::class);

        $this->createAuth($medoo)
            ->createPage($medoo);

        return true;
    }

    private function createPage(Medoo $medoo): static
    {
        $medoo->create('page', [
            'id' => [
                "INT",
                "NOT NULL",
                "PRIMARY KEY"
            ],
            'name' => ['varchar(255)'],
        ]);

        return $this;
    }

    private function createAuth(Medoo $medoo): static
    {
        $medoo->create('users', [
            'id' => [
                "INT",
                "NOT NULL",
                "PRIMARY KEY"
            ],
            'login' => ['varchar(255)'],
            'password' => ['varchar(255)'],
            'token' => ['varchar(255)'],
        ]);
        $medoo->create('auth_rules', [
            'id' => [
                "INT",
                "NOT NULL",
                "PRIMARY KEY"
            ],
            'rule' => ['varchar(255)']
        ]);
        $medoo->create('auth_rules_assign', [
            'id' => [
                "INT",
                "NOT NULL",
                "PRIMARY KEY"
            ],
            'user_id' => ['INT'],
            'rule_id' => ['INT']
        ]);

        return $this;
    }
}
