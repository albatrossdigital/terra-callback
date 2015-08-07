# terra-callback

This is a simple php script that reads JSON  commands from a RabbitMQ server and executes them on the commandline. 
It is used in [https://github.com/albatrossdigital/terra_ui](Terra UI).

### Installation

Requirements:
* Install composer

```
git clone https://github.com/albatrossdigital/terra-callback.git
cd terra-callback
composer install
```

### Running
Start the script by running
```
php receiver.php
```

The script should run continuously.

#### Setting Up supervisord
`@todo: flesh this out`

A sample supervisord config might look like this:
```
[program:jms_job_queue_runner]
command=php %kernel.root_dir%/console jms-job-queue:run --env=prod --verbose
process_name=%(program_name)s
numprocs=1
directory=/tmp
autostart=true
autorestart=true
startsecs=5
startretries=10
user=www-data
redirect_stderr=false
stdout_logfile=%capistrano.shared_dir%/jms_job_queue_runner.out.log
stdout_capture_maxbytes=1MB
stderr_logfile=%capistrano.shared_dir%/jms_job_queue_runner.error.log
stderr_capture_maxbytes=1MB
```