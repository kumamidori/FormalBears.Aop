<?php
namespace FormalBears\Aop\Matcher;

use Ray\Aop\AbstractMatcher;

class EqualsToMatcher extends AbstractMatcher
{
    /**
     * @var array
     */
    private $values;

    /**
     * @param string|array $values
     */
    public function __construct($values)
    {
        parent::__construct();

        $this->values = (array) $values;
    }

    /**
     * {@inheritdoc}
     */
    public function matchesClass(\ReflectionClass $class, array $arguments)
    {
        return in_array(strtolower($class->getName()), array_map('strtolower', $this->values), true);
    }

    /**
     * {@inheritdoc}
     */
    public function matchesMethod(\ReflectionMethod $method, array $arguments)
    {
        return in_array(strtolower($method->getShortName()), array_map('strtolower', $this->values), true);
    }
}
