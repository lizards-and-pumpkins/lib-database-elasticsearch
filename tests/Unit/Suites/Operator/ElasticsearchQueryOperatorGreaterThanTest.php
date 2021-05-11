<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

/**
 * @covers \LizardsAndPumpkins\Database\Elasticsearch\Operator\ElasticsearchQueryOperatorGreaterThan
 */
class ElasticsearchQueryOperatorGreaterThanTest extends AbstractElasticsearchQueryOperatorTest
{
    final protected function getOperatorInstance() : ElasticsearchQueryOperator
    {
        return new ElasticsearchQueryOperatorGreaterThan;
    }

    final protected function getExpectedExpression(string $fieldName, string $fieldValue) : array
    {
        return [
            'bool' => [
                'filter' => [
                    'range' => [
                        $fieldName => [
                            'gt' => $fieldValue
                        ]
                    ]
                ]
            ]
        ];
    }
}
