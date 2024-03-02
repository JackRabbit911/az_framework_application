<?php

namespace App\Http\Controller;


use Sys\Controller\WebController;
use Sys\Create\ModelCreateDB;
use Az\Route\Route;
use Symfony\Component\Yaml\Yaml;
use Sys\Cron\Model\ModelTask;

final class Home extends WebController 
{
    // #[Route(ajax: true)]
    // #[Route(methods: ['post', 'put'])]
    public function __invoke()
    {
        // $connect = env('connect.mysql');
        // $config = Yaml::parseFile('../' . ROOTPATH . 'docker-compose.yml');
        // $root_password = $config['services']['mysql']['environment']['MYSQL_ROOT_PASSWORD'];
        // $dbname = (empty($dbname)) ? $connect['database'] : $dbname;
        // $host = $connect['host'];

        // $model = new ModelCreateDB($host, $root_password);
        $data = [
            'isdb' => false, //$model->dbExists($dbname),
        ];

        return $this->render('home', $data);
    }

    public function tasks(ModelTask $model)
    {
        // $tasks = $model->getActualTasks();
        $tasks = $model->get();

        dd($tasks);
    }
}
