<?php

class Vertex
{
    private $number;

    private $mark;

    private $visited;

    private $neighbors;

    private $weights;

    private $shortestPathNeighbors;

    public function addNeighbor(Vertex $vertex, $weight)
    {
        $this->neighbors[$vertex->getNumber()] = $vertex;
        $this->weights[$vertex->getNumber()] = $weight;
    }

    public function updateNeighborsMarks()
    {
        /** @var Vertex $vertex */
        foreach($this->neighbors as $vertexNumber => $vertex){

            $newVertexMark = $this->getMark() + $this->weights[$vertexNumber];
            if (is_null($vertex->getMark())
                || $vertex->getMark() > $newVertexMark) {
                $vertex->setMark($newVertexMark);
                $this->shortestPathNeighbors[$vertexNumber] = $vertex;
            }
        }
    }

    /**
     * Vertex constructor.
     * @param $number
     */
    public function __construct($number)
    {
        $this->number = $number;
        $this->mark = null;
        $this->visited = false;
        $this->neighbors = [];
        $this->weights = [];
        $this->shortestPathNeighbors = [];
    }


    /**
     * @return mixed
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @param mixed $number
     */
    public function setNumber($number)
    {
        $this->number = $number;
    }

    /**
     * @return mixed
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * @param mixed $mark
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
    }

    /**
     * @return bool
     */
    public function isVisited(): bool
    {
        return $this->visited;
    }

    /**
     * @param bool $visited
     */
    public function setVisited(bool $visited)
    {
        $this->visited = $visited;
    }

    public function getShortestPathNeighbors()
    {
        return $this->shortestPathNeighbors;
    }
}