<?php
/**
 * @package    Zend_Cache
 * @subpackage UnitTests
 */

/** @see Zend_Serializer_Adapter_Wddx */
require_once 'Zend/Serializer/Adapter/Wddx.php';

/**
 * PHPUnit test case
 */
require_once 'PHPUnit/Framework/TestCase.php';

/**
 * @package    Zend_Serializer
 * @subpackage UnitTests
 */
class Zend_Serializer_Adapter_WddxTest extends PHPUnit_Framework_TestCase
{

    private $_adapter;

    public function setUp()
    {
        $this->_adapter = new Zend_Serializer_Adapter_Wddx();
    }

    public function tearDown()
    {
        $this->_adapter = null;
    }

    public function testSerializeString() {
        $value    = 'test';
        $expected = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><string>test</string></data></wddxPacket>';

        $data = $this->_adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testSerializeStringWithComment() {
        $value    = 'test';
        $expected = '<wddxPacket version=\'1.0\'><header><comment>a test comment</comment></header>'
                  . '<data><string>test</string></data></wddxPacket>';

        $data = $this->_adapter->serialize($value, array('comment' => 'a test comment'));
        $this->assertEquals($expected, $data);
    }

    public function testSerializeFalse() {
        $value    = false;
        $expected = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><boolean value=\'false\'/></data></wddxPacket>';

        $data = $this->_adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testSerializeTrue() {
        $value    = true;
        $expected = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><boolean value=\'true\'/></data></wddxPacket>';

        $data = $this->_adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testSerializeNull() {
        $value    = null;
        $expected = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><null/></data></wddxPacket>';

        $data = $this->_adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testSerializeNumeric() {
        $value    = 100;
        $expected = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><number>100</number></data></wddxPacket>';

        $data = $this->_adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testSerializeObject() {
        $value = new stdClass();
        $value->test = "test";
        $expected = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><struct>'
                  . '<var name=\'php_class_name\'><string>stdClass</string></var>'
                  . '<var name=\'test\'><string>test</string></var>'
                  . '</struct></data></wddxPacket>';

        $data = $this->_adapter->serialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeString() {
        $value    = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><string>test</string></data></wddxPacket>';
        $expected = 'test';

        $data = $this->_adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeFalse() {
        $value    = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><boolean value=\'false\'/></data></wddxPacket>';
        $expected = false;

        $data = $this->_adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeTrue() {
        $value    = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><boolean value=\'true\'/></data></wddxPacket>';
        $expected = true;

        $data = $this->_adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeNull1() {
        $value    = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><null/></data></wddxPacket>';
        $expected = null;

        $data = $this->_adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    /**
     * test to unserialize a valid null value by an valid wddx
     * but with some differenzes to the null cenerated by php
     * -> the invalid check have to success for all valid wddx null
     */
    public function testUnserializeNull2() {
        $value    = '<wddxPacket version=\'1.0\'><header/>' . "\n"
                  . '<data><null/></data></wddxPacket>';
        $expected = null;

        $data = $this->_adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeNumeric() {
        $value    = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><number>100</number></data></wddxPacket>';
        $expected = 100;

        $data = $this->_adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserializeObject() {
        $value    = '<wddxPacket version=\'1.0\'><header/>'
                  . '<data><struct>'
                  . '<var name=\'php_class_name\'><string>stdClass</string></var>'
                  . '<var name=\'test\'><string>test</string></var>'
                  . '</struct></data></wddxPacket>';
        $expected = new stdClass();
        $expected->test = 'test';

        $data = $this->_adapter->unserialize($value);
        $this->assertEquals($expected, $data);
    }

    public function testUnserialzeInvalid() {
        $value = 'not a serialized string';
        $this->setExpectedException('Zend_Serializer_Exception');
        $this->_adapter->unserialize($value);
    }

}


/**
 * @category   Zend
 * @package    Zend_Serializer
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2005-2010 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Serializer_Adapter_WddxSkipTest extends PHPUnit_Framework_TestCase
{
    public $message = null;

    public function setUp()
    {
        $message = 'Skipped Zend_Serializer_Adapter_WddxTest';
        if ($this->message) {
            $message.= ': ' . $this->message;
        }
        $this->markTestSkipped($message);
    }

    public function testEmpty()
    {
        // this is here only so we have at least one test
    }
}

