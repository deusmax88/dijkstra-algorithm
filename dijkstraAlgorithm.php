<?php
$insMatrix = [
    [4, 42, 66],
    [-4, 0, 0],
    [0, -42, 0],
    [0, 0 ,-66]
];

$matrix = [
    [7, 9, 14,  0,  0,  0,  0,  0,  0],
    [7, 0,  0, 10, 15,  0,  0,  0,  0],
    [0, 9,  0, 10,  0,  2, 11,  0,  0],
    [0, 0,  0,  0, 15,  0, 11,  6,  0],
    [0, 0,  0,  0,  0,  0,  0,  6,  9],
    [0, 0, 14,  0,  0,  2,  0,  0,  9],
];

// Инициализация
$visitedVertexes = [];
$distances = [0, 'undefined', 'undefined', 'undefined', 'undefined', 'undefined'];

// Найдем вершину с минимальной меткой из еще непосещенных
function findMinimalLabelVertex()
{
    global $distances;
    global $visitedVertexes;

    // Получаем метки непосещенных вершины
    $notVisitedDistances = [];

    foreach($distances as $vertex => $distance) {
        if (!in_array($vertex, $visitedVertexes)
            && $distance !== 'undefined') {
            $notVisitedDistances[$vertex] = $distance;
        }
    }
    $minimalDistance = min($notVisitedDistances);
    $minimalLabelVertex = array_search($minimalDistance, $notVisitedDistances);

    return $minimalLabelVertex;
}

function findNeighbourVertexes($currentVertex)
{
    global $matrix;

    //Вершины, соседи текущей переданной
    $neighbourVertexes = [];

    // Получаем соседей вершины
    // на основании матрицы инцидентности
    $vertexWeights = $matrix[$currentVertex];
    foreach($vertexWeights as $vertexKey => $vertexWeight) {
        if ($vertexWeight == 0) {
            continue;
        }

        $vertexColumn = array_column($matrix, $vertexKey);
        foreach ($vertexColumn as $vertexSubKey => $vertexSubWeight) {
            // Исключим строку для которой мы производим просмотр
            if ($vertexSubKey == $currentVertex) {
                continue;
            }

            if ($vertexSubWeight == 0) {
                continue;
            }

            break;
        }

        $neighbourVertexes[] = $vertexSubKey;
    }

    return $neighbourVertexes;
}

/**
 *  Фильтровать входной массив, оставив в нем только
 *  те вершины, которых нет в списке посещенных
 */
function getNotVisitedOnlyVertexes($vertexArray){
    global $visitedVertexes;

    $filteredArray = [];
    foreach($vertexArray as $vertex) {
       if (in_array($vertex, $visitedVertexes)) {
           continue;
       }
       $filteredArray[] = $vertex;
    }

    return $filteredArray;
}

function updateVertexDistance($currentVertex, $neighbourVertex){
    global $distances;
    global $matrix;
    $currentVertexDistance = $distances[$currentVertex];
    $neighbourVertexDistance = $distances[$neighbourVertex];

    $currentVertexRow = $matrix[$currentVertex];
    $neighbourVertexRow = $matrix[$neighbourVertex];
    foreach($currentVertexRow as $key => $item) {
        if ($item == 0) {
            continue;
        }

        if ($neighbourVertexRow[$key] != $item) {
            continue;
        }

        break;
    }

    $edgeWeight = $item;
    if ($neighbourVertexDistance == 'undefined') {
        $neighbourVertexDistance = $currentVertexDistance + $edgeWeight;
    }
    else {
        if (($currentVertexDistance + $edgeWeight) < $neighbourVertexDistance) {
            $neighbourVertexDistance = $currentVertexDistance + $edgeWeight;
        }
    }
    $distances[$neighbourVertex] = $neighbourVertexDistance;
}

//
// Тестовые сценарии
//
// Получим соседей вершины 1
//var_dump(findNeighbourVertexes(0));
// Получим соседей вершины 2
//var_dump(findNeighbourVertexes(1));
// Получим соседей вершины 3
//var_dump(findNeighbourVertexes(2));


// Непосредственно сам алгоритм
while(count($visitedVertexes) != 6) {
    $currentVertex = findMinimalLabelVertex();

    // Найдем соседей текущей вершины
    $neighbourVertexes = findNeighbourVertexes($currentVertex);

    // Оставим из них те, которые еще не были помеченны как пройденные
    $neighbourVertexes = getNotVisitedOnlyVertexes($neighbourVertexes);

    // Проходимся по каждой соседней вершине и пересчитываем её метку(дистанцию)
    foreach ($neighbourVertexes as $neighbourVertex) {
        updateVertexDistance($currentVertex, $neighbourVertex);
    }

    // Помечаем текущую вершину, как пройденную
    $visitedVertexes[] = $currentVertex;
}

var_dump($distances);
var_dump($visitedVertexes);