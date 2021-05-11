<?php

namespace LizardsAndPumpkins\Database\Elasticsearch\Bool;

class ElasticsearchQueryBoolShould implements ElasticsearchQueryBool
{
    public function getFormattedArray(array $contents) : array
    {
        return [
            'bool' => [
                'should' => $contents
            ]
        ];
    }
}
