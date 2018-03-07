<?php

class Graph
{
    private $vertexes = [];

    /**
     * Graph constructor.
     */
    public function __construct()
    {
    }

    /**
     * Добавить вершину
     *
     * @param Vertex $vertex
     */
    public function addVertex(Vertex $vertex)
    {
        $this->vertexes[$vertex->getNumber()] = $vertex;
    }

    /**
     * Имеется ли вершина с переданным номером
     *
     * @param $vertexNumber
     * @return bool
     */
    public function hasVertexByNumber($vertexNumber) {
        return array_key_exists($vertexNumber, $this->vertexes);
    }

    /**
     * Получить вершину по номеру
     *
     * @param $vertexNumber
     * @return mixed|null
     */
    public function getVertexByNumber($vertexNumber) {
        if ($this->hasVertexByNumber($vertexNumber)) {
            return $this->vertexes[$vertexNumber];
        }

        return null;
    }

    /**
     * Есть ли непосещенные вершины
     *
     * @return bool
     */
    public function hasUnVisitedVertexes() {
        /** @var Vertex $vertex */
        foreach($this->vertexes as $vertex) {
            if (!$vertex->isVisited()) {
                return true;
            }
        }
        return false;
    }

    /**
     * Получить непосещенную вершину с минимальной меткой
     *
     * @return Vertex
     */
    function getNotVisitedVertexWithMinimalMark()
    {
        // Отфильтруем посещенные вершины
        /** @var Vertex $vertex */
        $unvisitedVertexes = array_filter($this->vertexes, function($vertex){
            return !$vertex->isVisited();
        });

        // Смаппим номера непосещенных вершин и их метки
        /** @var Vertex $vertex */
        $vertexes2Marks = array_map(function ($vertex) {
            return $vertex->getMark();
        }, $unvisitedVertexes);

        // Отфильтруем значения меток по null
        $vertexes2Marks = array_filter($vertexes2Marks, function($vertexMark) {
            return !is_null($vertexMark);
        });

        // Найдем наименьшую метку
        $minimalWeight = min($vertexes2Marks);
        // Найдем номер непосещенной вершины с минимальной меткой
        $vertexNumber = array_search($minimalWeight, $vertexes2Marks);

        return $this->vertexes[$vertexNumber];
    }

    /**
     * @return Vertex[]
     */
    public function getVertexes()
    {
        return $this->vertexes;
    }
}