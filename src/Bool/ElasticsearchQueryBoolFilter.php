<?php

namespace LizardsAndPumpkins\Database\Elasticsearch\Bool;

class ElasticsearchQueryBoolFilter implements ElasticsearchQueryBool
{
    public function getFormattedArray(array $contents) : array
    {
        return [
            'bool' => [
                'filter' => $contents
            ]
        ];
    }
}
