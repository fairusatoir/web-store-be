<?php

namespace Tests\Unit;

use App\Helpers\ApiFormatter;
use PHPUnit\Framework\TestCase;
use Illuminate\Http\JsonResponse;

class ApiFormatterTest extends TestCase
{
    // public function testSuccessResponse()
    // {
    //     $data = ['foo' => 'bar'];
    //     $message = 'Data retrieved successfully';
    //     $statusCode = 200;

    //     $response = ApiFormatter::success($data, $message, $statusCode);

    //     $this->assertInstanceOf(JsonResponse::class, $response);

    //     $responseData = json_decode($response->json(), true);
    //     $this->assertEquals('success', $responseData['status']);
    //     $this->assertEquals($data, $responseData['data']);
    //     $this->assertEquals($message, $responseData['meta']['message']);
    //     $this->assertEquals($statusCode, $responseData['meta']['status_code']);
    // }

    // public function testErrorResponse()
    // {
    //     $message = 'Error occurred';
    //     $statusCode = 400;

    //     $response = ApiFormatter::error($message);

    //     $this->assertArrayHasKey('status', $response);
    //     $this->assertEquals('error', $response['status']);

    //     $this->assertArrayHasKey('message', $response);
    //     $this->assertEquals($message, $response['message']);

    //     $this->assertArrayHasKey('status_code', $response);
    //     $this->assertEquals($statusCode, $response['status_code']);

    //     $this->assertArrayHasKey('meta', $response);
    //     $this->assertEquals($meta, $response['meta']);
    // }
}
