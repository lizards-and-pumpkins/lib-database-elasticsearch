<?php

namespace LizardsAndPumpkins\Database\Elasticsearch\Bool;

interface ElasticsearchQueryBool
{
    public function getFormattedArray(array $contents) : array;
}
