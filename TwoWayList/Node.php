<?php

declare(strict_types=1);

namespace TwoWayList;

class Node
{
    public function __construct(
        public mixed $value,
        public ?Node $prev,
        public ?Node $next,
    ) {
    }
}