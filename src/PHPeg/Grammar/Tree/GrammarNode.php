<?php

namespace PHPeg\Grammar\Tree;

class GrammarNode implements NodeInterface
{
    private $namespace;
    private $imports;
    private $name;
    private $base;
    private $startSymbol;
    private $rules;

    public function __construct($name, array $rules)
    {
        $this->namespace = null;
        $this->name = $name;
        $this->base = null;
        $this->startSymbol = null;
        $this->rules = $rules;
    }

    public function getNamespace()
    {
        return $this->namespace;
    }

    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;
    }

    public function getImports()
    {
        return $this->imports;
    }

    public function setImports($imports)
    {
        $this->imports = $imports;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setBase($base)
    {
        $this->base = $base;
    }

    public function getBase()
    {
        return $this->base;
    }

    public function getQualifiedName()
    {
        if ($this->getNamespace() === null) {
            return $this->name;
        }

        return $this->namespace . '\\' . $this->name;
    }

    public function getStartSymbol()
    {
        return $this->startSymbol;
    }

    public function setStartSymbol($startSymbol)
    {
        $this->startSymbol = $startSymbol;
    }

    public function getRules()
    {
        return $this->rules;
    }

    public function getLength()
    {
        return count($this->rules);
    }

    public function accept(VisitorInterface $visitor)
    {
        foreach ($this->rules as $rule) {
            $rule->accept($visitor);
        }

        $visitor->visitGrammar($this);
    }
}
