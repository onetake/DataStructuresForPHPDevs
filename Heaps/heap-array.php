<?php
class BinaryHeap
{
  public $heap;

    public function __construct() {
        $this->heap  = array();
    }

    public function isEmpty() {
        return empty($this->heap);
    }

    public function count() {
        return count($this->heap) - 1;
    }

    public function extract() {
        // nothing to extract!
        if ($this->isEmpty()) {
            throw new RunTimeException('Heap is empty');
        }
        // extract root item
        $root = array_shift($this->heap);

        if (!$this->isEmpty()) {
            // move last item into the root so the heap 
            // is no longer disjointed
            $last = array_pop($this->heap);
            array_unshift($this->heap, $last);

            // transform semiheap to heap
            $this->adjust(0);
        }

        // return the extracted root item
        return $root;
    }

    public function compare($item1, $item2) {
        if ($item1 === $item2) {
            return 0;
        }
        else {
            return ($item1 < $item2 ? 1 : -1);
        }
    }

    protected function isLeaf($node) {
        return ((2 * $node + 1) > $this->count());
    }

    protected function adjust($root) {
        // we've gone as far as we can down the tree if
        // root is a leaf
        if (!$this->isLeaf($root)) {
            $left  = (2 * $root) + 1; // left child
            $right = (2 * $root) + 2; // right child

            // if root is less than either of its children
            $h = $this->heap;
            if (
              (isset($h[$left]) &&
                $this->compare($h[$root], $h[$left]) < 0)
              || (isset($h[$right]) &&
                $this->compare($h[$root], $this->heap[$right]) < 0)
            ) {
                // find the larger child
                if (isset($h[$left]) && isset($h[$right])) {
                    $j = $this->compare($h[$left], $h[$right]) >= 0
                        ? $left : $right;
                }
                else if (isset($h[$left])) {
                    $j = $left; // left child only
                }
                else {
                    $j = $right; // right child only
                }

                // swap places with root
                list($this->heap[$root], $this->heap[$j]) =
                    array($this->heap[$j], $this->heap[$root]);
                // recursively adjust semiheap root at new node j
                $this->adjust($j);
            }
        }
    }

    public function insert($item) {
        // insert new items at the bottom of the heap
        $this->heap[] = $item;

        // trickle up to the correct location
        $place = $this->count();
        $parent = floor($place / 2); // because this is a binary heap
        // while not at root and greater than parent
        while (
            $place > 0 && $this->compare(
              $this->heap[$place], $this->heap[$parent]) >= 0
        ) {
            // swap places
            list($this->heap[$place], $this->heap[$parent]) =
                array($this->heap[$parent], $this->heap[$place]);
            $place = $parent;
            $parent = floor($place / 2);
        }
    }
}

$heap = new BinaryHeap();
$heap->insert(19);
$heap->insert(36);
$heap->insert(54);
$heap->insert(100);
$heap->insert(17);
$heap->insert(3);
$heap->insert(25);
$heap->insert(1);
$heap->insert(67);
$heap->insert(2);
$heap->insert(7);

while (!$heap->isEmpty()) {
    echo $heap->extract() . "\n";
}
