<?php

namespace seregazhuk\tests;

use PHPUnit_Framework_TestCase;
use seregazhuk\PinterestBot\Api\Request;
use seregazhuk\PinterestBot\Api\CurlHttpClient;
use seregazhuk\PinterestBot\Api\Providers\Provider;
use seregazhuk\PinterestBot\Api\Providers\ProviderWrapper;
use seregazhuk\PinterestBot\Api\Response;

class ProviderWrapperTest extends PHPUnit_Framework_TestCase
{
    /**
     * For not logged in request.
     *
     * @test
     * @expectedException \seregazhuk\PinterestBot\Exceptions\AuthRequired
     */
    public function it_should_fail_when_login_is_required()
    {
        $provider = new TestProvider(new Request(new CurlHttpClient()), new Response());
        $wrapper = new ProviderWrapper($provider);
        $wrapper->testFail();
    }

    /** @test */
    public function it_should_call_provider_method()
    {
        $provider = new TestProvider(new Request(new CurlHttpClient()), new Response());
        $wrapper = new ProviderWrapper($provider);
        $this->assertEquals('success', $wrapper->testSuccess());
    }

    /**
     * @test
     * @expectedException \seregazhuk\PinterestBot\Exceptions\InvalidRequest
     */
    public function it_should_throw_exception_when_calling_non_existed_method()
    {
        $provider = new TestProvider(new Request(new CurlHttpClient()), new Response());
        $wrapper = new ProviderWrapper($provider);
        $wrapper->badMethod();
    }
}

/**
 * Dummy Class TestProvider
 */
class TestProvider extends Provider
{
    /**
     * @var array
     */
    protected $loginRequiredFor = ['testFail'];

    public function testFail()
    {
        return 'exception';
    }

    public function testSuccess()
    {
        return 'success';
    }
}
