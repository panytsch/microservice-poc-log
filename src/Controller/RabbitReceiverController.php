<?php


namespace App\Controller;



namespace App\Controller;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class RabbitReceiverController extends AbstractController
{
    public function send()
    {
        $connection = new AMQPStreamConnection('rabbitmq', 5672, 'rabbitmq', 'rabbitmq');
        $channel = $connection->channel();

        $channel->queue_declare('log', false, true, false, false);

        $msg = new AMQPMessage('Hello World!',
            ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );

        $channel->basic_publish($msg, '', 'log');

        $channel->close();
        $connection->close();

        return new Response('Sent message');
    }

    public function receive()
    {

        return new Response(' ok');
    }
}