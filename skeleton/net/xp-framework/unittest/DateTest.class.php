<?php
/* This class is part of the XP framework
 *
 * $Id$ 
 */
 
  uses(
    'util.profiling.unittest.TestCase',
    'util.Date',
    'util.Calendar'
  );

  /**
   * Test framework code
   *
   * @purpose  Unit Test
   */
  class DateTest extends TestCase {
    var
      $nowTime  = 0,
      $nowDate  = NULL,
      $refDate  = NULL;
      
    /**
     * Set up this test
     *
     * @access  public
     */
    function setUp() {
      $this->nowTime= time();
      $this->nowDate= &new Date($this->nowTime);
      $this->refDate= &Date::fromString('1977-12-14 11:55');
    }
    
    /**
     * Test date class
     *
     * @see     xp://util.Date
     * @access  public
     */
    function testDate() {
      $this->assertEquals($this->nowDate->getTime(), $this->nowTime);
      $this->assertEquals($this->nowDate->toString('r'), date('r', $this->nowTime));
      $this->assertEquals($this->nowDate->format('%c'), strftime('%c', $this->nowTime));
      $this->assertTrue($this->nowDate->isAfter(Date::fromString('yesterday')));
      $this->assertTrue($this->nowDate->isBefore(Date::fromString('tomorrow')));
    }
    
    /**
     * Helper method
     *
     * @access  private
     * @param   &util.Date d
     * @param   string str
     * @param   string error default 'datenotequal'
     * @return  bool
     */
    function assertDateEquals(&$d, $str, $error= 'datenotequal') {
      return $this->assertEquals($d->format('%Y-%m-%d %H:%M:%S'), $str, $error);
    }
    
    /**
     * Test calendar class
     *
     * @see     xp://util.Calendar
     * @access  public
     */
    function testCalendarBasic() {
      $this->assertDateEquals(Calendar::midnight($this->refDate), '1977-12-14 00:00:00', 'midnight');
      $this->assertDateEquals(Calendar::monthBegin($this->refDate), '1977-12-01 00:00:00', 'monthbegin');
      $this->assertDateEquals(Calendar::monthEnd($this->refDate), '1977-12-31 23:59:59', 'monthend');
      $this->assertEquals(Calendar::week($this->refDate), 50, 'week');
    }
    
    /**
     * Test calendar class (easter day calculation)
     *
     * @see     xp://util.Calendar
     * @access  public
     */
    function testCalendarEaster() {
      $easter= &Calendar::easter(2003);
      $this->assertDateEquals($easter, '2003-04-20 00:00:00', 'easter');
      return $easter;
    }
    
    /**
     * Test calendar class (first of advent calculation)
     *
     * @see     xp://util.Calendar
     * @access  public
     */
    function testCalendarAdvent() {
      $advent= &Calendar::advent(2003);
      $this->assertDateEquals($advent, '2003-11-30 00:00:00', 'advent');
      return $advent;
    }
    
    /**
     * Test calendar class (DST / daylight savings times)
     *
     * @see     xp://util.Calendar
     * @access  public
     */
    function testCalendarDSTBegin() {
      $begin= &Calendar::dstBegin(2003);
      $this->assertDateEquals($begin, '2003-03-30 00:00:00', 'dstbegin');
      return $begin;
    }

    /**
     * Test calendar class (DST / daylight savings times)
     *
     * @see     xp://util.Calendar
     * @access  public
     */
    function testCalendarDSTEnd() {
      $end= &Calendar::dstEnd(2003);
      $this->assertDateEquals($end, '2003-10-26 00:00:00', 'dstend');
      return $end;
    }
  }
?>
