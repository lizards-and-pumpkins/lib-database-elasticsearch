<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

use LizardsAndPumpkins\Database\Elasticsearch\Bool\ElasticsearchQueryBoolMustNot;

class ElasticsearchQueryOperatorNotDefined implements ElasticsearchQueryOperator
{
    public function getFormattedArray(string $fieldName, string $fieldValue): array
    {
        return (new ElasticsearchQueryBoolMustNot())->getFormattedArray([
            'exists' => [
                'field' => $fieldName
            ],
        ]);
    }
}
