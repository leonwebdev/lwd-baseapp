<?php

return array(
    'db' => array(
        'driver' => 'pdo',
        'dsn' => 'mysql:host=localhost;dbname=lwd;',
        'driver_options' => array(
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    'service_manager' => array(
        'factories' => array(
            //'Zend\Db\Adapter\Adapter' => function ($sm) use ($dbParams) {
            'Zend\Db\Adapter\Adapter' => function ($sm) {
                // Récupérer le tableau de configuration
                $config = $sm->get('config');

                $adapter = new BjyProfiler\Db\Adapter\ProfilingAdapter(array(
                    'driver' => $config['db']['driver'],
                    'dsn' => $config['db']['dsn'],
                    'driver_options' => $config['db']['driver_options'],
//                    'database'  => $dbParams['database'],
                    'username' => $config['db']['username'],
                    'password' => $config['db']['password'],
//                    'hostname'  => $dbParams['hostname'],
                ));

                $adapter->setProfiler(new BjyProfiler\Db\Profiler\Profiler);
                $adapter->injectProfilingStatementPrototype();
                return $adapter;
            },
        ),
    ),
);

