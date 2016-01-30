<?php


namespace Bixie\Framework\Field;

use Pagekit\Application as App;
use Bixie\Framework\FieldType\FieldTypeBase;
use Pagekit\System\Model\DataModelTrait;

abstract class FieldBase implements FieldInterface {

	use DataModelTrait;

	/**
	 * @var string
	 */
	public $type;
	/**
	 * @var string
	 */
	public $slug;
	/**
	 * @var string
	 */
	public $label;
	/**
	 * @var array
	 */
	public $options = [];

	/**
	 * @var FieldTypeBase
	 */
	protected $fieldType;

	/**
	 * @param string $type
	 */
	public function setFieldType ($type) {
		$this->type = $type;
	}

	/**
	 * @return FieldTypeBase
	 */
	public function getFieldType () {
		if (!isset($this->fieldType)) {
			$this->fieldType = App::module('bixie/framework')->getFieldType($this->type);
		}
		return $this->fieldType;
	}

	/**
	 * Set select-options
	 * @param array $options
	 */
	public function setOptions ($options) {
		$this->options = $options;
	}

	/**
	 * Get select-options
	 * @return array
	 */
	public function getOptions () {
		return $this->getFieldType()->getOptions($this);
	}

	/**
	 * reference value=>label for easy formatting
	 * @return array
	 */
	public function getOptionsRef () {
		$options = [];
		foreach ($this->getOptions() as $option) {
			$options[$option['value']] = $option['text'];
		}
		return $options;
	}

	/**
	 * Prepare default value before displaying form
	 * @return array
	 */
	public function prepareValue () {
		return $this->getFieldType()->prepareValue($this, $this->get('value', []));
	}

	/**
	 * Prepare value before rendering
	 * @return array
	 */
	public function formatValue () {
		return $this->getFieldType()->formatValue($this, $this->get('value', []));
	}

	/**
	 * @param array $data
	 * @param array $ignore
	 * @return array
	 */
	public function toArray(array $data = [], array $ignore = []) {}

}