<?php

namespace src\lib;

require_once(__DIR__."/../../../vendor/autoload.php");


// Pointer in this is $this->mx
class Matrix extends Common
{
    public $parentType;
    public $childType;
    // Pointer to current Index
    public $mx;
    // $mx[$datCntr] (The index pointed to)
    public $datCnt = 0;
    public $dat = array();
    public $pv;

    /**
     * @method __construct
     * @param type
     * @param child
     * @return bool
     * 
     * initialize Matrix entry
     * 
     */
    public function __construct($type, $child = "String")
    {
        $this->rootType = 'Container';
        $this->parentType = 'Matrix';

        if ($type == 'Dequeue') {
            array_push($this->dat, new Dequeue());
            $this->childType = 'Dequeue';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Queue') {
            array_push($this->dat, new Queue());
            $this->childType = 'Queue';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Set') {
            array_push($this->dat, new Set());
            $this->childType = 'Set';
            $this->parentType = 'Matrix';
        } elseif ($type == 'SortedSet') {
            array_push($this->dat, new SortedSet());
            $this->childType = 'SortedSet';
            $this->parentType = 'Matrix';
        } elseif ($type == 'NavigableSet') {
            array_push($this->dat, new NavigableSet());
            $this->childType = 'NavigableSet';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Map') {
            array_push($this->dat, new Map());
            $this->childType = 'Map';
            $this->parentType = 'Matrix';
        } elseif ($type == 'SortedMap') {
            array_push($this->dat, new SortedMap());
            $this->childType = 'SortedMap';
            $this->parentType = 'Matrix';
        } elseif ($type == 'NavigableMap') {
            array_push($this->dat, new Navigablemap());
            $this->childType = 'NavigableMap';
            $this->parentType = 'Matrix';
        } elseif ($type == 'mMap') {
            array_push($this->dat, new mMap());
            $this->childType = 'mMap';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Stack') {
            array_push($this->dat, new Stack());
            $this->childType = 'Stack';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Thread') {
            array_push($this->dat, new Thread());
            $this->childType = 'Thread';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Any') {
            $this->childType = 'Any';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Array') {
            $this->childType = 'Array';
            $this->parentType = 'Matrix';
        } elseif ($type == 'String') {
            $this->childType = 'String';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Vector') {
            array_push($this->dat, new Vector($child));
            $this->childType = $child;
            $this->parentType = 'Vector';
        } else {
            throw new Type_Error('Invalid Type');
            return 0;
        }
        $this->typeOf = $type;
        $this->dat = array();
        return 1;
    }

    /**
     * @method newObj
     * @param type
     * @param childType
     * @return bool
     * 
     * Create dynamic container object to insert in Matrix
     */
    public function newObj($type, $childType)
    {
        if ($type == 'Dequeue') {
            array_push($this->dat, new Dequeue());
            $this->childType = 'Dequeue';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Queue') {
            array_push($this->dat, new Queue());
            $this->childType = 'Queue';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Set') {
            array_push($this->dat, new Set());
            $this->childType = 'Set';
            $this->parentType = 'Matrix';
        } elseif ($type == 'SortedSet') {
            array_push($this->dat, new SortedSet());
            $this->childType = 'SortedSet';
            $this->parentType = 'Matrix';
        } elseif ($type == 'NavigableSet') {
            array_push($this->dat, new NavigableSet());
            $this->childType = 'NavigableSet';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Map') {
            array_push($this->dat, new Map());
            $this->childType = 'Map';
            $this->parentType = 'Matrix';
        } elseif ($type == 'SortedMap') {
            array_push($this->dat, new SortedMap());
            $this->childType = 'SortedMap';
            $this->parentType = 'Matrix';
        } elseif ($type == 'NavigableMap') {
            array_push($this->dat, new Navigablemap());
            $this->childType = 'NavigableMap';
            $this->parentType = 'Matrix';
        } elseif ($type == 'mMap') {
            array_push($this->dat, new mMap());
            $this->childType = 'mMap';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Stack') {
            array_push($this->dat, new Stack());
            $this->childType = 'Stack';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Thread') {
            array_push($this->dat, new Thread());
            $this->childType = 'Thread';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Any') {
            $this->childType = 'Any';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Array') {
            $this->childType = 'Array';
            $this->parentType = 'Matrix';
        } elseif ($type == 'String') {
            $this->childType = 'String';
            $this->parentType = 'Matrix';
        } elseif ($type == 'Vector') {
            array_push($this->dat, new Vector($childType));
            $this->childType = $childType;
            $this->parentType = 'Vector';
        } else {
            throw new Type_Error('Invalid Type');
            return 0;
        }
        $this->typeOf = $type;
    }

    /**
     * @method table
     * @param string, array, string
     *
     */
    public function table(string $classId = "", array $tdId, string $thId = ""): string
    {
        $cid = "";
        $h = 0;
        $g = 0;
        if (strlen($thId) > 0) {
            $g += 2;
        }
        if ($classId == "") {
            $h = 0;
        } elseif (strlen($classId) > 0 && ($classId[0] == "\"" || $classId[0] == "\'")) {
            $h = 2;
        } elseif (strlen($classId) > 0 && ($classId[0] == "." || $classId[0] == "#")) {
            $h = 1;
        } elseif (strlen($classId) > 0) {
            return $html = "Class or Id Unidentified";
        }
        if ($h > 0) {
            for ($i = $h; $i < strlen($classId)-($h-1); $i++) {
                $cid .= $classId[$i];
            }
        }
        $html = "";
        if ($classId == "") {
            $html = '<table>';
        } elseif ($classId[0] == "#" || $classId[1] == "#") {
            $html = '<table id=' . $cid .'>';
        } //$classId.substr(2,strlen($classId)-) . '\">';
        elseif ($classId[0] == "." || $classId[0] == ".") {
            $html = '<table class=' . $cid .'>';
        } //$classId.substr(2,strlen($classId)-2) . '\">';
        $table = $this->dat;
        foreach ($table as $xm) {
            if ($xm == null) {
                return 'NULL ENTRIES IN MATRIX';
            }
            if ($xm->parentType == "Matrix" || $xm->childType == 'Map' || $xm->childType == 'mMap'
                    || $xm->childType == 'SortedMap' || $xm->childType == 'NavigableMap') {
                return 'MATRIX & MAP TYPES ARE ILLEGAL IN SYNTAX';
            }
        }
        $table = $this->mx;
        if (is_object($table)) {
            $table = $table->dat;
        }
        $html .= '<tr>';
        $w = 0;
        if (is_object($table) || is_array($table)) {
            $w = sizeof($table);
        }
        for ($i = 0; $i < $w; $i++) {
            $y = '';
            $k = 0;
            $y = $table[$i];
            $m = '';
            if (is_object($y)) {
                $y = $y->dat[$i];
            }
            if (is_object($y)) {
                foreach ($y->dat as $mm) {
                    $m .= $mm;
                    if ($k + 1 < $y->size()) {
                        $m .= ', ';
                    }
                    $k++;
                }
            } elseif (is_array($y)) {
                foreach ($y as $mm) {
                    $m .= $mm;
                    if ($k + 1 < sizeof($y)) {
                        $m .= ', ';
                    }
                    $k++;
                }
            } else {
                $m = $y;
            }
            if ($g == 2 || $g == 3) {
                $html .= "<th id=" . $thId . ">" . $m . "</th>";
            } else {
                $html .= "<th>" . $m . "</th>";
            }
        }
        $html .= '</tr>';
        $mcnt = array();
        $tab = array();
        for ($i = 1; $i < sizeof($this->dat); $i++) {
            array_push($tab, $this->dat[$i]);
        }
        $e = 0;
        for ($i = 0; $i < sizeof($tab); $i++) {
            if ($g == 1 || $g == 3) {
                $html .= '<tr style=' . $tdId[$i%sizeof($tdId)] . '>';
            } else {
                $html .= '<tr>';
            }
            $ta = $tab[$i];
            if (is_object($ta)) {
                $ta = $ta->dat;
            } elseif (!is_array($ta) && $i + 1 == sizeof($tab)) {
                $html .= '<td style="' . $tdId[$i%sizeof($tdId)] . '">' . $ta . '</td></tr>';
                break;
            } elseif (!is_array($ta)) {
                $html .= '<td style="' . $tdId[$i%sizeof($tdId)] . '">' . $ta . '</td></tr>';
            }
            if (is_array($ta)) {
                foreach ($ta as $y) {
                    $k = 0;
                    if (is_array($y)) {
                        $m = '';
                        foreach ($y as $mm) {
                            $m .= $mm;
                            if ($k + 1 < sizeof($y)) {
                                $m .= ', ';
                            }
                            $k++;
                        }
                        $html .= '<td>' . $m . '</td>';
                    } elseif (is_object($y)) {
                        $m = '';
                        foreach ($y->dat as $mm) {
                            $m .= $mm;
                            if ($k + 1 < $y->size()) {
                                $m .= ', ';
                            }
                            $k++;
                        }
                    } else {
                        if (sizeof($tdId) > 0) {
                            $html .= '<td style="' . $tdId[$i%sizeof($tdId)] . '">' . $y . '</td>';
                        } else {
                            $html .= '<td>' . $y . '</td>';
                        }
                    }
                }
                $html .= '</tr>';
                $e++;
            }
        }
        $html .= '</table>';
        return $html;
    }

    /**
     * @method rem
     * @param int
     *
     *
     * Remove $r from Matrix
     */
    public function rem(int $r): bool
    {
        if ($r >= $this->size) {
            throw new Overflow("Requested Bucket $r with only " . $this->size());
        }
        unset($this->dat[$r]);
        return true;
    }

    /**
     * @method hasNext
     * @param none
     *
     *
     * Returns true if Matrix has next Element
     */
    public function hasNext(): bool
    {
        if (0 == $this->size) {
            throw new Overflow("Requested next Bucket with only " . $this->size());
        }
        if ($this->getIndex()+1 < $this->size()) {
            return 1;
        }
        return 0;
    }

    /**
     * @method next
     * @param none
     *
     *
     * Iterate once forward through Vector
     */
    public function next(): bool
    {
        if ($this->hasNext() == 1) {
            $this->cntIncr();
            $this->join();
            return 1;
        } elseif ($this->size() == 1) {
            $this->setIndex(0);
            $this->join();
            return 0;
        } elseif (0 == $this->size()) {
            throw new Overflow("Requested next Bucket with only " . $this->size());
            $this->setIndex(0);
            $this->mx = null;
            return 0;
        }
    }

    /**
     * @method Iter
     * @param none
     *
     *
     * Iterate Forward through Vector
     */
    public function Iter(): bool
    {
        if (0 == $this->size()) {
            throw new Overflow("Requested next Bucket with only " . $this->size());
        }
        if ($this->hasNext() == 1) {
            $this->next();
            $this->join();
            return 1;
        } else {
            $this->join();
            return 0;
        }
        return 1;
    }

    /**
     * @method Cycle
     * @param none
     *
     *
     * Cycle Forward through Vector
     */
    public function Cycle(): bool
    {
        if (0 == $this->size()) {
            throw new Overflow("Requested next Bucket with only " . $this->size());
        }
        if ($this->hasNext() == 1) {
            $this->next();
            $this->join();
            return 1;
        } else {
            $this->setIndex(0);
            $this->join(0);
            return 0;
        }
        return 1;
    }

    /**
     * @method revIter
     * @param none
     *
     *
     * Iterate Forward through Vector
     */
    public function revIter(): bool
    {
        if (0 == $this->size()) {
            throw new Overflow("Requested Bucket -1 with only " . $this->size());
        }
        if ($this->hasPrev() == 1) {
            $this->prev();
            $this->join();
            return 1;
        } else {
            $this->join();
            return 0;
        }
        return 1;
    }

    /**
     * @method revCycle
     * @param none
     *
     */
    public function revCycle(): bool
    {
        if (0 == $this->size()) {
            throw new Overflow("Requested Bucket -1 with only " . $this->size());
        }
        if ($this->hasPrev() == 1) {
            $this->prev();
            $this->join();
            return 1;
        } else {
            $this->setIndex($this->size()-1);
            $this->join();
            return 0;
        }
        return 1;
    }

    /**
     * @method hasPrev
     * @param none
     *
     *
     * Return true if Previous Vector exists
     */
    public function hasPrev(): bool
    {
        if (0 == $this->size()) {
            throw new Overflow("Requested Bucket -1 with only " . $this->size());
            return 0;
        }
        if ($this->getIndex() - 1 > 0) {
            return 1;
        }
        return 0;
    }

    /**
     * @method prev8
     * @param none
     *
     *
     * Iterate to Previous Vector if $bool = 1;
    // Setup $cntDecr (index) for Prev. Vector if $bool = 0;
     */
    public function prev(): bool
    {
        if ($this->hasPrev() == 1) {
            $this->cntDecr();
            $this->join();
            return 1;
        } elseif ($this->size() == 1) {
            $this->setIndex(0);
            $this->join();
            return 0;
        } elseif (0 == $this->size()) {
            throw new Overflow("Requested Bucket with only " . $this->size());
            $this->setIndex(0);
            $this->mx = null;
            return 0;
        }
    }

    /**
     * @method current8
     * @param none
     *
     *
     * Retrieve current Index of Vector Pointer
     */
    public function current(): int
    {
        return $this->getIndex();
    }

    /**
     * @method cntIncr
     * @param none
     *
     *
     * Increment datCntr (index)
     */
    public function cntIncr(): int
    {
        $this->sync();
        next($this->dat);
        return ++$this->datCnt;
    }

    /**
     * @method cntDecr
     * @param none
     *
     *
     * Decrement datCntr (index)
     */
    public function cntDecr(): int
    {
        $this->sync();
        prev($this->dat);
        return --$this->datCnt;
    }

    /**
     * @method getIndex
     * @param none
     *
     *
     * Get Index
     */
    public function getIndex(): int
    {
        return $this->datCnt;
    }

    /**
     * @method setIndex
      * @param int
      *
     *
     * Sets and Joins Map Index
     */
    public function setIndex(int $indx): bool
    {
        if ($this->size() == 0) {
            if ($this->strict == 1) {
                throw new IndexException('Empty Matrix');
            }
            return 0;
        }
        if ($this->sIndex($indx)) {
            $this->join();
            return 1;
        }
        return 0;
    }

    /**
     * @method destroy
      * @param none
     *
     */
    public function destroy(): bool
    {
        $this->vectorTemp = null;
        $this->parentType = null;
        $this->childType = null;
        $this->dat = null;
        return 1;
    }

    /**
     * @method clear
     * @param none
     *
     */
    public function clear(): bool
    {
        $this->dat = array();
        return 1;
    }

    /**
     * @method size
     * @param none
     *
     *
     * Report Size of Container
     */
    public function size(): int
    {
        if (sizeof($this->dat) >= 0) {
            return sizeof($this->dat);
        } else {
            return 0;
        }
    }

    /**
     * @method push
     * @param mixed
     *
     *
     * Add Vector with $r and Join if $bool == 1
     */
    public function push($r): bool
    {
        if ($this->childType == 'String' && !is_object($r)) {
            array_push($this->dat, $r);
        } elseif ($this->childType == 'Any' || $this->childType == $r->childType
            || ($this->childType == 'Array' && is_array($r))) {
            array_push($this->dat, $r);
        } elseif (0 == $this->size()) {
            throw new Overflow("Requested Bucket $r with only " . $this->size());
            return 0;
        }
        if ($this->size() == 1) {
            $this->Iter();
        }
        return 1;
    }

    /**
     * @method pop
     * @param none
     *
     *
     * Remove $r from Vector
     */
    public function pop()
    {
        if (0 == $this->size()) {
            throw new Overflow("Requested Bucket with only " . $this->size());
        }
        return array_pop($this->dat);
    }

    /**
     * @method sIndex
     * @param int
     *
     *
     * Set new Index
     */
    public function sIndex(int $indx): int
    {
        if ($this->size() == 0 || $this->size() <= $indx) {
            $this->datCnt = -1;
            $this->mx = null;
            throw new Overflow("Requested Bucket $indx with only " . $this->size());
            return 0;
        }
        if ($indx < $this->size() && $indx >= 0) {
            reset($this->dat);
            for ($i = 0 ; $i < $indx ; $i++) {
                next($this->dat);
            }
            return $this->datCnt = $indx;
        }
    }

    /**
     * @method at
     * @param int
     *
     *
     * Return Vector at $indx
     */
    public function at(int $indx)
    {
        if (0 == $this->size()) {
            throw new Overflow("Requested Bucket $indx with only " . $this->size());
        }
        $temp = array();
        if ($indx < $this->size() && $indx >= 0) {
            $temp = $this->dat[$indx];
            return $temp;
        }
        return -1;
    }

    /**
     * @method sync
     * @param none
     *
     */
    public function sync(): bool
    {
        if ($this->pv >= 0 && $this->pv < $this->size()) {
            if ($this->mx != null && $this->datCnt != $this->pv) {
                $this->dat[$this->pv] = $this->mx;
            }
        }
        if ($this->datCnt >= $this->size() || $this->datCnt <= 0) {
            $this->datCntr = 0;
            $this->pv = 0;
            $this->mx = array();
            return 1;
        } elseif ($this->datCnt < $this->size() && $this->datCnt > 0) {
            $this->sIndex($this->datCnt);
            $this->mx = $this->dat[$this->datCnt];
            $this->pv = $this->datCnt;
            return 1;
        }
        return 0;
    }

    /**
     * @method join
     * @param none
     *
     *
     * Point Vector to getIndex()
     */
    public function join(): bool
    {
        if (0 == $this->size()) {
            throw new Overflow("Requested Bucket with only " . $this->size());
        }
        if ($this->size() == 1) {
            $this->setIndex(0);
        } elseif ($this->getIndex() == 0 || $this->getIndex() >= $this->size()) {
            $this->sIndex($this->size()-1);
        }

        $this->sync();
        return 1;
    }

    /**
     * @method add
     * @param mixed, int, int
     *
     *
     * $indx = row
     */
    public function add($r, int $indx = -1, int $col = -1): bool
    {
        $this->sync();
        if (0 == $this->size() || $indx >= $this->size()) {
            throw new Overflow("Requested Bucket $indx (row) with only " . $this->size());
        }
        if ($col >= count($this->dat[$indx])) {
            throw new Overflow("Requested Bucket $col (column) with only " . count($this->dat[$indx]));
        }
        if (!is_object($r) && !is_array($r) || $r->childType == $this->typeOf) {
            $this->dat[$indx][$col] = $r;
        } else {
            return 0;
        }
        
        return 1;
    }

    /**
     * @method grow
     * @param int
     *
     */
    public function grow(int $r): bool
    {
        if ($r < 1) {
            return 0;
        }
        for ($x = 0 ; $x < $r ; $x++) {
            array_push($this->dat, $this->newObj($this->childType, 'String'));
        }
        $this->pt = current($this->dat);
        return 1;
    }

    /**
     * @method shrink
     * @param int
     *
     */
    public function shrink(int $r): bool
    {
        if ($r < 1 || $r > $this->size()) {
            return 0;
        }
        $t = array();
        for ($x = 0 ; $x < $r ; $x++) {
            $this->pop();
        }
        
        $this->pt = current($this->dat);
        return 1;
    }
}
