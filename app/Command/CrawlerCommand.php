<?php

declare(strict_types=1);

namespace App\Command;

use Hyperf\Command\Command as HyperfCommand;
use Hyperf\Command\Annotation\Command;
use Psr\Container\ContainerInterface;
use GuzzleHttp\Client;
use Hyperf\Guzzle\CoroutineHandler;
use GuzzleHttp\HandlerStack;

/**
 * @Command
 */
class CrawlerCommand extends HyperfCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    protected $name = 'foo:hello';

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        parent::__construct('foo:hello');
    }

    public function configure()
    {
        parent::configure();
        $this->setDescription('Hyperf Demo Command');
    }

    public function handle()
    {
        $base_url = 'https://learnku.com/laravel?page=1';
        $urls = $this->more($this->get($base_url));
        foreach ($urls as $url) {
            $tmp_res = $this->get($url);

            $tmp_more_urls = $this->more($tmp_res);
        }
        $this->line($res, 'info');
    }

    private function get($url)
    {
        $client = new Client([
        ]);
        $response = $client->request("GET", $url,
            [
                'verify' => false
            ]
        );
        return $response->getBody()->getContents();
    }

    private function more($data)
    {
        $pattern = '/[a-zA-z]+:\/\/[^\s][^"]+/';
        preg_match_all($pattern, $data, $res);
        if (count($res) > 0) {
            return $res[0];
        } else {
            return [];
        }

    }


}
