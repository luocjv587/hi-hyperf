<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\User;
use App\Service\UserBackService;
use App\Service\UserService;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Annotation\AutoController;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Exception\ParallelExecutionException;
use Hyperf\Utils\Coroutine;
use Hyperf\Utils\Parallel;
use Swoole\Coroutine\Channel;
use GuzzleHttp\Client;
use Hyperf\Guzzle\CoroutineHandler;
use GuzzleHttp\HandlerStack;

/**
 * Class HomeController
 * @package App\Controller
 *
 * @AutoController()
 */
class HomeController extends AbstractController
{
    /**
     * @Inject()
     * @var UserBackService
     */

    private $userService;

    public function index(RequestInterface $request)
    {
        $parallel = new Parallel();
        $parallel->add(function () {
            User::all();
            return Coroutine::id();
        });

        try {
            $results = $parallel->wait();
            return $results;
        } catch (ParallelExecutionException $e) {
            // $e->getResults() 获取协程中的返回值。
            // $e->getThrowables() 获取协程中出现的异常。
        }
    }
}