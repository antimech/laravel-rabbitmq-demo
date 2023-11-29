<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Publish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:rabbitmq-publish {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $connection = new AMQPStreamConnection(
            config('rabbitmq.host'),
            config('rabbitmq.port'),
            config('rabbitmq.user'),
            config('rabbitmq.password')
        );
        $channel = $connection->channel();

        $channel->exchange_declare('laravel', 'fanout', false, true, false);
        $channel->queue_declare('laravel', false, true, false, false);

        $channel->queue_bind('laravel', 'laravel');

        $msg = new AMQPMessage($this->argument('message'));
        $channel->basic_publish($msg, 'laravel');

        echo ' [x] Sent: ', $this->argument('message'), "\n";

        $channel->close();
        $connection->close();
    }
}
