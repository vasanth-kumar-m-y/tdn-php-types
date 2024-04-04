<?php

namespace Tdn\PhpTypes\Tests\Type;

use Tdn\PhpTypes\Exception\InvalidTypeCastException;
use Tdn\PhpTypes\Type\BooleanType;
use Tdn\PhpTypes\Type\StringType;
use Tdn\PhpTypes\Type\Type;

/**
 * Class BooleanTypeTest.
 */
class BooleanTypeTest extends AbstractTypeTest
{
    public function testBox()
    {
        /* @var BooleanType $bool */
        BooleanType::box($bool, new BooleanType(false));
        $this->assertTrue(($bool instanceof BooleanType));
        $this->assertTrue($bool->isFalse());

        $bool = true;
        $this->assertTrue(($bool instanceof BooleanType));
        $this->assertTrue($bool->isTrue());

        $bool = new BooleanType(false);
        $this->assertTrue(($bool instanceof BooleanType));
        $this->assertTrue($bool->isFalse());

        /* @var $otherBool BooleanType */
        BooleanType::box($otherBool, true);
        $this->assertTrue(($otherBool instanceof BooleanType));
        $this->assertTrue($otherBool->isTrue());
    }

    public function testUnbox()
    {
        /* @var BooleanType $bool */
        BooleanType::box($bool, true);
        $this->assertEquals('true', $bool(Type::STRING));
        $this->assertEquals(true, $bool());
        $bool = false;
        $this->assertEquals('false', $bool(Type::STRING));
        $this->assertEquals(false, $bool());

        $this->assertEquals('false', $bool->toString());
        $this->assertEquals(false, $bool->toBool());

        try {
            $bool(Type::INT);
            $this->fail('should not cast.');
        } catch (InvalidTypeCastException $e) {
            $this->assertEquals('Could not cast BooleanType to int.', $e->getMessage());
        }

        try {
            $bool->toInt();
            $this->fail('should not cast.');
        } catch (InvalidTypeCastException $e) {
            $this->assertEquals('Could not cast BooleanType to int.', $e->getMessage());
        }

        try {
            $bool(Type::FLOAT);
            $this->fail('should not cast.');
        } catch (InvalidTypeCastException $e) {
            $this->assertEquals('Could not cast BooleanType to float.', $e->getMessage());
        }

        try {
            $bool->toFloat();
            $this->fail('should not cast.');
        } catch (InvalidTypeCastException $e) {
            $this->assertEquals('Could not cast BooleanType to float.', $e->getMessage());
        }

        try {
            $bool(Type::ARRAY);
            $this->fail('should not cast.');
        } catch (InvalidTypeCastException $e) {
            $this->assertEquals('Could not cast BooleanType to array.', $e->getMessage());
        }

        try {
            $bool->toArray();
            $this->fail('should not cast.');
        } catch (InvalidTypeCastException $e) {
            $this->assertEquals('Could not cast BooleanType to array.', $e->getMessage());
        }
    }

    /**
     * @expectedException \TypeError
     * @expectedExceptionMessageRegExp /Argument ([0-9]+) passed to (.*) must be of the type (.*), string given.*$/
     */
    public function testBoxBreakType()
    {
        BooleanType::box($bool, false);
        $bool = 'false';
        $this->fail($bool);
    }

    /**
     * @expectedException \TypeError
     * @expectedExceptionMessageRegExp /Too few arguments to function (.*)*$/
     */
    public function testBadBoxCall()
    {
        BooleanType::box($bool);
    }

    public function testBoolean()
    {
        $this->assertTrue((new BooleanType(true))());
        $this->assertFalse((new BooleanType(false))());
        $this->assertFalse((new BooleanType(true))->isFalse());
        $this->assertTrue((new BooleanType(true))->isTrue());
        $this->assertTrue((new BooleanType(true))->get());
    }

    public function testFrom()
    {
        $this->assertEquals(new BooleanType(false), BooleanType::valueOf(false));
        $this->assertEquals(new BooleanType(false), BooleanType::valueOf('false'));
        $this->assertEquals(new BooleanType(true), BooleanType::valueOf('true'));
        $this->assertEquals(new BooleanType(true), BooleanType::valueOf(tmpfile()));
        $this->assertEquals(new BooleanType(true), BooleanType::valueOf(StringType::create('on')));
        $this->assertEquals(new BooleanType(true), BooleanType::valueOf(new BooleanType(true)));
        $this->assertEquals(
            new BooleanType(false),
            BooleanType::valueOf('any string that is not "true" evalutes to false')
        );
    }

    /**
     * @expectedException \Tdn\PhpTypes\Exception\InvalidTransformationException
     * @expectedExceptionMessage Could not transform array to BooleanType.
     */
    public function testBadFromArray()
    {
        BooleanType::valueOf([]);
    }

    /**
     * @expectedException \Tdn\PhpTypes\Exception\InvalidTransformationException
     * @expectedExceptionMessage Could not transform integer to BooleanType.
     */
    public function testBadFromInteger()
    {
        BooleanType::valueOf(99);
    }

    /**
     * @expectedException \Tdn\PhpTypes\Exception\InvalidTransformationException
     * @expectedExceptionMessage Could not transform float to BooleanType.
     */
    public function testBadFromDouble()
    {
        BooleanType::valueOf(3E-5);
    }

    /**
     * @expectedException \Tdn\PhpTypes\Exception\InvalidTransformationException
     * @expectedExceptionMessage Could not transform float to BooleanType.
     */
    public function testBadFromFloat()
    {
        BooleanType::valueOf(3.559);
    }

    /**
     * @expectedException \Tdn\PhpTypes\Exception\InvalidTransformationException
     * @expectedExceptionMessage Could not transform object to BooleanType.
     */
    public function testBadFromObject()
    {
        BooleanType::valueOf(new \stdClass());
    }

    /**
     * @expectedException \Tdn\PhpTypes\Exception\InvalidTransformationException
     * @expectedExceptionMessage Could not transform null to BooleanType.
     */
    public function testBadFromNull()
    {
        BooleanType::valueOf(null);
    }
}
