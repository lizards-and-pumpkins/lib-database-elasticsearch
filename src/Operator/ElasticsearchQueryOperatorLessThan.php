<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

use LizardsAndPumpkins\Database\Elasticsearch\Bool\ElasticsearchQueryBoolFilter;

class ElasticsearchQueryOperatorLessThan implements ElasticsearchQueryOperator
{
    public function getFormattedArray(string $fieldName, string $fieldValue) : array
    {
        return (new ElasticsearchQueryBoolFilter())->getFormattedArray([
            'range' => [
                $fieldName => ['lt' => $fieldValue]
            ]
        ]);
    }
}
