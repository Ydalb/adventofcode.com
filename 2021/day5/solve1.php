<?php

$diagram = new Diagram();

foreach (file(__DIR__ . '/input', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $row) {
    if (!preg_match('#(?<x1>\d+),(?<y1>\d+) -> (?<x2>\d+),(?<y2>\d+)#', $row, $matches)) {
        die('Could not find coords from line: ' . $row);
    }
    $line = new Line((int)$matches['x1'], (int)$matches['y1'], (int)$matches['x2'], (int)$matches['y2']);
    if ($line->isHorizontalOrVertical()) {
        $diagram->addLine($line);
    }
}

//$diagram->draw();
echo $diagram->getNumPointsOverlap() . PHP_EOL;

class Diagram {

    private array $fields = [];
    private array $points_overlapped = [];

    public function addLine(Line $line) : self {
        foreach ($line->getCoords() as list($x, $y)) {
            if (isset($this->fields[$y][$x])) {
                $this->fields[$y][$x]++;
                $this->points_overlapped[$y.','.$x] = 1;
            } else {
                $this->fields[$y][$x] = 1;
            }
        }
        return $this;
    }

    public function getYMax() : int {
        return max(array_keys($this->fields));
    }

    public function getXMax() : int {
        $y_max = 0;
        foreach ($this->fields as $x => $ys) {
            if (max(array_keys($ys)) > $y_max) {
                $y_max = max(array_keys($ys));
            }
        }
        return $y_max;
    }

    public function draw() : void {
        if (count($this->fields) === 0) {
            die('Nothing to draw');
        }
        $y_max = $this->getYMax();
        $x_max = $this->getXMax();
        for ($y = 0; $y <= $y_max; $y++) {
            for ($x = 0; $x <= $x_max; $x++) {
                echo $this->fields[$y][$x] ?? '.';
                echo ' ';
            }
            echo PHP_EOL;
        }
    }

    public function getNumPointsOverlap() : int {
        return count(array_keys($this->points_overlapped));
    }

}

class Line {
    public int $x1;
    public int $y1;
    public int $x2;
    public int $y2;
    public function __construct(int $x1, int $y1, int $x2, int $y2) {
        $this->x1 = $x1;
        $this->y1 = $y1;
        $this->x2 = $x2;
        $this->y2 = $y2;
    }
    public function isHorizontalOrVertical() : bool {
        return ($this->x1 === $this->x2 || $this->y1 === $this->y2);
    }
    public function getCoords() : Iterator {
        for ($x = min($this->x1, $this->x2); $x <= max($this->x1, $this->x2); $x++) {
            for ($y = min($this->y1, $this->y2); $y <= max($this->y1, $this->y2); $y++) {
                yield [$x, $y];
            }
        }
    }
}