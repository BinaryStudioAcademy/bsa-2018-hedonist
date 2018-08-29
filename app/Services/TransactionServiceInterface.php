<?php

namespace Hedonist\Services;

interface TransactionServiceInterface
{
    public function run(\Closure $closure);
}