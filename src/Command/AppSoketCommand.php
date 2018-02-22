<?php

namespace App\Command;

use App\Service\Socket\Socket;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class AppSoketCommand extends Command
{
    protected static $defaultName = 'app:socket';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('socket_command', InputArgument::REQUIRED, 'Socket command')
//            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $command = $input->getArgument('socket_command');

        if ($command == 'run') {
            $io->success('Socket runed!');
            $output->writeln([
                'Socket socket',// A line
                '============',// Another line
                'Starting chat, open your browser.',// Empty line
            ]);

            $server = IoServer::factory(
                new HttpServer(
                    new WsServer(
                        new Socket()
                    )
                ),
                2346
            );
            $server->run();
        }
    }
}
