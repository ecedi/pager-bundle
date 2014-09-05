<?php

namespace Ecedi\PagerBundle\Tests\Helper;

use Ecedi\PagerBundle\Helper\Pager;

class PagerTest extends \PHPUnit_Framework_TestCase
{
    public function testMain()
    {
        $pager = new Pager(103, 10, 10, 0); // count, currentCount, limit, offset

        $this->assertEquals(103, $pager->getCount());

        $this->assertEquals(0, $pager->getOffset());
        $this->assertEquals(0, $pager->getOffsetPageFirst());
        $this->assertEquals(0, $pager->getOffsetPagePrev());
        $this->assertEquals(10, $pager->getOffsetPageNext());
        $this->assertEquals(100, $pager->getOffsetPageLast());
        $this->assertEquals(1, $pager->getCurrentPage());
        $this->assertEquals(array(1 => 0), $pager->getPageRange(1));
        $this->assertEquals(array(1 => 0, 2 => 10), $pager->getPageRange(2));
        $this->assertEquals(array(1 => 0, 2 => 10, 3 => 20), $pager->getPageRange(3));
        $this->assertEquals(array(1 => 0, 2 => 10, 3 => 20, 4 => 30), $pager->getPageRange(4));
        $this->assertEquals(array(1 => 0, 2 => 10, 3 => 20, 4 => 30, 5 => 40), $pager->getPageRange(5));

        $pager->setOffset(100);
        $this->assertEquals(0, $pager->getOffsetPageFirst());
        $this->assertEquals(90, $pager->getOffsetPagePrev());
        $this->assertEquals(100, $pager->getOffsetPageNext());
        $this->assertEquals(100, $pager->getOffsetPageLast());
        $this->assertEquals(11, $pager->getCurrentPage());
        $this->assertEquals(array(11 => 100), $pager->getPageRange(1));
        $this->assertEquals(array(10 => 90, 11 => 100), $pager->getPageRange(2));
        $this->assertEquals(array(9 => 80, 10 => 90, 11 => 100), $pager->getPageRange(3));
        $this->assertEquals(array(8 => 70, 9 => 80, 10 => 90, 11 => 100), $pager->getPageRange(4));
        $this->assertEquals(array(7 => 60, 8 => 70, 9 => 80, 10 => 90, 11 => 100), $pager->getPageRange(5));

        $pager->setOffset(50);
        $this->assertEquals(6, $pager->getCurrentPage());
        $this->assertEquals(array(6 => 50), $pager->getPageRange(1));
        $this->assertEquals(array(5 => 40, 6 => 50), $pager->getPageRange(2));
        $this->assertEquals(array(5 => 40, 6 => 50, 7 => 60), $pager->getPageRange(3));
        $this->assertEquals(array(4 => 30, 5 => 40, 6 => 50, 7 => 60), $pager->getPageRange(4));
        $this->assertEquals(array(4 => 30, 5 => 40, 6 => 50, 7 => 60, 8 => 70), $pager->getPageRange(5));

        $pager->setLimit(100);
        $pager->setOffset(0);
        $this->assertEquals(1, $pager->getCurrentPage());
        $this->assertEquals(array(1 => 0), $pager->getPageRange(1));
        $this->assertEquals(array(1 => 0, 2 => 100), $pager->getPageRange(2));
        $this->assertEquals(array(1 => 0, 2 => 100), $pager->getPageRange(3));
        $this->assertEquals(array(1 => 0, 2 => 100), $pager->getPageRange(4));
        $this->assertEquals(array(1 => 0, 2 => 100), $pager->getPageRange(5));
        
        $pager->setOffset(100);
        $this->assertEquals(2, $pager->getCurrentPage());
        $this->assertEquals(array(2 => 100), $pager->getPageRange(1));
        $this->assertEquals(array(1 => 0, 2 => 100), $pager->getPageRange(2));
        $this->assertEquals(array(1 => 0, 2 => 100), $pager->getPageRange(3));
        $this->assertEquals(array(1 => 0, 2 => 100), $pager->getPageRange(4));
        $this->assertEquals(array(1 => 0, 2 => 100), $pager->getPageRange(5));

    }
}
