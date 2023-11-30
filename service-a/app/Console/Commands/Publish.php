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

    public function __construct(private readonly AMQPStreamConnection $connection)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $channel = $this->connection->channel();

        $channel->exchange_declare('laravel', 'fanout', false, true, false);
        $channel->queue_declare('laravel', false, true, false, false);

        $channel->queue_bind('laravel', 'laravel');

        $msg = new AMQPMessage($this->argument('message'));
        $channel->basic_publish($msg, 'laravel');

        $this->line(' [x] Sent: <options=bold>' . $this->argument('message') . "</>\n", 'info');

        $channel->close();
        $this->connection->close();
    }
}
