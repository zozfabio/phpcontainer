<?

session_start();

require_once 'lib/functions.php';

define('APP_HOST', 'http://'.$_SERVER['HTTP_HOST']);

define('APP_CONTAINERDIR', dirname(__FILE__));
define('APP_CONTAINERURI', APP_HOST.dirname($_SERVER['SCRIPT_NAME']));

define('APP_BASEDIR', APP_CONTAINERDIR.'/src');
define('APP_BASEURI', APP_CONTAINERURI.'/index.php');

call(function() {
    $pathInfo = explode('/', $_SERVER['PATH_INFO']);

    $view = array_pop($pathInfo);
    $src = implode('/', $pathInfo);

    define('APP_DIR', APP_BASEDIR.$src);
    define('APP_URI', APP_BASEURI.$src);

    switch (get_format($view, '/\.[a-z]{1,3}$/')) {
        case '.js':
            header("Content-Type: text/javascript");
        break;
        case '.css':
            header("Content-Type: text/css");
        break;
    }

    require_once APP_DIR.'/view/'.$view;
});

session_write_close();