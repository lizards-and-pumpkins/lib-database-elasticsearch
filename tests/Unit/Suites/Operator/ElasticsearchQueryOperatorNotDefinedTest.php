<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

/**
 * @covers \LizardsAndPumpkins\Database\Elasticsearch\Operator\ElasticsearchQueryOperatorNotDefined
 */
class ElasticsearchQueryOperatorNotDefinedTest extends AbstractElasticsearchQueryOperatorTest
{
    final protected function getOperatorInstance(): ElasticsearchQueryOperator
    {
        return new ElasticsearchQueryOperatorNotDefined();
    }

    final protected function getExpectedExpression(string $fieldName, string $fieldValue): array
    {
        return [
            'bool' => [
                'must_not' => [
                    'exists' => [
                        'field' => $fieldName
                    ]
                ]
            ]
        ];
    }
}
