<?php

declare(strict_types=1);

namespace LizardsAndPumpkins\Database\Elasticsearch\Operator;

interface ElasticsearchQueryOperator
{
    public function getFormattedArray(string $fieldName, string $fieldValue) : array;
}
