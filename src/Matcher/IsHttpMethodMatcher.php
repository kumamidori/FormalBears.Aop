<?php
namespace FormalBears\Aop\Matcher;

class IsHttpMethodMatcher extends EqualsToMatcher
{
    public function __construct()
    {
        parent::__construct([
            'onGet',
            'onPost',
            'onPut',
            'onDelete',
            'onOptions',
            'onPatch',
        ]);
    }
}
