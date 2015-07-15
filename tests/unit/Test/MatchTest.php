<?php
namespace Test\Mcustiel\PhpSimpleRegex;

use Mcustiel\PhpSimpleRegex\Match;

class MatchTest extends \PHPUnit_Framework_TestCase
{
    const PATTERN = '|A(\d+)B(\d+)|';
    const SUBJECT = 'A123B456';

    /**
     * @var \Mcustiel\PhpSimpleRegex\Match
     */
    private $result;

    /**
     * @before
     */
    public function buildResult()
    {
        $matches = array();
        preg_match_all(self::PATTERN, self::SUBJECT, $matches, PREG_SET_ORDER | PREG_OFFSET_CAPTURE);
        $this->result = new Match($matches[0]);
    }

    /**
     * @test
     */
    public function shouldReturnTheFullMatch()
    {
        $this->assertEquals(self::SUBJECT, $this->result->getFullMatch());
    }

    /**
     * @test
     */
    public function shouldReturnTheOffsetOfTheInnerMatch()
    {
        $this->assertEquals(1, $this->result->getSubmatchOffsetAt(1));
        $this->assertEquals(5, $this->result->getSubmatchOffsetAt(2));
    }


    /**
     * @test
     */
    public function shouldReturnTheInnerMatch()
    {
        $this->assertEquals('123', $this->result->getSubMatchAt(1));
        $this->assertEquals('456', $this->result->getSubMatchAt(2));
    }

    /**
     * @test
     * @expectedException        \OutOfBoundsException
     * @expectedExceptionMessage Trying to access invalid submatch index
     */
    public function shouldThrowAnExceptionWhenOffsetIsNotValid()
    {
        $this->result->getSubMatchAt(3);
    }

    /**
     * @test
     * @expectedException        \OutOfBoundsException
     * @expectedExceptionMessage Trying to access invalid submatch index
     */
    public function shouldThrowAnExceptionWhenOffsetIsZero()
    {
        $this->result->getSubMatchAt(0);
    }
}
