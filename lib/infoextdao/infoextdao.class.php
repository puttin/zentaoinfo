<?php 
class infoextdao
{
	//https://github.com/phpmyadmin/phpmyadmin/blob/master/libraries/common.lib.php#LC843
	/**
	 * Adds backquotes on both sides of a database, table or field name.
	 * and escapes backquotes inside the name with another backquote
	 *
	 * example:
	 * <code>
	 * echo backquote('owner`s db'); // `owner``s db`
	 *
	 * </code>
	 *
	 * @param mixed   $a_name the database, table or field name to "backquote"
	 *                        or array of it
	 * @param boolean $do_it  a flag to bypass this function (used by dump
	 *                        functions)
	 *
	 * @return  mixed    the "backquoted" database, table or field name
	 *
	 * @access  public
	 */
	static function backquote($a_name) {
		if (is_array($a_name)) {
			foreach ($a_name as &$data) {
				$data = backquote($data);
			}
			return $a_name;
		}
	
		// '0' is also empty for php :-(
		if (strlen($a_name) && $a_name !== '*') {
			return '`' . str_replace('`', '``', $a_name) . '`';
		} else {
			return $a_name;
		}
	} // end of the 'backquote()' function
	
	//https://github.com/phpmyadmin/phpmyadmin/blob/master/libraries/mysql_charsets.lib.php#LC151
	static function generateCharsetQueryPart($collation) {
		list($charset) = explode('_', $collation);
		return ' CHARACTER SET ' . $charset . ($charset == $collation ? '' : ' COLLATE ' . $collation);
	}
	
	//https://github.com/phpmyadmin/phpmyadmin/blob/master/libraries/common.lib.php#LC213
	/**
	 * Add slashes before "'" and "\" characters so a value containing them can
	 * be used in a sql comparison.
	 *
	 * @param string $a_string the string to slash
	 * @param bool   $is_like  whether the string will be used in a 'LIKE' clause
	 *                         (it then requires two more escaped sequences) or not
	 * @param bool   $crlf     whether to treat cr/lfs as escape-worthy entities
	 *                         (converts \n to \\n, \r to \\r)
	 * @param bool   $php_code whether this function is used as part of the
	 *                         "Create PHP code" dialog
	 *
	 * @return  string   the slashed string
	 *
	 * @access  public
	 */
	static function sqlAddSlashes($a_string = '', $is_like = false, $crlf = false, $php_code = false)
	{
		if ($is_like) {
			$a_string = str_replace('\\', '\\\\\\\\', $a_string);
		} else {
			$a_string = str_replace('\\', '\\\\', $a_string);
		}
	
		if ($crlf) {
			$a_string = strtr(
				$a_string,
				array("\n" => '\n', "\r" => '\r', "\t" => '\t')
			);
		}
	
		if ($php_code) {
			$a_string = str_replace('\'', '\\\'', $a_string);
		} else {
			$a_string = str_replace('\'', '\'\'', $a_string);
		}
	
		return $a_string;
	} // end of the 'PMA_sqlAddSlashes()' function
	
	//https://github.com/phpmyadmin/phpmyadmin/blob/master/libraries/Table.class.php#LC337
	/**
	 * generates column specification for ALTER or CREATE TABLE syntax
	 *
	 * @param string      $name           name
	 * @param string      $type           type ('INT', 'VARCHAR', 'BIT', ...)
	 * @param string      $length         length ('2', '5,2', '', ...)
	 * @param string      $attribute      attribute
	 * @param string      $collation      collation
	 * @param bool|string $null           with 'NULL' or 'NOT NULL'
	 * @param string      $default_type   whether default is CURRENT_TIMESTAMP,
	 *                                    NULL, NONE, USER_DEFINED
	 * @param string      $default_value  default value for USER_DEFINED default type
	 * @param string      $extra          'AUTO_INCREMENT'
	 * @param string      $comment        field comment
	 * @param array       &$field_primary list of fields for PRIMARY KEY
	 * @param string      $index
	 *
	 * @todo    move into class PMA_Column
	 * @todo on the interface, some js to clear the default value when the default
	 * current_timestamp is checked
	 *
	 * @return  string  field specification
	 */
	static function generateFieldSpec($name, $type, $length = '', $attribute = '',
		$collation = '', $null = false, $default_type = 'USER_DEFINED',
		$default_value = '', $extra = '', $comment = '',
		$field_primary, $index)//removed the '&' before $field_primary
	{

		$is_timestamp = strpos(strtoupper($type), 'TIMESTAMP') !== false;

		$query = self::backquote($name) . ' ' . $type;

		if ($length != ''
			&& !preg_match('@^(DATE|DATETIME|TIME|TINYBLOB|TINYTEXT|BLOB|TEXT|'
				. 'MEDIUMBLOB|MEDIUMTEXT|LONGBLOB|LONGTEXT|SERIAL|BOOLEAN|UUID)$@i', $type)) {
			$query .= '(' . $length . ')';
		}

		if ($attribute != '') {
			$query .= ' ' . $attribute;
		}

		if (! empty($collation) && $collation != 'NULL'
			&& preg_match('@^(TINYTEXT|TEXT|MEDIUMTEXT|LONGTEXT|VARCHAR|CHAR|ENUM|SET)$@i', $type)
		) {
			$query .= self::generateCharsetQueryPart($collation);
		}

		if ($null !== false) {
			if ($null == 'NULL') {
				$query .= ' NULL';
			} else {
				$query .= ' NOT NULL';
			}
		}

		switch ($default_type) {
		case 'USER_DEFINED' :
			if ($is_timestamp && $default_value === '0') {
				// a TIMESTAMP does not accept DEFAULT '0'
				// but DEFAULT 0 works
				$query .= ' DEFAULT 0';
			} elseif ($type == 'BIT') {
				$query .= ' DEFAULT b\''
						. preg_replace('/[^01]/', '0', $default_value)
						. '\'';
			} elseif ($type == 'BOOLEAN') {
				if (preg_match('/^1|T|TRUE|YES$/i', $default_value)) {
					$query .= ' DEFAULT TRUE';
				} elseif (preg_match('/^0|F|FALSE|NO$/i', $default_value)) {
					$query .= ' DEFAULT FALSE';
				} else {
					// Invalid BOOLEAN value
					$query .= ' DEFAULT \'' . self::sqlAddSlashes($default_value) . '\'';
				}
			} else {
				$query .= ' DEFAULT \'' . self::sqlAddSlashes($default_value) . '\'';
			}
			break;
		case 'NULL' :
			//If user uncheck null checkbox and not change default value null,
			//default value will be ignored.
			if ($null !== false && $null != 'NULL') {
				break;
			}
		case 'CURRENT_TIMESTAMP' :
			$query .= ' DEFAULT ' . $default_type;
			break;
		case 'NONE' :
		default :
			break;
		}

		if (!empty($extra)) {
			$query .= ' ' . $extra;
			// Force an auto_increment field to be part of the primary key
			// even if user did not tick the PK box;
			if ($extra == 'AUTO_INCREMENT') {
				$primary_cnt = count($field_primary);
				if (1 == $primary_cnt) {
					for ($j = 0; $j < $primary_cnt; $j++) {
						if ($field_primary[$j] == $index) {
							break;
						}
					}
					if (isset($field_primary[$j]) && $field_primary[$j] == $index) {
						$query .= ' PRIMARY KEY';
						unset($field_primary[$j]);
					}
				} else {
					// but the PK could contain other columns so do not append
					// a PRIMARY KEY clause, just add a member to $field_primary
					$found_in_pk = false;
					for ($j = 0; $j < $primary_cnt; $j++) {
						if ($field_primary[$j] == $index) {
							$found_in_pk = true;
							break;
						}
					} // end for
					if (! $found_in_pk) {
						$field_primary[] = $index;
					}
				}
			} // end if (auto_increment)
		}
		if (!empty($comment)) {
			$query .= " COMMENT '" . self::sqlAddSlashes($comment) . "'";
		}
		return $query;
	} // end function
}
?>
