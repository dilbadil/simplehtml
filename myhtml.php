<?php

class MyHtml {
	private $tagName;
	private $attributes;
	private $stringHtml;
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

			$attributes[$attribute] = $expHtml[$i + 1];

			$i = $i+1;
			
		}
	
		$this->attributes = $attributes;

	}

	public function getAttributes ()
	{

		return $this->attributes;
	}

	public function getTagName ()
	{
	
		return $this->tagName;
	}

	public function getString ()
	{
	
		return $this->stringHtml;

	}

	public function getAttribute ($name)
	{

		$attributes = $this->getAttributes();

		return $attributes[$name];

	}

	public function setAttribute ($name, $value)
	{

		if (isset($this->attributes[$name])) {
		
			$valueOri = $this->attributes[$name];
			$this->attributes[$name] = $value;
			$html = $this->stringHtml;
			$html = str_replace("{$name}~DELIM_ATTR~{$valueOri}", "{$name}~DELIM_ATTR~{$value}", $html);
			$this->stringHtml = $html;
		
		}
	}

	private function search_substring ($dicari, $string)
	{
	
		if (strpos($string, $dicari) !== FALSE) 
			return true;
		else 
			return false;
	}

}

