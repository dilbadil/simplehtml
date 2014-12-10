<?php


class MyHtml {

	/**
	 * @var $tagName
	 */
	private $tagName;

	/**
	 * @var $attributes
	 */
	private $attributes;

	/**
	 * @var $stringHtml
	 */
	private $stringHtml;

	/**
	 * @var htmlExplode
	 */
	private $htmlExplode;


	public function __construct ($stringHtml)
	{
	
		$stringHtml = str_replace("'", '"', $stringHtml);
		$stringHtml = str_replace('="', '~DELIM_ATTR~', $stringHtml);
		$stringHtml = str_replace('"', '~DELIM_ATTR~', $stringHtml);
		$stringHtml = str_replace('~DELIM_ATTR~ ', '~DELIM_ATTR~', $stringHtml);

		$stringHtml = str_replace('<', '', $stringHtml);
		$stringHtml = str_replace('>', '', $stringHtml);
		$stringHtml = str_replace('/>', '', $stringHtml);		

		$this->stringHtml = $stringHtml;
		$expHtml = explode('~DELIM_ATTR~', $stringHtml);

		$this->htmlExplode = $expHtml;
		$this->setAttributes($expHtml);
	
	}


	/**
	 * set attributes of the html
	 * 
	 * @param string $exHtml
	 */
	private function setAttributes ($expHtml)
	{
	
		$attributes = array();

		for ($i = 0; $i < count($expHtml); $i++) {

			$attribute = $expHtml[$i];

			if ($i == 0) {

				$expAttribute = explode(' ', $attribute);
				$this->tagName = $expAttribute[0];
				$attribute = $expAttribute[1];
			}

			if (! isset($expHtml[$i + 1]))
				continue;			

			$attributes[$attribute] = $expHtml[$i + 1];

			$i = $i+1;
			
		}
	
		$this->attributes = $attributes;

	}


	/**
	 * Get attributes from html
	 * 
	 * @return array
	 */
	public function getAttributes ()
	{

		return $this->attributes;
	}


	/**
	 * Get tag name
	 * 
	 * @return string
	 */
	public function getTagName ()
	{
	
		return $this->tagName;
	}


	/**
	 * Get html on string format
	 * 
	 * @return string
	 */
	public function getString ()
	{
	
		return $this->stringHtml;

	}


	/**
	 * Get atttribute by their name
	 * 
	 * @param $name
	 * @return string
	 */
	public function getAttribute ($name)
	{

		$attributes = $this->getAttributes();

		return $attributes[$name];

	}


	/**
	 * Set attribute of the html
	 * 
	 * @param $name
	 * @param $value
	 * @return mixed
	 */
	public function setAttribute ($name, $value)
	{

		if (isset($this->attributes[$name])) {
		
			$valueOri = $this->attributes[$name];
			$this->attributes[$name] = $value;
			$html = $this->stringHtml;
			$html = str_replace("{$name}~DELIM_ATTR~{$valueOri}", "{$name}~DELIM_ATTR~{$value}", $html);
			$this->stringHtml = $html;
		
		}

		return $this;

	}


	/**
	 * Search substrin of string
	 * 
	 * @param $dicari
	 * @param $string
	 * @return bool
	 */
	private function search_substring ($dicari, $string)
	{
	
		if (strpos($string, $dicari) !== FALSE) 
			return true;
		else 
			return false;
	}

}

