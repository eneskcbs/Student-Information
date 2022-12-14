<?php

/**********************************************************************
*  Author: Juergen Bouché (jbouche@nurfuerspam.de). Slightly modified by Sunaryo Hadi
*  Web...: http://www.juergenbouche.de
*  Name..: ezSQL_mysqli
*  Desc..: mySQLi component (part of ezSQL database abstraction library)
*
*/

/**********************************************************************
*  ezSQL error strings - mySQLi
*/

global $ezsql_mysqli_str;

$ezsql_mysqli_str = array
(
	1 => 'Require $dbuser and $dbpassword to connect to a database server',
	2 => 'Error establishing mySQLi database connection. Correct user/password? Correct hostname? Database server running?',
	3 => 'Require $dbname to select a database',
	4 => 'mySQLi database connection is not active',
	5 => 'Unexpected error while trying to select database'
);

/**********************************************************************
*  ezSQL Database specific class - mySQLi
*/

if ( ! function_exists ('mysqli_connect') ) die('<b>Fatal Error:</b> ezSQL_mysql requires mySQLi Lib to be compiled and or linked in to the PHP engine');
if ( ! class_exists ('ezSQLcore') ) die('<b>Fatal Error:</b> ezSQL_mysql requires ezSQLcore (ez_sql_core.php) to be included/loaded before it can be used');

class ezSQL_mysqli extends ezSQLcore
{

	var $dbuser = false;
	var $dbpassword = false;
	var $dbname = false;
	var $dbhost = false;
	var $dbport = false;
	var $encoding = false;
	var $rows_affected = false;

	/**********************************************************************
	*  Constructor - allow the user to perform a quick connect at the
	*  same time as initialising the ezSQL_mysqli class
	*/

	function __construct($dbuser='', $dbpassword='', $dbname='', $dbhost='localhost', $encoding='')
	{
		$this->dbuser = $dbuser;
		$this->dbpassword = $dbpassword;
		$this->dbname = $dbname;
		list( $this->dbhost, $this->dbport ) = $this->get_host_port( $dbhost, 3306 );
		$this->encoding = $encoding;
	}

	/**********************************************************************
	*  Short hand way to connect to mySQL database server
	*  and select a mySQL database at the same time
	*/

	function quick_connect($dbuser='', $dbpassword='', $dbname='', $dbhost='localhost', $dbport='3306', $encoding='')
	{
		$return_val = false;
		if ( ! $this->connect($dbuser, $dbpassword, $dbhost, $dbport) ) ;
		else if ( ! $this->select($dbname,$encoding) ) ;
		else $return_val = true;
		return $return_val;
	}

	/**********************************************************************
	*  Try to connect to mySQL database server
	*/

	function connect($dbuser='', $dbpassword='', $dbhost='localhost', $dbport=false)
	{
		global $ezsql_mysqli_str; $return_val = false;
		
		// Keep track of how long the DB takes to connect
		$this->timer_start('db_connect_time');
		
		// If port not specified (new connection issued), get it
		if( ! $dbport ) {
			list( $dbhost, $dbport ) = $this->get_host_port( $dbhost, 3306 );
		}
		
		// Must have a user and a password
		if ( ! $dbuser )
		{
			$this->register_error($ezsql_mysqli_str[1].' in '.__FILE__.' on line '.__LINE__);
			$this->show_errors ? trigger_error($ezsql_mysqli_str[1],E_USER_WARNING) : null;
		}
		// Try to establish the server database handle
		else
		{
			$this->dbh = new mysqli($dbhost,$dbuser,$dbpassword, '', $dbport);
			// Check for connection problem
			if( $this->dbh->connect_errno )
			{
				$this->register_error($ezsql_mysqli_str[2].' in '.__FILE__.' on line '.__LINE__);
				$this->show_errors ? trigger_error($ezsql_mysqli_str[2],E_USER_WARNING) : null;
			}
			else
			{
				$this->dbuser = $dbuser;
				$this->dbpassword = $dbpassword;
				$this->dbhost = $dbhost;
				$this->dbport = $dbport;
				$return_val = true;

				$this->conn_queries = 0;
			}
		}

		return $return_val;
	}

	/**********************************************************************
	*  Try to select a mySQL database
	*/

	function select($dbname='', $encoding='')
	{
		global $ezsql_mysqli_str; $return_val = false;

		// Must have a database name
		if ( ! $dbname )
		{
			$this->register_error($ezsql_mysqli_str[3].' in '.__FILE__.' on line '.__LINE__);
			$this->show_errors ? trigger_error($ezsql_mysqli_str[3],E_USER_WARNING) : null;
		}

		// Must have an active database connection
		else if ( ! $this->dbh )
		{
			$this->register_error($ezsql_mysqli_str[4].' in '.__FILE__.' on line '.__LINE__);
			$this->show_errors ? trigger_error($ezsql_mysqli_str[4],E_USER_WARNING) : null;
		}

		// Try to connect to the database
		else if ( !@$this->dbh->select_db($dbname) )
		{
			// Try to get error supplied by mysql if not use our own
			if ( !$str = @$this->dbh->error)
				  $str = $ezsql_mysqli_str[5];

			$this->register_error($str.' in '.__FILE__.' on line '.__LINE__);
			$this->show_errors ? trigger_error($str,E_USER_WARNING) : null;
		}
		else
		{
			$this->dbname = $dbname;
			if($encoding!='')
			{
				$encoding = strtolower(str_replace("-","",$encoding));
				$charsets = array();
				$result = $this->dbh->query("SHOW CHARACTER SET");
				while($row = $result->fetch_array(MYSQLI_ASSOC))
				{
					$charsets[] = $row["Charset"];
				}
				if(in_array($encoding,$charsets)){
					$this->dbh->set_charset($encoding);
				}
			}
			
			$return_val = true;
		}

		return $return_val;
	}

	/**********************************************************************
	*  Format a mySQL string correctly for safe mySQL insert
	*  (no mater if magic quotes are on or not)
	*/

	function escape($str)
	{
		// If there is no existing database connection then try to connect
		if ( ! isset($this->dbh) || ! $this->dbh )
		{
			$this->connect($this->dbuser, $this->dbpassword, $this->dbhost, $this->dbport);
			$this->select($this->dbname, $this->encoding);
		}
					
		if ( get_magic_quotes_gpc() ) {
			$str = stripslashes($str);
		}                        

		return $this->dbh->escape_string($str);
	}

	/**********************************************************************
	*  Return mySQL specific system date syntax
	*  i.e. Oracle: SYSDATE Mysql: NOW()
	*/

	function sysdate()
	{
		return 'NOW()';
	}

	/**********************************************************************
	*  Perform mySQL query and try to determine result value
	*/

	function query($query)
	{

		// This keeps the connection alive for very long running scripts
		if ( $this->count(false) >= 500 )
		{
			$this->disconnect();
			$this->quick_connect($this->dbuser,$this->dbpassword,$this->dbname,$this->dbhost,$this->dbport,$this->encoding);
		}

		// Initialise return
		$return_val = 0;

		// Flush cached values..
		$this->flush();

		// For reg expressions
		$query = trim($query);

		// Log how the function was called
		$this->func_call = "\$db->query(\"$query\")";

		// Keep track of the last query for debug..
		$this->last_query = $query;

		// Count how many queries there have been
		$this->count(true, true);
		
		// Start timer
		$this->timer_start($this->num_queries);

		// Use core file cache function
		if ( $cache = $this->get_cache($query) )
		{
			// Keep tack of how long all queries have taken
			$this->timer_update_global($this->num_queries);

			// Trace all queries
			if ( $this->use_trace_log )
			{
				$this->trace_log[] = $this->debug(false);
			}
			
			return $cache;
		}

		// If there is no existing database connection then try to connect
		if ( ! isset($this->dbh) || ! $this->dbh )
		{
			$this->connect($this->dbuser, $this->dbpassword, $this->dbhost, $this->dbport);
			$this->select($this->dbname,$this->encoding);
			// No existing connection at this point means the server is unreachable
			if ( ! isset($this->dbh) || ! $this->dbh || $this->dbh->connect_errno )
				return false;
		}

		// Perform the query via std mysql_query function..
		$this->result = @$this->dbh->query($query);

		// If there is an error then take note of it..
		if ( $str = @$this->dbh->error )
		{
			$this->register_error($str);
			$this->show_errors ? trigger_error($str,E_USER_WARNING) : null;
			return false;
		}

		// Query was a Data Manipulation Query (insert, delete, update, replace, ...)
		if ( !is_object($this->result) )
		{
			$is_insert = true;
			$this->rows_affected = @$this->dbh->affected_rows;

			// Take note of the insert_id
			if ( preg_match("/^(insert|replace)\s+/i",$query) )
			{
				$this->insert_id = @$this->dbh->insert_id;
			}

			// Return number fo rows affected
			$return_val = $this->rows_affected;
		}
		// Query was a Data Query Query (select, show, ...)
		else
		{
			$is_insert = false;

			// Take note of column info
			$i=0;
			while ($i < @$this->result->field_count)
			{
				$this->col_info[$i] = @$this->result->fetch_field();
				$i++;
			}

			// Store Query Results
			$num_rows=0;
			while ( $row = @$this->result->fetch_object() )
			{
				// Store relults as an objects within main array
				$this->last_result[$num_rows] = $row;
				$num_rows++;
			}

			@$this->result->free_result();

			// Log number of rows the query returned
			$this->num_rows = $num_rows;

			// Return number of rows selected
			$return_val = $this->num_rows;
		}

		// disk caching of queries
		$this->store_cache($query,$is_insert);

		// If debug ALL queries
		$this->trace || $this->debug_all ? $this->debug() : null ;

		// Keep tack of how long all queries have taken
		$this->timer_update_global($this->num_queries);

		// Trace all queries
		if ( $this->use_trace_log )
		{
			$this->trace_log[] = $this->debug(false);
		}

		return $return_val;

	}
	
	/**********************************************************************
	*  Close the active mySQLi connection
	*/

	function disconnect()
	{
		$this->conn_queries = 0;
		@$this->dbh->close();
	}

	/**
	 * Prepares a SQL query for safe execution. Uses sprintf()-like syntax.
	 *
	 * The following directives can be used in the query format string:
	 *   %d (integer)
	 *   %f (float)
	 *   %s (string)
	 *   %% (literal percentage sign - no argument needed)
	 *
	 * All of %d, %f, and %s are to be left unquoted in the query string and they need an argument passed for them.
	 * Literals (%) as parts of the query must be properly written as %%.
	 *
	 * This function only supports a small subset of the sprintf syntax; it only supports %d (integer), %f (float), and %s (string).
	 * Does not support sign, padding, alignment, width or precision specifiers.
	 * Does not support argument numbering/swapping.
	 *
	 * May be called like {@link http://php.net/sprintf sprintf()} or like {@link http://php.net/vsprintf vsprintf()}.
	 *
	 * Both %d and %s should be left unquoted in the query string.
	 *
	 *     wpdb::prepare( "SELECT * FROM `table` WHERE `column` = %s AND `field` = %d", 'foo', 1337 )
	 *     wpdb::prepare( "SELECT DATE_FORMAT(`field`, '%%c') FROM `table` WHERE `column` = %s", 'foo' );
	 *
	 * @link http://php.net/sprintf Description of syntax.
	 * @since 2.3.0
	 *
	 * @param string      $query    Query statement with sprintf()-like placeholders
	 * @param array|mixed $args     The array of variables to substitute into the query's placeholders if being called like
	 *                              {@link http://php.net/vsprintf vsprintf()}, or the first variable to substitute into the query's placeholders if
	 *                              being called like {@link http://php.net/sprintf sprintf()}.
	 * @param mixed       $args,... further variables to substitute into the query's placeholders if being called like
	 *                              {@link http://php.net/sprintf sprintf()}.
	 * @return string|void Sanitized query string, if there is a query to prepare.
	 */
	public function prepare( $strquery, $args ) {
		if ( is_null( $strquery ) )
			return;

		// This is not meant to be foolproof -- but it will catch obviously incorrect usage.
		if ( strpos( $strquery, '%' ) === false ) {
			$this->show_errors ? trigger_error("The query argument of db::prepare() must have a placeholder.",E_USER_WARNING) : null;

		}

		$args = func_get_args();
		array_shift( $args );
		// If args were passed as an array (as in vsprintf), move them up
		if ( isset( $args[0] ) && is_array($args[0]) )
			$args = $args[0];
		$strquery = str_replace( "'%s'", '%s', $strquery ); // in case someone mistakenly already singlequoted it
		$strquery = str_replace( '"%s"', '%s', $strquery ); // doublequote unquoting
		$strquery = preg_replace( '|(?<!%)%f|' , '%F', $strquery ); // Force floats to be locale unaware
		$strquery = preg_replace( '|(?<!%)%s|', "'%s'", $strquery ); // quote the strings, avoiding escaped strings like %%s
		array_walk( $args, array( $this, 'escape_by_ref' ) ); // this has been escaped by ezmysqli
		return @vsprintf( $strquery, $args );
	}

	/**
	 * Escapes content by reference for insertion into the database, for security
	 *
	 * @uses wpdb::_real_escape()
	 *
	 * @since 2.3.0
	 *
	 * @param string $string to escape
	 */
	 /**
		*  This function works the insert process
		*  @param $table_name
		*  @param $column_names
		*/

		function insert($table_name, $column_names)
		{
			if ( is_array($column_names) )
			{
				foreach ( $column_names as $rows => $values )
				{
					$array_rows[] 	= "".$rows."";
					$array_values[] = "'".$values."'";
				}
			}

			$rows 	= implode(",", $array_rows);
			$values 	= implode(",", $array_values);

			$query = "INSERT INTO " . $table_name . " ({$rows}) VALUES ({$values});";

			return $this->query($query);
		}

		/**
		*  This function works the update process
		*  @param $table_name
		*  @param $column_names
		*  @param $where
		*/

		function update($table_name, $column_names, $where = 0)
		{
			if ( is_array($column_names) )
			{
				foreach ( $column_names as $rows => $values )
				{
					$array_rows[] = "{$rows} = '{$values}'";
				}

				$rows = implode(",", $array_rows);

				if ( $where > 0 )
				{
					if ( is_array($where) )
					{
						foreach ( $where as $w_rows => $w_values)
						{
							$w_arr_rows[] = "{$w_rows} = '{$w_values}'";
						}

						$where = implode(" AND ", $w_arr_rows);
					}
					$update = "UPDATE {$table_name} SET {$rows} WHERE {$where}"; 	
				}
				else
				{
					$update = "UPDATE {$table_name} SET {$rows}";
				}

				$res = $this->query($update);

				if ( is_resource($res) )
				{
					return $res;
				}
			}
		}

		/**
		*  This function works the delete process
		*  @param $table_name
		*  @param $wheres
		*/

		function delete($table_name, $wheres)
		{
			if ( is_array($wheres) )
			{
				foreach ( $wheres as $rows => $values )
				{
					$array_wheres[] = "{$rows} = '{$values}'";
				}
				$where = implode(" AND ", $array_wheres);

				$query = "DELETE FROM {$table_name} WHERE {$where}";

				$res = $this->query($query);

				if( is_resource($res) )
				{
					return $res;
				}
			}
		}
	public function escape_by_ref( &$string ) {
		if ( ! is_float( $string ) )
			$string = $this->escape($string);
			// $string = mysqli_real_escape_string( $this->dbh, $string );
	}

}