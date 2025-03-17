<?php

namespace Tests\Browser;

use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Illuminate\Support\Facades\Log;

class ExampleTest extends DuskTestCase
{
    public function testBasicExample(): void
    {
        Log::debug('Browsing Started');
        
        $this->browse(function (Browser $browser) {
            try {
                //まず最初に3秒待機を行う
                Log::debug("Browsing started in closure.");
                $browser->pause(3000);
                Log::debug('After pause 3000 ms.');

                $browser->visit('/');
                Log::debug('Visited homepage.');
                
                $browser->pause(2000);
                Log::debug('After pause 2000 ms.');
                
                $browser->screenshot('step1_homepage_loaded');
                Log::debug('Screenshot "step1_homepage_loaded" taken.');
                
                $browser->script('console.log("ホームページ読み込み完了");');
                Log::debug('Console script executed.');
                
                // ここでテキストが表示されるのを待つ。waitForText を使うとタイムアウトを設定できるのでおすすめです。
                $browser->waitForText('AI', 5);
                Log::debug('Text "AI" found within 5 seconds.');
                
                $browser->assertSee('AI');
                Log::debug('Assertion for "AI" passed.');
                
                $browser->pause(2000);
                Log::debug('After second pause of 2000 ms.');
                
                $browser->screenshot('step2_after_assertion');
                Log::debug('Screenshot "step2_after_assertion" taken.');
                
                Log::debug('All steps in the closure executed successfully.');
            } catch (\Exception $e) {
                Log::error('Exception in closure: ' . $e->getMessage());
                throw $e;
            }
        });
        
    }
}
