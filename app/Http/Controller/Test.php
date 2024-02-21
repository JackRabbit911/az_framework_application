<?php

namespace App\Http\Controller;

use Modules\Auth\User;
use Modules\Auth\Model\ModelUser;
use App\Facade\Mail as FacadeMail;
use App\Jobs\LogJob;
use Az\Route\RouteCollectionInterface;
use Az\Route\Route;
use Cron\CronExpression;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Sys\Config\Cache;
use Sys\Config\Config;
use Sys\Controller\WebController;
use Sys\Cron\Model\ModelQueue;
use Sys\Cron\Model\ModelTask;
use Sys\DefaultHandler;
use Sys\Exception\ExceptionResponseFactory;
use Sys\Helper\ResponseType;
use Sys\Mailer\Mail;
use Sys\Mailer\Mailer;
use Sys\Cron\Entity\Task;
use Sys\Entity\Entity;
use Sys\Model\Interface\Saveble;
use App\Listener\Mail2User;
use App\Listener\TestListener;
use Az\Validation\Message;
use Modules\Auth\Http\Middleware\AuthGuardMiddleware;
use Modules\Auth\Http\Middleware\GuestGuardMiddleware;
use Psr\Http\Message\ServerRequestInterface;
use SplObjectStorage;
use stdClass;
use Sys\Observer\Event;
use Modules\Image\Im;
use Modules\Image\Image as ImageImage;
use Modules\Image\Repo;
use Spatie\Image\Manipulations;
use Nette\Utils\Image;
use Nette\Utils\ImageColor;
use Nette\Utils\ImageType;
use Sys\FileResponse;
use Sys\MimeResponse;
use Sys\Helper\Facade\Dir;

// use Sys\Cron\Expression;

use function DI\value;

final class Test extends WebController
{
    private PHPMailer $mailer;
    public $mailData;

    public function __construct()
    {

    }

    public function __invoke()
    {
        return 'Ok ' . __FUNCTION__;
    }

    public function im(Repo $repo)
    {
        $uri = $this->request->getServerParams()['REQUEST_URI'];
        dd($uri);
        // $dir = 'logo';
        // $cachePath = config('images', 'cache_path');
        // $dir = $cachePath . rtrim($dir, '/') . '/';
        // $arr = Dir::getByMask($dir, '*.{jpg,jpeg,png,gif}');
        // dd($arr);

        // dd($repo->clearCache('logo'));


        $img = new ImageImage('logo.png', 'Птичка');
        $str = $img->tag('crop', '400x400', ['class'=>'thumbnail']);
        // dd($img->inline());
        // dd($img->path(), $img->src('crop', '400'));
        // $repo->removeCache('logo');
        // return 'Ok';
        // $str = '<img src="' . $img->src('crop', '400') . '" alt="' . $img->alt('bebe') . '"/>';
        return $str;
        // $config = config('images');
        // $uploadPath = $config['upload_path'];
        // $cachePath = $config['cache_path'];

        // $file = $uploadPath . 'logo.png';

        // $image = new Im($file);

        // $repo->removeCache('logo');



        // $f = $repo->find($file, 'thumb', 300);

        // return new FileResponse($f);

        // dd($f, is_file($f));

        // $format = null;
        // $format = (($format)) ?: 'bar';

        // dd($format);

        // $finfo = finfo_open(FILEINFO_MIME_TYPE);
        // $mime = finfo_buffer($finfo, $file);

        // $fi = new \finfo(FILEINFO_MIME_TYPE);
        // $mi = $finfo->buffer(file_get_contents($file));

        // dd(mime_content_type($file), $mime, $file, $mi);

        // $im = new Im($file);
        // $image = $im->foreign()->toString();

        // dd(Dir::getByMask($uploadPath, '*.{jpg,jpeg,png,gif}'));

        // dd($repo->get('1')->asStorage());

        // $image = $repo->fallback('original');


        // $image = $im->fallback('thumb', '200x300')->toString();
        // $image = $repo->fallback('width', 300)->toString();

        // $image = Image::fromFile($file)
        // $image = $im
            // ->crop('50%', '50%', '55%', '55%')
            // ->toString();

        // $finfo = new \finfo(FILEINFO_MIME_TYPE);

        // dd($finfo->buffer($image));
        
        // return new MimeResponse($image->toString());
    }

    #[Mail2User]
    public function mail(Config $config, ModelUser $model)
    {
        // dd(method_exists($mail, 'toArray'));

        // $modelQueue->update(2, 0);
        $user = $model->find(6);
        $this->session->user_id = $user->id;
        // $userdata = $user->toArray();

        // $data = require APPPATH . 'modules/Auth/messages/data/register_confirm.php';
        $this->mailData = [
            'subject' => 'Blya!!!!',
            'data' => ['html' => "Hey! {$this->user->name}"],
        ];
        // $this->mailData['to'] = [$userdata['email'], $userdata['name']];

        return $this->user->name;


        // $config->addPath(APPPATH . 'modules/Auth/messages/data/');
        // $data = $config->get('en');

        // dd($data);
       

        FacadeMail::create('mail/templates/message')
                    // ->to('qq@qq.qq')
                    ->to('ww@ee.ee', 'Евгений')
                    // ->subject('Welcome!')
                    ->data(['html' => 'Hello!'])
                    ->send()
                    // ->enqueue()
                    ;

        // $row = $modelQueue->get('sendmail', '2024-01-11 13:47:14');
        // dd($row[0]);
        // $mm = Mail::fromJson($row[0]->data);

        // $job = config('queues', 'sendmail')[0];
        // $response = call($job, ['data' => $row[0]->data]);

        // dd($response);

        // $fm->send();
        // $mailer->send($mm);

        // dd($fm->mail(), $mm);

        // $reflection = new \ReflectionObject($queue);
        // $attribute = $reflection->getAttributes(Saveble::class, \ReflectionAttribute::IS_INSTANCEOF)[0] ?? null;
        // dd(method_exists($queue, 'toArray'), $reflection->getAttributes(Saveble::class, \ReflectionAttribute::IS_INSTANCEOF)[0]->getName());
        
        // return $data;
    }

    #[TestListener(['subject' => 'Превед!!!', 'data' => ['html' => '<br>Hello nah!!!']])]
    public function dob(ModelUser $modelUser)
    {
        // $foo = 'bar';

        // dd(${'foo'});

        $user = $modelUser->find(4);
        // $this->session->user_id = $user->id;
        // $user->password = password_hash($user->password, PASSWORD_DEFAULT);

        // dd($user);
        // $user->dob = '1967-06-27';
        // dd(date('d.m.y', strtotime($user->dob)));
        // $user->dob = '1967-04-14';
        // $user->sex = User::MALE;
        // $user->phone = 78122128507;
        // $user->save();
        // dd($id);
        return $user->name();
    }

    // #[Route(methods: ['post', 'put'], pipe: [GuestGuardMiddleware::class])]
    public function mc(ModelUser $modelUser)
    {
        // dd(get_class($this));
        $user = $modelUser->find(3);
        // $listener = new Mail2User(['subject' => 'Превед!!!', 'data' => ['html' => '<br>Hello!!!']]);
        $event = new Event([$this, 'event']);
        return $event->call(['user' => $user, 'name' => 'Huy']);
    }

    #[Mail2User(['subject' => 'Превед!!!', 'data' => ['html' => '<br>Hello nah!!!']])]
    public function event($name)
    {
        return $name;
    }

    public function queue(ModelQueue $modelQueue)
    {
        $modelQueue->update(2, 0);
        // $res = $modelQueue->get('sendmail');
        // dd($res);
        return 'Ok!';
    }

    public function nf(ExceptionResponseFactory $factory)
    {
        return $factory->createResponse(ResponseType::html, 404);
    }

    public function callable()
    {
        $callable = 'App\Jobs\LogJob::foo';
        // $callable = LogJob::class;

        $callable = getCallable($callable);

        dd(is_callable($callable), $callable);
    }

    public function task()
    {
        $data = [
            'name' => 'lala',
            'expression' => '15 * * * *',
            'worker' => 'App\Jobs\MyJob',
            'data' => null,
        ];

        
        // $task = new Task;
        // $task->name = 'SessionClean';
        // $task->expression = '@hourly';
        // $task->worker = 'App\Jobs\SessGC';

        // return 'Ok';
        // $ts = $modelTask->ct();
        // dd($ts);

        // $modelTask = new ModelTask(new Expression());

        // $tasks = $modelTask->getActualTasks();
        // dd($tasks);

        // $worker = addcslashes($task->worker, '\\');
        // $data = $task->data;

        // dd($worker, $data);
    }

    public function route(RouteCollectionInterface $routes)
    {
        $route = $routes->getRoute('home');
        dd($route->getHandler());
    }

    public function guide()
    {
        // dd($config->get('mail/templates/message', 'data.img'));
        // dd(env('env'));
        dd(config('folder/sub/guide', 'foo', 'bebe', false));
    }

    public function config(Cache $cache)
    {
        // dd(config('huy', null, 'hehe'));

        $co = container()->get(Config::class);
        $cc = container()->get(Cache::class);

        // $co->enable();

        $en = $co->getEnabled();

        $st = config('structure');

        $cm = $cc->cacheMemory;

        // $expr = new Expression();

        // $res = call([ModelTask::class, 'get']);

        dd($en, $st, $cm);
    }

    public function cron()
    {
        // $a = false;
        // $a = ($a) ? 'qq' : null;
        // dd($a);

        // $expr = '/5 * * * *';

        // $logger = container()->make('logger', config('cron', 'logger'));
        // $e = new \InvalidArgumentException('Invalid cron expression: ' . $expr);
        // $logger->error($e->getMessage() . ' ' . $e->getFile(), [$e->getLine()]);

        $v = CronExpression::isValidExpression('*/5 * * * *');

        dd($v);
    }

    #[TestListener(['subject' => 'Превед!!!', 'data' => ['html' => '<br>Hello nah!!!']])]
    public function attr()
    {
        // $this->session->user_id = 5;
        // $this->request = $this->request->withAttribute('user', $model->find(3));
        return $this->user?->name;
    }

    public function storage()
    {
        $foo = new stdClass;
        $bar = new stdClass;

        $foo->qq = 'foo';
        $bar->qq = 'bar';

        $storage = new SplObjectStorage;

        $storage->attach($foo, $bar);
        $storage->attach($foo, 'bar');

        foreach ($storage as $inf => $item) {
            var_dump($storage->offsetGet($item));
        }

        dd($storage);
    }

    private function strKeys($path, $value)
    {
        // $path = 'foo/bar/baz';
        // $value = ['a' => 'b'];

        $keys = array_reverse(explode('/', $path));
        $res = [];

        foreach ($keys as $k => $key) {
            if ($k === 0) {
                $res[$key] = $value;
            } else {
                $res[$key] = $res;
                unset($res[$keys[$k - 1]]);
            }
        }

        return $res;
    }
}
