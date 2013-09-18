<?php
namespace Respect\Validation\Rules;

class DomainTest extends \PHPUnit_Framework_TestCase
{
    protected $object;

    protected function setUp()
    {
        $this->object = new Domain;
    }

    /**
     * @dataProvider providerForDomain
     *
     */
    public function testValidDomainsShouldReturnTrue($input, $tldcheck=true)
    {
        $this->object->tldCheck($tldcheck);
        $this->assertTrue($this->object->__invoke($input));
        $this->assertTrue($this->object->assert($input));
        $this->assertTrue($this->object->check($input));
    }

    /**
     * @dataProvider providerForNotDomain
     * @expectedException Respect\Validation\Exceptions\ValidationException
     */
    public function testNotDomain($input, $tldcheck=true)
    {
        $this->object->tldCheck($tldcheck);
        $this->assertFalse($this->object->check($input));
    }

    /**
     * @dataProvider providerForNotDomain
     * @expectedException Respect\Validation\Exceptions\DomainException
     */
    public function testNotDomainCheck($input, $tldcheck=true)
    {
        $this->object->tldCheck($tldcheck);
        $this->assertFalse($this->object->assert($input));
    }

    public function providerForDomain()
    {
        return array(
            array('111111111111domain.local', false),
            array('111111111111.domain.local', false),
            array('example.com'),
            array('example-hyphen.com'),
        );
    }

    public function providerForNotDomain()
    {
        return array(
            array(null),
            array(''),
            array('2222222domain.local'),
            array('example--invalid.com'),
            array('-example-invalid.com'),
            array('example.invalid.-com'),
            array('1.2.3.256'),
            array('1.2.3.4'),
        );
    }
}

