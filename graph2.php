<?php
require_once("Graph2/Vertex.php");
require_once("Graph2/Graph.php");
require_once("Graph2/GraphBuilder.php");

$matrix = [
    [7, 9, 14,  0,  0,  0,  0,  0,  0],
    [7, 0,  0, 10, 15,  0,  0,  0,  0],
    [0, 9,  0, 10,  0,  2, 11,  0,  0],
    [0, 0,  0,  0, 15,  0, 11,  6,  0],
    [0, 0,  0,  0,  0,  0,  0,  6,  9],
    [0, 0, 14,  0,  0,  2,  0,  0,  9],
];

$graph = GraphBuilder::makeFromIncidenceMatrix($matrix);

// Выставляем метку стартовой вершине,
// остальные вершины имеют значение метки = null
$startVertexNumber = 0;
/** @var Vertex $startVertex */
$startVertex = $graph->getVertexByNumber($startVertexNumber);
$startVertex->setMark(0);

// Алгоритм действует, пока есть непосещенные вершины
while($graph->hasUnVisitedVertexes()) {
    // Достаем еще непосещенную вершину с минимальной веткой
    $vertex = $graph->getNotVisitedVertexWithMinimalMark();
    // Персчитываем метки соседей вершины
    $vertex->updateNeighborsMarks();
    // Помечаем вершину, как пройденную
    $vertex->setVisited(true);
}

$marks = [];
foreach($graph->getVertexes() as $vertex) {
    $marks[] = $vertex->getMark();
}
var_dump($marks);

$path = [];
$paths = [];
function makeShortestPaths(Vertex $vertex)
{
    global $path;
    global $paths;

    array_push($path, $vertex->getNumber());
    if(!$vertex->getShortestPathNeighbors()) {
        $paths[] = $path;
    }

    foreach($vertex->getShortestPathNeighbors() as $neighbor){
        makeShortestPaths($neighbor);
    }

    array_pop($path);
}

/** @var Vertex $currentVertex */
$currentVertex = $graph->getVertexByNumber($startVertexNumber);
makeShortestPaths($currentVertex);
foreach($paths as $path){
    echo join('->', $path);
    echo "\n";
}



