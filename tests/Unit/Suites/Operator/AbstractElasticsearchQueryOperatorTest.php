<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

use PHPUnit\Framework\TestCase;

abstract class AbstractElasticsearchQueryOperatorTest extends TestCase
{
    /**
     * @var ElasticsearchQueryOperator
     */
    private $operator;

    final protected function setUp(): void
    {
        $this->operator = $this->getOperatorInstance();
    }

    public function testElasticsearchQueryOperatorInterfaceIsImplemented(): void
    {
        $this->assertInstanceOf(ElasticsearchQueryOperator::class, $this->operator);
    }

    public function testFormattedQueryExpressionIsReturned(): void
    {
        $fieldName = 'foo';
        $fieldValue = 'bar';

        $expectedExpression = $this->getExpectedExpression($fieldName, $fieldValue);
        $result = $this->operator->getFormattedArray($fieldName, $fieldValue);

        $this->assertSame($expectedExpression, $result);
    }

    abstract protected function getOperatorInstance(): ElasticsearchQueryOperator;

    abstract protected function getExpectedExpression(string $fieldName, string $fieldValue) : array;
}
