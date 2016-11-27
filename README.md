# phplego/yii2-async-mailer
Async mailer decorator for Yii2. This repository is forked from [yarcode/yii2-async-mailer](https://github.com/yarcode/yii2-async-mailer). The main difference is closing connection after mail send. The reason is to avoid known [bug with smtp connection] (https://github.com/swiftmailer/swiftmailer/issues/490).

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Add to composer.json

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/phplego/yii2-async-mailer"
        }
    ],
    "require": {
        "phplego/yii2-async-mailer": "*"
    }
}

```

## Usage

Configure `async` component of your application. 
You can find the details here: https://packagist.org/packages/bazilio/yii2-async

Configure `PhpLego\Yii2\AsyncMailer\Mailer` as your primary mailer.

```
  'mailer' => [
      'class' => '\PhpLego\Yii2\AsyncMailer\Mailer',
      'syncMailer' => [
          'class' => 'yii\swiftmailer\Mailer',
          'useFileTransport' => true,
      ],
  ],
```
Add mailer command to the console config file.
```
  'controllerMap' => [
      'mailer' => [
          'class' => '\PhpLego\Yii2\AsyncMailer\MailerCommand',
      ],
  ],
```
Run the mailer daemon in the background.
```
yii mailer/daemon
```
Now you can send your emails as usual.
```
$message = \Yii::$app->mailer->compose()
  ->setSubject('test subject')
  ->setFrom('test@example.org')
  ->setHtmlBody('test body')
  ->setTo('user@example.org');

\Yii::$app->mailer->send($message);
```
