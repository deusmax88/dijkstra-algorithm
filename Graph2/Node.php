<?php

class Node
{
    private $number;

    private $childNodes;

    public function __construct($number)
    {
        $this->number = $number;
        $this->childNodes = [];
    }

    public function addNode(Node $node)
    {
        $this->childNodes[] = $node;
    }

    public function getNodes()
    {
        return $this->childNodes;
    }

    public function getNumber()
    {
        return $this->number;
    }
}