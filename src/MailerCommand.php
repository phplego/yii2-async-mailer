<?php
namespace PhpLego\Yii2\AsyncMailer;

use bazilio\async\AsyncComponent;

class MailerCommand extends DaemonCommand
{
    public $asyncComponentName = 'async';

    public function prepare()
    {
        $this->loop->addPeriodicTimer(1, function () {
            \Yii::$app->db->createCommand('SELECT 1')->execute();
        });

        /** @var AsyncComponent $async */
        $async = \Yii::$app->get($this->asyncComponentName);

        $this->loop->addPeriodicTimer(0.1, function () use ($async) {
            while ($task = $async->receiveTask('mailer')) {
                if ($task->execute()) {
                    $async->acknowledgeTask($task);
                }
            }
        });
    }
}
