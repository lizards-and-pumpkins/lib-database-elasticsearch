<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

use PHPUnit\Framework\TestCase;

/**
 * @covers \LizardsAndPumpkins\Database\Elasticsearch\Operator\ElasticsearchQueryOperatorAnything
 */
class ElasticsearchQueryOperatorAnythingTest extends TestCase
{
    /**
     * @var ElasticsearchQueryOperator
     */
    private $operator;

    final protected function setUp(): void
    {
        $this->operator = new ElasticsearchQueryOperatorAnything();
    }

    public function testElasticsearchQueryOperatorInterfaceIsImplemented(): void
    {
        $this->assertInstanceOf(ElasticsearchQueryOperator::class, $this->operator);
    }

    public function testFormattedQueryExpressionIsReturned(): void
    {
        $result = $this->operator->getFormattedArray('what', 'ever');

        $this->assertIsArray($result);
        $this->assertCount(1, $result);
        $this->assertArrayHasKey('bool', $result);

        $this->assertIsArray($result['bool']);
        $this->assertCount(1, $result['bool']);
        $this->assertArrayHasKey('filter', $result['bool']);

        $this->assertIsArray($result['bool']['filter']);
        $this->assertCount(1, $result['bool']['filter']);
        $this->assertArrayHasKey('match_all', $result['bool']['filter']);

        $this->assertIsObject($result['bool']['filter']['match_all']);
    }
}
