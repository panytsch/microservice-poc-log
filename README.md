# microservice-poc-log


1. <code>cd .docker</code> <br>

2. Run <code>docker-compose up -d</code>

3. Go to your Symfony app and install Symfony pkgs for RabbitMQ <br>
<code>composer require php-amqplib/rabbitmq-bundle</code>
4. Define the RabbitMQ connection into the config.yml
    
    ## app/config/config.yml
        old_sound_rabbit_mq:
            connections:
                logging:
                    host: '%rabbitmq_host%'
                    user: '%rabbitmq_user%'
                    password: '%rabbitmq_password%'
                    vhost: '%rabbitmq_logging_vhost%'
        
5. Define the credentials for the RabbitMQ connection into parameters.yml that described in config.yml
    ## app/config/parameters.yml
        parameters:
         ...
         rabbitmq_host: <your_rabbitmq_host_address>
         rabbitmq_user: <your_rabbitmq_user>
         rabbitmq_password: <your_rabbitmq_password>
         rabbitmq_logging_vhost: logging
     
     
6. Define a new service for a RabbitMQ channel to be used by monolog.
    
    # app/config/services.yml
        monolog_mq_channel:
            class: PhpAmqpLib\Channel\AMQPChannel
            arguments:
              - "@old_sound_rabbit_mq.connection.logging
      
7. Define a monolog handler in the Symfony configuration file like the following. For the demostration, we will use config_dev.yml You can define handlers specifically for each environment.
              
    
    # app/config/config_dev.yml
        monolog:
            handlers:
                console:
                    type: amqp
                    exchange: monolog_mq_channel
                    exchange_name: logging
                    level: warning
    
Now the application is ready to send the logs to RabbitMQ. 
<br><br>By default rabbitmq queue - MyAppLogginQueue (You can change it in .env)
    
http://localhost:5601 - Kibana
http://localhost:15672 - RabbitMQ
