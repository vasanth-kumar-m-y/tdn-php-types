<?php

namespace Tdn\PhpTypes\Tests\Math\Library;

use Tdn\PhpTypes\Math\Library\Spl;

class SplTest extends AbstractPrecisionMathLibraryTest
{
    protected function setUp()
    {
        $this->mathLibrary = new Spl(PHP_ROUND_HALF_UP);
    }

    public function testCompare()
    {
        //Can compare versions
        $this->assertEquals('1', $this->mathLibrary->compare('1.30.5', '1.29.99', 5));
        $this->assertEquals('1', $this->mathLibrary->compare('1.105.02', '1.049.9', 5));
        parent::testCompare();
    }

    public function testNextPrime()
    {
        $this->assertEquals('7', $this->mathLibrary->nextPrime('5.5'));
    }

    public function testGcd()
    {
        $this->assertEquals('2.2', $this->mathLibrary->gcd('4.4', '6.66'));
        $this->assertEquals('2.2', $this->mathLibrary->gcd('6.6', '4.44'));
        $this->assertEquals('2.2', $this->mathLibrary->gcd('6.666', '4.4'));
        $this->assertEquals('2.22', $this->mathLibrary->gcd('6.66', '4.44'));

        parent::testGcd();
    }

    public function testFactorial()
    {
        $this->assertEquals('3.3233509704478', $this->mathLibrary->factorial('2.5'));
        $this->assertEquals('24.0', $this->mathLibrary->factorial('4.0'));
        $this->assertEquals('287.88527781504', $this->mathLibrary->factorial('5.5'));
        parent::testFactorial();
    }

    public function testModulus()
    {
        $this->assertEquals('5.5', $this->mathLibrary->modulus('5.5', '10', 1));
        parent::testModulus();
    }

    public function testGamma()
    {
        $this->assertEquals('1.7724538509055', $this->mathLibrary->gamma('.5'));
        $this->assertEquals('10.136101851155', $this->mathLibrary->gamma('4.4'));
        $this->assertEquals('334838609873.69', $this->mathLibrary->gamma('15.5'));
        $this->assertEquals('5.5620924145341E+305', $this->mathLibrary->gamma('170.5'));
        $this->assertEquals('999999.42278467', $this->mathLibrary->gamma('.000001'));
    }

    /**
     * @expectedException \Tdn\PhpTypes\Exception\InvalidNumberException
     * @expectedExceptionMessage Operand must be a positive number.
     */
    public function testBadZeroGamma()
    {
        $this->mathLibrary->gamma('0');
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Number too large.
     */
    public function testBadGamma()
    {
        $this->mathLibrary->gamma('172');
    }

    /**
     * @expectedException \Tdn\PhpTypes\Exception\InvalidNumberException
     * @expectedExceptionMessage Operand must be a positive number.
     */
    public function testBadZeroLogGamma()
    {
        $this->mathLibrary->logGamma('0');
    }

    public function testLogGamma()
    {
        $this->assertEquals('0.57236494292469', $this->mathLibrary->logGamma('.5'));
        $this->assertEquals('2.3161034914248', $this->mathLibrary->logGamma('4.4'));
        $this->assertEquals('26.536914491116', $this->mathLibrary->logGamma('15.5'));
    }

    /**
     * @expectedException \RuntimeException
     * @expectedExceptionMessage Not a valid library for root^n.
     */
    public function testRoot()
    {
        parent::testRoot();
    }
}
