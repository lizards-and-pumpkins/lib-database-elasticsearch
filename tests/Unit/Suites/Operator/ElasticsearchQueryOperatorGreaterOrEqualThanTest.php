<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

/**
 * @covers \LizardsAndPumpkins\Database\Elasticsearch\Operator\ElasticsearchQueryOperatorGreaterOrEqualThan
 */
class ElasticsearchQueryOperatorGreaterOrEqualThanTest extends AbstractElasticsearchQueryOperatorTest
{
    final protected function getOperatorInstance() : ElasticsearchQueryOperator
    {
        return new ElasticsearchQueryOperatorGreaterOrEqualThan;
    }

    final protected function getExpectedExpression(string $fieldName, string $fieldValue) : array
    {
        return [
            'bool' => [
                'filter' => [
                    'range' => [
                        $fieldName => [
                            'gte' => $fieldValue
                        ]
                    ]
                ]
            ]
        ];
    }
}
