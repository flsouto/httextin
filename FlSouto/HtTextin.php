<?php

namespace FlSouto;

class HtTextin extends HtWidget{

	private $formatter;

	function formatter($formatter){
		if(!is_callable($formatter)){
			throw new \InvalidArgumentException("Formatter must be a callable");
		}
		$this->formatter = $formatter;
		return $this;
	}

	function format($value){
		if($formatter = $this->formatter){
			return $formatter($value);
		}
		return $value;
	}

	function filters(){
		return $this->param->filters();
	}

	function placeholder($placeholder){
		$this->attrs(['placeholder'=>$placeholder]);
		return $this;
	}

	function size($size){
		$this->attrs(['size'=>$size]);
		return $this;
	}

	function renderReadonly(){
		$value = $this->value();
		$this->attrs([
			'value' => $this->format($value),
			'readonly' => 'readonly'
		]);
		echo "<input {$this->attrs} />";
	}

	function renderWritable(){
		$value = $this->value();
		$this->attrs([
			'value' => $this->format($value),
		]);
		if(isset($this->attrs['readonly'])){
			unset($this->attrs['readonly']);
		}
		echo "<input {$this->attrs} />";
	}

}

