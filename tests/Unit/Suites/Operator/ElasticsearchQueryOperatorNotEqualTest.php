<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

/**
 * @covers \LizardsAndPumpkins\Database\Elasticsearch\Operator\ElasticsearchQueryOperatorNotEqual
 */
class ElasticsearchQueryOperatorNotEqualTest extends AbstractElasticsearchQueryOperatorTest
{
    final protected function getOperatorInstance() : ElasticsearchQueryOperator
    {
        return new ElasticsearchQueryOperatorNotEqual;
    }

    final protected function getExpectedExpression(string $fieldName, string $fieldValue) : array
    {
        return [
            'bool' => [
                'must_not' => [
                    'term' => [
                        $fieldName => $fieldValue
                    ]
                ]
            ]
        ];
    }
}
