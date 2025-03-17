<?php

namespace Tests;

use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Laravel\Dusk\TestCase as BaseTestCase;

abstract class DuskTestCase extends BaseTestCase
{
    /**
     */
    public static function prepare()
    {
        // Selenium使用のため標準的なprepareは呼び出さない
        // static::startChromeDriver();
    }

    /**
     * Seleniumサーバーへの接続を作成します
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless', // ヘッドレスモードで実行
            '--no-sandbox',
            '--disable-dev-shm-usage',
            '--window-size=1920,1080',
        ]);
    
        $capabilities = DesiredCapabilities::chrome();
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);
    
        return RemoteWebDriver::create(
            env('DUSK_DRIVER_URL', 'http://172.19.0.7:4444/wd/hub'),
            $capabilities
        );
    }
    /**
     * アプリケーションのベースURLを取得
     * @return string
     */
    protected function baseUrl()
    {
        // localhostで公開されているURLを指定
        return env('APP_URL', 'http://192.168.0.34');
    }
}