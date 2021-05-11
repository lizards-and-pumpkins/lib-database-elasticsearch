<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

use LizardsAndPumpkins\Database\Elasticsearch\Bool\ElasticsearchQueryBoolFilter;
use stdClass;

class ElasticsearchQueryOperatorAnything implements ElasticsearchQueryOperator
{
    public function getFormattedArray(string $fieldName = '', string $fieldValue = '') : array
    {
        return (new ElasticsearchQueryBoolFilter())->getFormattedArray([
            'match_all' => new stdClass()
        ]);
    }
}
