<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Http;

use LizardsAndPumpkins\Database\Elasticsearch\Http\Exception\ElasticsearchConnectionException;
use LizardsAndPumpkins\Database\Elasticsearch\Http\Exception\ElasticsearchException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Database\Elasticsearch\Http\CurlElasticsearchHttpClient
 */
class CurlElasticsearchHttpClientTest extends TestCase
{
    /**
     * @var CurlElasticsearchHttpClient
     */
    private $client;

    /**
     * @var string
     */
    private static $requestUrl;

    /**
     * @var mixed[]
     */
    private static $curlOptionsSet = [];

    /**
     * @var string
     */
    private static $returnType = 'json';

    /**
     * @param array
     */
    private static $response;

    public static function trackRequestUrl(string $url)
    {
        self::$requestUrl = $url;
    }

    /**
     * @param int $option
     * @param mixed $value
     */
    public static function trackCurlOptionSet(int $option, $value)
    {
        self::$curlOptionsSet[$option] = $value;
    }

    public static function getReturnType(): string
    {
        return self::$returnType;
    }

    public static function getResponse(): ?array
    {
        return self::$response;
    }

    final protected function setUp(): void
    {
        $testElasticsearchConnectionPath = 'http://localhost:9200/prod/prod';
        $this->client = new CurlElasticsearchHttpClient($testElasticsearchConnectionPath);
    }

    final protected function tearDown(): void
    {
        self::$requestUrl = null;
        self::$curlOptionsSet = [];
        self::$returnType = 'json';
        self::$response = null;
    }

    public function testInstanceOfElasticsearchHttpClientIsReturned(): void
    {
        $this->assertInstanceOf(ElasticsearchHttpClient::class, $this->client);
    }

    public function testUpdateRequestIsSentToElasticsearchViaPut(): void
    {
        $documentId = 'foo';
        $parameters = ['bar' => 'baz'];
        $this->client->update($documentId, $parameters);

        $this->assertArrayHasKey(CURLOPT_CUSTOMREQUEST, self::$curlOptionsSet);
        $this->assertSame('PUT', self::$curlOptionsSet[CURLOPT_CUSTOMREQUEST]);

        $this->assertArrayHasKey(CURLOPT_POSTFIELDS, self::$curlOptionsSet);
        $this->assertSame(json_encode($parameters), self::$curlOptionsSet[CURLOPT_POSTFIELDS]);
    }

    public function testExceptionIsThrownIfElasticsearchIsNotAccessibleWithUpdateCall(): void
    {
        self::$returnType = 'html';

        $this->expectException(ElasticsearchConnectionException::class);
        $this->expectExceptionMessage('Error 404 Not Found');

        $documentId = 'foo';
        $parameters = [];
        $this->client->update($documentId, $parameters);
    }

    public function testSuccessfulUpdateRequestReturnsAnArray(): void
    {
        $documentId = 'foo';
        $parameters = [];

        $this->assertIsArray($this->client->update($documentId, $parameters));
    }

    public function testSelectRequestHasSelectServlet(): void
    {
        $parameters = [];
        $this->client->select($parameters);

        $path = parse_url(self::$requestUrl, PHP_URL_PATH);
        $lastToken = preg_replace('/.*\//', '', $path);

        $this->assertSame(ElasticsearchHttpClient::SEARCH_SERVLET, $lastToken);
    }

    public function testExceptionIsThrownIfElasticsearchDoesNotReturnValidJsonForSelectRequest(): void
    {
        self::$returnType = 'html';

        $this->expectException(ElasticsearchConnectionException::class);
        $this->expectExceptionMessage('Error 404 Not Found');

        $parameters = [];
        $this->client->select($parameters);
    }

    public function testExceptionIsThrownIfResponseContainsError(): void
    {
        self::$response = [
            'error' => [
                'root_cause' => [
                    [
                        'type' => 'cluster_block_exception',
                        'reason' => 'blocked by: [FORBIDDEN/12/index read-only / allow delete (api)];',
                    ],
                ],
                'type' => 'cluster_block_exception',
                'reason' => 'blocked by: [FORBIDDEN/12/index read-only / allow delete (api)];',
            ],
            'status' => 403,
        ];

        $this->expectException(ElasticsearchException::class);
        $this->expectExceptionMessage('blocked by: [FORBIDDEN/12/index read-only / allow delete (api)];');

        $parameters = [];
        $this->client->select($parameters);
    }

    public function testSuccessfulSelectRequestReturnsAnArray(): void
    {
        $parameters = [];

        $this->assertIsArray($this->client->select($parameters));
    }
}

/**
 * @param string $url
 * @return resource
 */
function curl_init(string $url)
{
    CurlElasticsearchHttpClientTest::trackRequestUrl($url);

    return \curl_init($url);
}

/**
 * @param resource $handle
 * @param int $option
 * @param mixed $value
 */
function curl_setopt($handle, int $option, $value)
{
    CurlElasticsearchHttpClientTest::trackCurlOptionSet($option, $value);
}

/**
 * @param resource $handle
 * @return string
 */
function curl_exec($handle): string
{
    if (CurlElasticsearchHttpClientTest::getReturnType() === 'html') {
        return '<html lang="en"><title>Error 404 Not Found</title><body></body></html>';
    }

    return json_encode(CurlElasticsearchHttpClientTest::getResponse() ?? []);
}
