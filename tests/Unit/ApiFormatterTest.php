<?php

namespace Tests\Unit;

use App\Helpers\ApiFormatter;
use App\Models\Product;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ApiFormatterTest extends TestCase
{
    /**
     * Test the success method of ApiFormatter.
     *
     * @return void
     */
    public function test_response_api_Success()
    {
        $data = ['foo' => 'bar'];
        $message = 'Data retrieved successfully.';
        $statusCode = 200;

        $response = ApiFormatter::success($data, $message, $statusCode);

        $this->assertArrayHasKey('meta', $response);
        $this->assertArrayHasKey('data', $response);

        $this->assertEquals('success', $response['meta']['status']);
        $this->assertEquals($data, $response['data']);
        $this->assertEquals($message, $response['meta']['message']);
        $this->assertEquals($statusCode, $response['meta']['status_code']);
    }

    /**
     * Test the error method of ApiFormatter.
     *
     * @return void
     */
    public function test_response_api_BussinessError()
    {
        $message = 'Product Not Found';
        $statusCode = 404;

        $response = ApiFormatter::error($message, $statusCode);

        $this->assertArrayHasKey('meta', $response);
        $this->assertArrayHasKey('data', $response);

        $this->assertStringContainsStringIgnoringCase('error', $response['meta']['status']);
        $this->assertNull($response['data']);
        $this->assertEquals($message, $response['meta']['message']);
        $this->assertEquals($statusCode, $response['meta']['status_code']);
    }

    /**
     * Test the error method of ApiFormatter.
     *
     * @return void
     */
    public function test_response_api_Error()
    {
        $message = 'Something went wrong.';
        $statusCode = 500;

        $response = ApiFormatter::error($message, $statusCode);

        $this->assertArrayHasKey('meta', $response);
        $this->assertArrayHasKey('data', $response);

        $this->assertStringContainsStringIgnoringCase('error', $response['meta']['status']);
        $this->assertNull($response['data']);
        $this->assertEquals($message, $response['meta']['message']);
        $this->assertEquals($statusCode, $response['meta']['status_code']);
    }
}
