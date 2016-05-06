<?php

if (!defined('ROOT_DIR')) {
    define('ROOT_DIR', realpath(__DIR__ . '/..'));
}

use Silex\Application;
use Silex\Provider\FormServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Translation\Loader\YamlFileLoader;

//echo ROOT_DIR . '/vendor/autoload.php';

$classloader = require ROOT_DIR . '/vendor/autoload.php';

/*
echo is_callable(array($classloader, 'loadClass')) ? 'E' : 'H';
exit;
*/

$app->register(new Igorw\Silex\ConfigServiceProvider(__DIR__ . "/settings.php"));

// Register Monolog for Doctrine logging
$app->register(new Silex\Provider\MonologServiceProvider(), array(
    'monolog.logfile' => ROOT_DIR . '/logs/dev.log'
));

/* ORM Setup */
$app->register(new Silex\Provider\DoctrineServiceProvider(), array(
    'db.options' => $app['db.options']
));
$app->register(new Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), array(
    'orm.proxies_dir' => __DIR__ . "/cache/doctrine/proxy",
    'orm.em.options' => array(
        "mappings" => array(
            array(
                'type' => 'annotation',
                'namespace' => 'Ticket\Entity',
                'path' => __DIR__ . "/src/Ticket/Entity"
            )
        )
    )
));
Doctrine\Common\Annotations\AnnotationRegistry::registerLoader(array($classloader, 'loadClass'));

//$a = new Ticket\Manager\UserManager($app['service.users'], $app["security.encoder_factory"]);
//$b =  new Ticket\Service\Impl\TicketServiceImpl($app['orm.em']);

// Register Form provider
$app->register(new FormServiceProvider());

// Register UrlGenerator for url generation (f.e. in pagination)
$app->register(new Silex\Provider\UrlGeneratorServiceProvider());

// Register Twig template engine
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path'    => ROOT_DIR . '/src/Ticket/Templates',
    'twig.options' => array('cache' => ROOT_DIR . '/cache/twig'),
));

$app->register(new Silex\Provider\SessionServiceProvider());

$app['service.tickets'] = $app->share(function() use ($app){
    return new Ticket\Service\Impl\TicketServiceImpl($app['orm.em']);
});

$app['service.comments'] = $app->share(function() use ($app){
    return new Ticket\Service\Impl\CommentServiceImpl($app['orm.em']);
});

$app['service.categories'] = $app->share(function() use ($app){
    return new Ticket\Service\Impl\CategoryServiceImpl($app['orm.em']);
});

$app['service.users'] = $app->share(function() use ($app){
    $userService = new Ticket\Service\Impl\UserServiceImpl($app['orm.em']);
    return $userService;
});

$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        // Login URL is open to everybody.
        'login' => array(
            'pattern' => '^/login$',
            'anonymous' => true,
        ),
        // Any other URL requires auth.
        'index' => array(
            'pattern' => '^.*$',
            'form'      => array(
                'login_path'         => '/login',
                'check_path'        => '/login_check',
                'username_parameter' => '_username',
                'password_parameter' => '_password',
            ),
            'anonymous' => false,
            'logout'    => array('logout_path' => '/logout'),
            'users' => $app->share(function(Application $app) {
                return new Ticket\Manager\UserManager($app['service.users'], $app["security.encoder_factory"]);
            })
        ),
    ),
    'security.encoder.digest' => $app->share(function ($app) {
        return new Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder(10);
    })
));

$app["user_manager"] = $app->share(function(Application $app) {
    return new Ticket\Manager\UserManager($app['service.users'], $app["security.encoder_factory"]);
});
