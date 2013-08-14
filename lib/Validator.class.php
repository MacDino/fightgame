<?php
class Validator {
	public static function checkRequired($value)
	{
		return ! empty($value) || is_numeric($value);
	}

	public static function checkEmail($value)
	{
		return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
	}
	
	public static function checkIp($value)
	{
		return filter_var($value, FILTER_VALIDATE_IP) !== false;
	}

	public static function checkUrl($value)
	{
		return filter_var($value, FILTER_VALIDATE_URL) !== false;
	}

	public static function checkInteger($value)
	{
		return filter_var($value, FILTER_VALIDATE_INT) !== false;
	}

	public static function checkNumeric($value)
	{
		return is_numeric($value);
	}

	public static function checkAlpha($value)
	{
		return preg_match('/^([a-z])+$/i', $value);
	}

	public static function checkAlphaBegin($value)
	{
		return preg_match('/^[a-z].*/i', $value);
	}

	public static function checkAlphaNum($value)
	{
		return preg_match('/^([a-z0-9])+$/i', $value);
	}

	public static function checkAlphaDash($value)
	{
		return preg_match('/^\w+$/', $value);
	}

	public static function checkLength($value, $min = 0, $max = null)
	{
		$length = strlen($value);
		$max = isset($max) ? $max : $length;

		return $length >= $min && $length <= $max;
	}

	public static function checkValue($value, $min = 0, $max = null)
	{
		$max = isset($max) ? $max : $value;
		return $value >= $min && $value <= $max;
	}

	public static function checkDate($value)
	{
		return strtotime($value) !== false;
	}

	public static function checkMatch($value, $regex)
	{
		return preg_match($regex, $value);
	}

	/**
	 * multi check params
	 *
	 *	$params = array('email' => 'a@a.com', 'user_id' => '123456abc');
	 *	$validates = array(
	 *		'email' => 'email', 
	 *		'user_id' => 'integer,length:6:10'
	 *	) 
	 *
	 * Notice:  if keys in $validates is not present in $params, 
	 * 			validation will bypass $params[$key], unless $validates[$key] has a 'required' rule
	 *
	 * @param array $params
	 * @param array $validates 
	 * @param array $errors
	 * @return bool
	 */
	public static function multiCheck(array $params, array $validates, &$errors = array())
	{
		$errors = array();
		foreach ($validates as $key => $rules)
		{
			$value = isset($params[$key]) ? $params[$key] : null;
			
			if ( ! isset($value) && strpos($rules, 'required') === false)
			{
				continue;
			}

			if ( ! self::check($value, $rules, $failed_rule))
			{
				$errors[$key] = ($failed_rule === 'required') ? "$key should not be empty" : "$key invalid";
			}
		}

		return empty($errors);
	}

	public static function check($value, $rules, &$rule_name = '')
	{
			$rules = array_filter(array_map('trim', explode(',', $rules)));
			foreach ($rules as $rule)
			{
				$rule_options = explode(':', $rule);
				$rule_name = array_shift($rule_options);
				$rule_callback = array('Validator', 'check'.str_replace('_', '', $rule_name));

				if ( ! is_callable($rule_callback))
				{
					return false;
				}

				array_unshift($rule_options, $value);
				if ( ! call_user_func_array($rule_callback, $rule_options))
				{
					return false;
				}
			}

			return true;
	}
}
