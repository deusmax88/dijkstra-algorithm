<?php
require_once("Graph2/Vertex.php");

$matrix = [
    [7, 9, 14,  0,  0,  0,  0,  0,  0],
    [7, 0,  0, 10, 15,  0,  0,  0,  0],
    [0, 9,  0, 10,  0,  2, 11,  0,  0],
    [0, 0,  0,  0, 15,  0, 11,  6,  0],
    [0, 0,  0,  0,  0,  0,  0,  6,  9],
    [0, 0, 14,  0,  0,  2,  0,  0,  9],
];

/** @var Vertex[] $vertexes */
$vertexes = [];
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

    if (!array_key_exists($firstVertexNumber, $vertexes)) {
        $firstVertex = new Vertex($firstVertexNumber);
        $vertexes[$firstVertexNumber] = $firstVertex;
    }
    else {
        $firstVertex = $vertexes[$firstVertexNumber];
    }

    if (!array_key_exists($secondVertexNumber, $vertexes)){
        $secondVertex = new Vertex($secondVertexNumber);
        $vertexes[$secondVertexNumber] = $secondVertex;
    }
    else {
        $secondVertex = $vertexes[$secondVertexNumber];
    }

    $firstVertex->addNeighbor($secondVertex, $edgeWeight);
    $secondVertex->addNeighbor($firstVertex, $edgeWeight);
}

// Дерево построено
//var_dump($vertexes);

// Выставляем метку стартовой вершине,
// остальные вершины имеют значение метки = null
$startVertexNumber = 0;
/** @var Vertex $startVertex */
$startVertex = $vertexes[$startVertexNumber];
$startVertex->setMark(0);

// Алгоритм действует, пока есть непосещенные вершины
function hasUnVisitedVertexes($vertexes) {
    /** @var Vertex $vertex */
    foreach($vertexes as $vertex) {
        if (!$vertex->isVisited()) {
            return true;
        }
    }
    return false;
}

// Получить непосещенную вершину с минимальной меткой
/**
 * @param Vertex[] $vertexes
 * @return Vertex
 */
function getNotVisitedVertexWithMinimalMark($vertexes)
{
    // Отфильтруем посещенные вершины
    /** @var Vertex $vertex */
    $unvisitedVertexes = array_filter($vertexes, function($vertex){
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

    return $vertexes[$vertexNumber];
}

while(hasUnVisitedVertexes($vertexes)) {
    // Достаем еще непосещенную вершину с минимальной веткой
    $vertex = getNotVisitedVertexWithMinimalMark($vertexes);
    // Персчитываем метки соседей вершины
    $vertex->updateNeighborsMarks();
    // Помечаем вершину, как пройденную
    $vertex->setVisited(true);
}

$marks = [];
foreach($vertexes as $vertex) {
    $marks[] = $vertex->getMark();
}
var_dump($marks);

