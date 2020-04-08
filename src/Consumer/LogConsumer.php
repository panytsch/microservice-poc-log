<?php

namespace App\Consumer;


use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class LogConsumer implements ConsumerInterface
{
    /**
     * @param AMQPMessage $msg
     * @return mixed|void
     * @throws \Exception
     */
    public function execute(AMQPMessage $msg)
    {
        $log = new Logger('log');
        $log->pushHandler(new StreamHandler(__DIR__.'/../../var/log/rabbitmq.log', Logger::DEBUG));

        $log->log(Logger::ERROR, $msg->body);
    }
}