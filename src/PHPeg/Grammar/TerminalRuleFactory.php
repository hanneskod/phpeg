<?php

namespace PHPeg\Grammar;

use PHPeg\Combinator\Action;
use PHPeg\Combinator\Any;
use PHPeg\Combinator\CharacterClass;
use PHPeg\Combinator\Choice;
use PHPeg\Combinator\Label;
use PHPeg\Combinator\Literal;
use PHPeg\Combinator\Sequence;
use PHPeg\Combinator\ZeroOrMore;

class TerminalRuleFactory
{
    public function createWhitespace()
    {
        // Whitespace = [ \n\r\t]* { return null; };
        return new Action(
            new ZeroOrMore(new CharacterClass(' \\n\\r\\t')),
            'return null;'
        );
    }

    public function createLiteral()
    {
        // Literal = "\"" string:([^\\"] / "\\" .)* "\"" { return new LiteralNode(stripslashes($string)); };
        return new Action(
            new Sequence(
                new Sequence(
                    new Literal('"'),
                    new Label(
                        'string',
                        new ZeroOrMore(new Choice(new CharacterClass('^\\\\"'), new Sequence(new Literal('\\'), new Any())))
                    )
                ),
                new Literal('"')
            ),
            'return new \PHPeg\Grammar\Tree\LiteralNode(stripslashes($string));'
        );
    }

    public function createAny()
    {
        // Any = "." { return new AnyNode(); };
        return new Action(new Literal('.'), 'return new \PHPeg\Grammar\Tree\AnyNode();');
    }

    public function createCharacterClass()
    {
        // CharacterClass = "[" string:([^\\\]] / "\\" .)* "]" { return new CharacterClassNode($string); };
        return new Action(
            new Sequence(
                new Sequence(
                    new Literal('['),
                    new Label(
                        'string',
                        new ZeroOrMore(new Choice(new CharacterClass('^\\\\\\]'), new Sequence(new Literal('\\'), new Any())))
                    )
                ),
                new Literal(']')
            ),
            'return new \PHPeg\Grammar\Tree\CharacterClassNode($string);'
        );
    }

    public function createRuleReference()
    {
        // RuleReference = name:([A-Za-z_] [A-Za-z0-9_]*) { new RuleReferenceNode($name); };
        return new Action(
            new Label(
                'name',
                new Sequence(new CharacterClass('A-Za-z_'), new ZeroOrMore(new CharacterClass('A-Za-z0-9_')))
            ),
            'return new \PHPeg\Grammar\Tree\RuleReferenceNode($name);'
        );
    }
}
