<?php
namespace PhpLego\Yii2\AsyncMailer;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use yii\console\Controller;

abstract class DaemonCommand extends Controller
{
    /** @var LoopInterface */
    protected $loop;
    public function init()
    {
        parent::init();
        $this->loop = Factory::create();
    }
    public function actionDaemon()
    {
        $this->prepare();
        $this->loop->run();
    }
    abstract public function prepare();
}