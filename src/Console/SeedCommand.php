<?php

declare(strict_types=1);

namespace App\Console;

use Faker\Factory;
use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Yiisoft\Db\Connection\ConnectionInterface;
use Yiisoft\Security\PasswordHasher;
use Yiisoft\Yii\Console\ExitCode;

#[AsCommand(
    name: 'seed',
    description: 'Run to seed the DB',
)]
final class SeedCommand extends Command
{
    public function __construct(
        private readonly ContainerInterface $container,
    )
    {
        parent::__construct();
    }

    protected function execute(
        InputInterface  $input,
        OutputInterface $output
    ): int
    {

        $faker = Factory::create();

        $db = $this->container->get(ConnectionInterface::class);

        for ($i = 0; $i < 10; $i++) {
            $password = strtoupper($faker->bothify('?#?#?#?#'));
            // Other options for random strings:
            // lexify(), numerify(), regexify()

            $db->createCommand()
                ->insert('user', [
                    'name' => $faker->firstName(),
                    'surname' => $faker->lastName(),
                    'username' => $faker->userName(),
                    'phone' => $faker->phoneNumber(),
                    'email' => $faker->email(),
                    'email_verified_at' => $faker->dateTimeBetween('-10 days', 'now', 'Europe/Prague')->format('Y-m-d H:i:s'),
                    'pwd_default' => $password,
                    'pwd_hash' => (new PasswordHasher())->hash($password),
                ])
                ->execute();
        }

        $output->writeln('Seeding DONE.');

        return ExitCode::OK;
    }
}
