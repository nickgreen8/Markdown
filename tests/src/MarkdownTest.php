<?php
namespace Tests;

use N8G\Markdown\Markdown;

class MarkdownTests extends \PHPUnit_Framework_TestCase
{
	use \N8G\PHPUnitHelper\Helper;

// Tests

	/**
	 * Test convertion of strings to HTML.
	 *
	 * @test
	 * @dataProvider convertProvider
	 *
	 * @param  string $text The text to be parsed.
	 * @param  string $html The expected HTML to be returned.
	 * @return void
	 */
	public function testConvert($text, $html)
	{
		//Create a new instance of the Markdown class
		$markdown = new Markdown();

		//Parse the text
		$actual = $markdown->convert($text);

		//Assert the return
		$this->assertEquals($html, $actual);
	}

	/**
	 * Test convertion of strings to an array of lines.
	 *
	 * @test
	 * @dataProvider linesProvider
	 *
	 * @param  string $text     The text to be parsed.
	 * @param  array  $expected The expected array to be returned.
	 * @return void
	 */
	public function testLines($text, $expected)
	{
		//Create a new instance of the Markdown class
		$markdown = new Markdown();

		//Parse the text
		$actual = $this->invokeMethod($markdown, 'lines', array('text' => $text));

		//Assert the return
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Tests the conversion of the special characters.
	 *
	 * @test
	 * @dataProvider specialCharsProvider
	 *
	 * @param  string $text     The text to convert.
	 * @param  string $expected The expected return.
	 * @return void
	 */
	public function testSpecialChars($text, $expected)
	{
		//Create a new instance of the Markdown class
		$markdown = new Markdown();

		//Parse the text
		$actual = $this->invokeMethod($markdown, 'specialChars', array('text' => $text));

		//Assert the return
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Tests the determination of the HTML tag.
	 *
	 * @test
	 * @dataProvider tagProvider
	 *
	 * @param  string $text     The text representing a line.
	 * @param  string $expected The expected return.
	 * @return void
	 */
	public function testGetTag($text, $expected)
	{
		//Create a new instance of the Markdown class
		$markdown = new Markdown();

		//Parse the text
		$actual = $this->invokeMethod($markdown, 'getTag', array('text' => $text));

		//Assert the return
		$this->assertEquals($expected, $actual);
	}

	/**
	 * Tests the Stripping of the markdown syntax from a line.
	 *
	 * @test
	 * @dataProvider stripSyntaxProvider
	 *
	 * @param  string $text     The text representing a line.
	 * @param  string $expected The expected return.
	 * @return void
	 */
	public function testStripSyntax($text, $expected)
	{
		//Create a new instance of the Markdown class
		$markdown = new Markdown();

		//Parse the text
		$actual = $this->invokeMethod($markdown, 'stripSyntax', array('line' => $text));

		//Assert the return
		$this->assertEquals($expected, $actual);
	}

// Data Providers

	/**
	 * Data provider for the convert tests. The provider will send both the text to be parsed and the converted result.
	 * @return array The data to be used in the tests.
	 */
	public function convertProvider()
	{
		return array(
			array(
				'text' => 'This is a test',
				'html' => '<p>This is a test</p>'
			),
			array(
				'text' => '# Test',
				'html' => '<h1>Test</h1>'
			),
			array(
				'text' => '## Test',
				'html' => '<h2>Test</h2>'
			),
			array(
				'text' => '### Test',
				'html' => '<h3>Test</h3>'
			),
			array(
				'text' => '#### Test',
				'html' => '<h4>Test</h4>'
			),
			array(
				'text' => '##### Test',
				'html' => '<h5>Test</h5>'
			),
			array(
				'text' => '###### Test',
				'html' => '<h6>Test</h6>'
			)
		);
	}

	/**
	 * Data provider for the lines tests. The provider will send both the text to be parsed and the expected result.
	 * @return array The data to be used in the tests.
	 */
	public function linesProvider()
	{
		return array(
			array(
				'text' => 'This is a test',
				'expected' => array(
					'This is a test'
				)
			)
		);
	}

	/**
	 * Data provider for the special character convertion tests. The provider will send both the text to be inspected
	 * and the expected result.
	 * @return array The data to be used in the tests.
	 */
	public function specialCharsProvider()
	{
		return array(
			array(
				'text' => '&',
				'expected' => '&amp;'
			),
			array(
				'text' => '<',
				'expected' => '&lt;'
			),
			array(
				'text' => '&copy;',
				'expected' => '&copy;'
			)
		);
	}

	/**
	 * Data provider for the get tag tests. The provider will send both the text acting as a 'line' and the expected
	 * result.
	 * @return array The data to be used in the tests.
	 */
	public function tagProvider()
	{
		return array(
			array(
				'text' => 'This is a test',
				'expected' => 'p'
			),
			array(
				'text' => '# Test',
				'expected' => 'h1'
			),
			array(
				'text' => '## Test',
				'expected' => 'h2'
			),
			array(
				'text' => '### Test',
				'expected' => 'h3'
			),
			array(
				'text' => '#### Test',
				'expected' => 'h4'
			),
			array(
				'text' => '##### Test',
				'expected' => 'h5'
			),
			array(
				'text' => '###### Test',
				'expected' => 'h6'
			)
		);
	}

	/**
	 * Data provider for the strip syntax tests. The provider will send both the text acting as a 'line' and the
	 * expected result.
	 * @return array The data to be used in the tests.
	 */
	public function stripSyntaxProvider()
	{
		return array(
			array(
				'text' => '# Test',
				'expected' => 'Test'
			),
			array(
				'text' => '## Test',
				'expected' => 'Test'
			),
			array(
				'text' => '### Test',
				'expected' => 'Test'
			),
			array(
				'text' => '#### Test',
				'expected' => 'Test'
			),
			array(
				'text' => '##### Test',
				'expected' => 'Test'
			),
			array(
				'text' => '###### Test',
				'expected' => 'Test'
			)
		);
	}
}
