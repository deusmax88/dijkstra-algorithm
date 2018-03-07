<?php
require_once("Graph2/Node.php");

$root = new Node(0);
$numOfNodesPerLevel = 3;

$nodesQueue = [];
$previousNode = $root;
for($i = 1; $i < 10; $i++) {
    $node = new Node($i);
    $previousNode->addNode($node);
    array_push($nodesQueue, $node);
    if ($i % $numOfNodesPerLevel == 0) {
        $previousNode = array_shift($nodesQueue);
    }
}

$path = [];
$paths = [];

function makeTreePaths(Node $node)
{
    global $path;
    global $paths;

    array_push($path, $node->getNumber());
    if(!$node->getNodes()) {
        $paths[] = $path;
    }

    foreach($node->getNodes() as $childNode){
        makeTreePaths($childNode);
    }

    array_pop($path);
}

makeTreePaths($root);

foreach($paths as $path) {
    echo join("->", $path) . "\n";
}
