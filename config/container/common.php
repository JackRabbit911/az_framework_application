<?php

use HttpSoft\Runner\MiddlewarePipelineInterface;
use HttpSoft\Runner\MiddlewarePipeline;
use HttpSoft\Runner\MiddlewareResolver;
use HttpSoft\Runner\MiddlewareResolverInterface;
use HttpSoft\ServerRequest\ServerRequestCreator;
use HttpSoft\Emitter\EmitterInterface;
use HttpSoft\Emitter\SapiEmitter;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;
use Az\Route\RouteCollectionInterface;
use Az\Route\RouteCollection;
use Sys\Exception\SetErrorHandlerInterface;
use Sys\Exception\WhoopsAdapter;
use Sys\DefaultHandler;
use Sys\Exception\ExceptionResponseFactory;
use Pecee\Pixie\Connection;
use Pecee\Pixie\QueryBuilder\QueryBuilderHandler;
use Az\Session\Session;
use Az\Session\Driver;
use Az\Session\SessionInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Psr\Http\Server\RequestHandlerInterface;
use Sys\Profiler\Model\Mysql;
use Sys\Profiler\Model\ProfilerModelInterface;
use Sys\Profiler\Profiler;

return [
    ServerRequestInterface::class => fn() => (new ServerRequestCreator())->create(),
    RequestHandlerInterface::class => fn(ExceptionResponseFactory $factory) => new DefaultHandler($factory),
    RouteCollectionInterface::class => fn() => new RouteCollection,
    MiddlewarePipelineInterface::class => fn() => new MiddlewarePipeline(),
    MiddlewareResolverInterface::class => fn(ContainerInterface $c) => new MiddlewareResolver($c),
    EmitterInterface::class => fn() => new SapiEmitter,
    LoggerInterface::class => function () {
        $logger = new Logger('e');
        $logger->setTimezone(new \DateTimeZone(env('tz')));
        $logger->pushHandler(new StreamHandler(WRITABLE . 'logs/error.log', Level::Error, true, 0777));
        return $logger;
    },
    SetErrorHandlerInterface::class => fn(ServerRequestInterface $request, 
        LoggerInterface $logger, 
        EmitterInterface $emitter, 
        ExceptionResponseFactory $response_factory) 
        => new WhoopsAdapter($request, $logger, $emitter, $response_factory),
    
    QueryBuilderHandler::class => fn() => (new Connection('mysql', env('connect.mysql')))->getQueryBuilder(),
    // SessionHandlerInterface::class => fn(QueryBuilderHandler $qb) => new Driver\Db($qb->pdo()),
    // SessionInterface::class => fn(SessionHandlerInterface $h) => new Session(config('session'), $h),
    SessionInterface::class => fn() => new Session(config('session')),
    ProfilerModelInterface::class => fn(ContainerInterface $c) => $c->get(Mysql::class),
    Profiler::class => fn(ContainerInterface $c)
        => new Profiler($c->get(ProfilerModelInterface::class), $c->get(RouteCollectionInterface::class)),
];
