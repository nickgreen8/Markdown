<?php
namespace N8G\Markdown;

/**
 * This class is to be used to implement a markdown parser. Even though there are a number of different variations of
 * this kind of tool, the aim is to solve some common issues that I can utilise within my own projects.
 *
 * @author Nick Green <nick@nick8green.co.uk>
 */
class Markdown
{
	private $syntax = array(
		'#',
		'-',
		'*',
		'+',
		'>',
		'1',
		'2',
		'3',
		'4',
		'5',
		'6',
		'7',
		'8',
		'9',
		'0'
	);

	/**
	 * Converts text into HTML for display.
	 *
	 * @param  string $text The text to be processed.
	 * @return string       The text passed as HTML.
	 */
	public function convert($text)
	{
		//Set the required variables
		$html = '';

		//Get the text as lines
		$lines = $this->lines($text);

		//Loop through the lines to convert
		foreach ($lines as $key => $line) {
			//Convert special chars
			$line = $this->specialChars($line);

			//Get the tag
			$tag = $this->getTag($line);

			//Strip all markdown syntax
			$line = $this->stripSyntax($line);

			//Add to HTML
			$html .= sprintf('<%s>%s</%s>', $tag, $line, $tag);
		}

		//Return the converted HTML
		return $html;
	}

	/**
	 * Converts the text to be converted into an array of lines.
	 *
	 * @param  string $text The text to process into lines.
	 * @return array        An array of lines to be converted into HTML.
	 */
	private function lines($text)
	{
		//Make sure all line brakes are standardised
		$text = str_replace(array("\r\n", "\r"), "\n", $text);

        //Remove all unnecessary space
        $text = trim($text, "\n");

        //Return the lines
        return explode("\n", $text);
	}

	/**
	 * Replace all protected characters.
	 *
	 * @param  string $text The text to inspected
	 * @return string       The converted string
	 */
	private function specialChars($text)
	{
		$text = str_replace('&', '&amp;', $text);
		$text = str_replace('<', '&lt;', $text);
		return $text;
	}

	/**
	 * Determines the tag that should be used for the text passed.
	 *
	 * @param  string $text The line of text.
	 * @return string       The HTML tag to be used.
	 */
	private function getTag($text)
	{
		//Get the first character of the text
		$char = substr($text, 0, 1);

		//Check for markdown syntax
		if ($char === '#') {
			preg_match("/^(#+)\s/", $text, $heading);
			return sprintf('h%d', substr_count($heading[1], '#'));
		} else {
			return 'p';
		}
	}

	/**
	 * Strips the markdown syntax from a line.
	 *
	 * @param  string $line The line of text.
	 * @return string       The line with the syntax removed.
	 */
	private function stripSyntax($line)
	{
		//Get the first character of the text
		$char = substr($line, 0, 1);

		//Check for markdown syntax
		if ($char === '#') {
			preg_match("/^(#+\s)/", $line, $heading);
			return str_replace($heading[1], '', $line);
		}

		//Return the default
		return $line;
	}
}