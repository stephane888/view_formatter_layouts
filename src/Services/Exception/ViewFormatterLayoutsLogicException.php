<?php

namespace Drupal\view_formatter_layouts\Services\Exception;

use LogicException;


class ViewFormatterLayoutsLogicException extends LogicException
{

	/**
	 *
	 * {@inheritdoc}
	 * @see LogicException::__construct()
	 */
	public function __construct($message = null, $code = null, $previous = null)
	{
		// TODO Auto-generated method stub
		parent::__construct($message, $code, $previous);
		$this->logMessage();
	}

	/**
	 * --
	 */
	private function logMessage()
	{
		\Drupal::logger('view_formatter_layouts')->warning($this->getMessage() . $this->toString($this->getTrace()[0]));
	}

	/**
	 *
	 * @param string $message
	 * @return string
	 */
	private function toString($message)
	{
		$stringMessage = '';
		foreach ( $message as $key => $value ) {
			if (is_array($value)) {
				$stringMessage .= $this->toString($value);
			}
			else {
				$stringMessage .= "<br> \n" . $key . ' : ' . $value;
			}
		}
		return $stringMessage;
	}
}