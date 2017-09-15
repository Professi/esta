<?php

use Behat\Mink\Driver;
use Behat\Mink\Session;
use Behat\SahiClient;

abstract class FeatureTest extends \PHPUnit_Framework_TestCase
{

    protected $session;
    protected $app;

    public function getApp()
    {
        $yii = __DIR__ . '/../../../framework/yii.php';
        require_once($yii);
        if (empty(\YiiBase::app())) {
            $config = __DIR__ . '/../../../protected/config/test.php';
            $this->app = Yii::createConsoleApplication($config);
        } else {
            $this->app = \Yii::app();
        }
    }

    public function start()
    {
        switch (strtolower(getenv('DRIVER'))) {
            case 'sahi':
                $browser = getenv('BROWSER') ?: 'firefox';
                $driver = new Driver\SahiDriver(
                    $browser, new SahiClient\Client(
                    new SahiClient\Connection(null, 'localhost', 9999)
                    )
                );
                break;
            case 'goutte':
                $driver = new Driver\GoutteDriver();
                break;
            default:
                $browser = getenv('BROWSER') ?: 'firefox';
                $driver = new Driver\SahiDriver(
                    $browser, new SahiClient\Client(
                    new SahiClient\Connection(null, 'localhost', 9999)
                    )
                );
        }
        $this->session = new Session($driver);
        $this->session->start();
        $this->getApp();
    }

    public function stop()
    {
        if ($this->session) {
            $this->session->stop();
            $this->session = null;
        }
    }

    public function tearDown()
    {
        if (!$this->hasFailed()) {
            $this->stop();
        }
    }

    /**
     * Visit given path
     *
     * @param string $path
     * @return \Behat\Mink\Element\DocumentElement
     */
    protected function visit($path)
    {
        if (!$this->session) {
            $this->start();
        }

        $domain = getenv('DOMAIN') ?: 'http://localhost/~cehringfeld/esta';
        $this->session->visit($domain . $path);
        return $this->session->getPage();
    }

    /**
     * Find element using CSS selector
     *
     * @param string $cssSelector
     * @return \Behat\Mink\Element\NodeElement
     */
    protected function find($cssSelector)
    {
        $result = $this->session->getPage()->find('css', $cssSelector);
        $this->assertNotNull($result, "Did not find any elements matching $cssSelector");

        return $result;
    }

    protected function adminLogin()
    {
        $this->visit('/');
        $this->find('#LoginForm_email')->setValue('admin');
        $this->find('#LoginForm_password')->setValue('admin');
        $this->find('#login-form input[type="submit"]')->press();
    }
}
