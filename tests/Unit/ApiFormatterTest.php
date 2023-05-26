<?php

namespace Tests\Unit;

use App\Helpers\ApiFormatter;
use App\Models\Product;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class ApiFormatterTest extends TestCase
{
    // /**
    //  * Test success method.
    //  *
    //  * @return void
    //  */
    // public function testSuccess()
    // {
    //     $data = [
    //         ['id' => 1, 'name' => 'Item 1'],
    //         ['id' => 2, 'name' => 'Item 2'],
    //         ['id' => 3, 'name' => 'Item 3'],
    //     ];
    //     $message = 'Data retrieved successfully';
    //     $statusCode = 200;

    //     $result = ApiFormatter::success($data, $message, $statusCode);

    //     $this->assertIsArray($result);
    //     $this->assertArrayHasKey('meta', $result);
    //     $this->assertArrayHasKey('data', $result);

    //     $meta = $result['meta'];
    //     $this->assertIsArray($meta);
    //     $this->assertArrayHasKey('message', $meta);
    //     $this->assertArrayHasKey('status_code', $meta);
    //     $this->assertArrayHasKey('status', $meta);
    //     $this->assertEquals($message, $meta['message']);
    //     $this->assertEquals($statusCode, $meta['status_code']);
    //     $this->assertEquals('success', $meta['status']);

    //     $data = $result['data'];
    //     $this->assertEquals(3, count($data));
    //     $this->assertEquals(['id' => 1, 'name' => 'Item 1'], $data[0]);
    //     $this->assertEquals(['id' => 2, 'name' => 'Item 2'], $data[1]);
    //     $this->assertEquals(['id' => 3, 'name' => 'Item 3'], $data[2]);
    // }

    // /**
    //  * Test error method.
    //  *
    //  * @return void
    //  */
    // public function testError()
    // {
    //     $message = 'Error occurred';
    //     $statusCode = 400;

    //     $result = ApiFormatter::error($message, $statusCode);

    //     $this->assertIsArray($result);
    //     $this->assertArrayHasKey('meta', $result);
    //     $this->assertArrayNotHasKey('data', $result);

    //     $meta = $result['meta'];
    //     $this->assertIsArray($meta);
    //     $this->assertArrayHasKey('message', $meta);
    //     $this->assertArrayHasKey('status_code', $meta);
    //     $this->assertArrayHasKey('status', $meta);
    //     $this->assertEquals($message, $meta['message']);
    //     $this->assertEquals($statusCode, $meta['status_code']);
    //     $this->assertEquals('error', $meta['status']);
    // }
}
