<?php

class GraphBuilder
{
    /**
     * Построить граф на основании матрицы инцидентности
     *
     * @param $matrix
     * @return Graph
     */
    public static function makeFromIncidenceMatrix($matrix)
    {
        $graph = new Graph();

        // Cтроим дерево на основании матрицы инциденций
        $numOfEdges = count($matrix[0]);
        for($i = 0; $i < $numOfEdges; $i++) {

            $column = array_column($matrix, $i);
            $filteredColumn = array_filter($column, function($value) {
                return $value > 0;
            });

            $vertexNumbers = array_keys($filteredColumn);
            $firstVertexNumber = $vertexNumbers[0];
            $secondVertexNumber = $vertexNumbers[1];

            $edgeWeight = $filteredColumn[$firstVertexNumber];

            if (!$graph->hasVertexByNumber($firstVertexNumber)) {
                $firstVertex = new Vertex($firstVertexNumber);
                $graph->addVertex($firstVertex);
            }
            else {
                $firstVertex = $graph->getVertexByNumber($firstVertexNumber);
            }

            if (!$graph->hasVertexByNumber($secondVertexNumber)){
                $secondVertex = new Vertex($secondVertexNumber);
                $graph->addVertex($secondVertex);
            }
            else {
                $secondVertex = $graph->getVertexByNumber($secondVertexNumber);
            }

            $firstVertex->addNeighbor($secondVertex, $edgeWeight);
            $secondVertex->addNeighbor($firstVertex, $edgeWeight);
        }

        return $graph;
    }
}