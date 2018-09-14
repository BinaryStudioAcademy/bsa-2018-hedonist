<?php

namespace Hedonist\ElasticSearch\Mappers;

use Illuminate\Database\Eloquent\Model;

interface MapperInterface
{
    public function map(Model $model): array;
}