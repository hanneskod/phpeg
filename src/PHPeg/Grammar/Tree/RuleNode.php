<?php

namespace PHPeg\Grammar\Tree;

class RuleNode extends AbstractNamedNode
{
    private $identifier;

    public function __construct($identifier, $name, NodeInterface $expression)
    {
        parent::__construct($name, $expression);

        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function accept(VisitorInterface $visitor)
    {
        parent::accept($visitor);

        $visitor->visitRule($this);
    }
}
