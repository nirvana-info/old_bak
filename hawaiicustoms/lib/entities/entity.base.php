<?php

class ISC_ENTITY_BASE
{
	protected $accounting;
	protected $allowedSQLFunctions;

	/**
	 * Constructor
	 *
	 * Base constructor
	 *
	 * @access public
	 */
	public function __construct()
	{
		$this->accounting = GetClass('ISC_ACCOUNTING');
		$this->allowedSQLFunctions = array(
				'LOWER',
				'UPPER',
				'TRIM'
		);
	}

	/**
	 * Create a service request (a spooled accounting job file)
	 *
	 * Method will create the necessary service requests (spooled job files) for each available accounting module
	 *
	 * @access protected
	 * @param string $type The service type of the service request (customer, product, etc)
	 * @param string $service The service to preform (add, edit)
	 * @param int $nodeId The node ID that references this record OR the data array of the record
	 * @param string $permission The permission string that is required for this service to be created
	 */
	protected function createServiceRequest($type, $service, $nodeId, $permission)
	{
		if (isId($nodeId)) {
			$data = $this->get($nodeId);
		} else {
			$data = $nodeId;
		}

		$this->accounting->createServiceRequest($type, $service, $data, $permission);
	}

	/**
	 * Generic search for an entity
	 *
	 * Method will search for an entity using the search fields in the associative $searchFields.
	 *
	 * The $likeFields is an array containing the keys in $searchFields in where the search will be
	 * a 'LIKE' instead of an exact match.
	 *
	 * The $negateFields is an array containing the keys in $searchFields in where the will be a non
	 * equals (!=).
	 *
	 * The $formSession is an ID/array of form field session data to also match against
	 *
	 * @access public
	 * @param array $searchFields The search field associative array
	 * @param array $likeFields The option array to turn the $searchFields into a LIKE search
	 * @param array $negateFields The option array to turn the $searchFields into a non equals search
	 * @param mixed $formSession The form session ID/array to also match against
	 * @return int The matched entity ID on success, FALSE if no match
	 */
	public function search($searchFields, $likeFields=array(), $negateFields=array(), $formSession=0)
	{
		if (!is_array($searchFields)) {
			return false;
		}

		/**
		 * First we need to filter out any keys in the $searchFields that are not contained in the
		 * $this->searchFields child array
		 */
		foreach (array_keys($searchFields) as $key) {
			if (in_array($key, $this->searchFields) == false) {
				unset($searchFields[$key]);
			}
		}

		if (empty($searchFields)) {
			return false;
		}

		/**
		 * Fix up our args before we start using them
		 */
		if (!is_array($likeFields)) {
			$likeFields = array();
		}

		if (!is_array($negateFields)) {
			$negateFields = array();
		}

		if (isId($formSession)) {
			$formSession = $GLOBALS['ISC_CLASS_FORM']->getSavedSessionData($formSession);
		}

		/**
		 * Now to contstruct there search clause. Fix up our args before we start using them
		 */
		$where = '';

		foreach ($searchFields as $column => $keyword) {

			/**
			 * Special case here for the $keyword. If the $keyword is an array then check for the 'value'
			 * and 'func' keys. If they are present then 'value' will be the search keyword and 'func'
			 * will be the SQL function(s) to preform on the column (this can be an array of functions)
			 */
			if (is_array($keyword)) {
				if (!array_key_exists('value', $keyword)) {
					continue;
				}

				if (array_key_exists('func', $keyword)) {
					if (!is_array($keyword['func'])) {
						$keyword['func'] = array($keyword['func']);
					}

					foreach ($keyword['func'] as $func) {
						if (trim($func) == '') {
							continue;
						}

						$column = $func . '(' . $column . ')';
					}
				}

				$keyword = $keyword['value'];
			}

			/**
			 * Ignore this if it is empty
			 */
			$keyword = trim($keyword);
			if ($keyword == '') {
				continue;
			}

			/**
			 * Is this a 'LIKE' match?
			 */
			if (in_array($column, $likeFields) !== false) {
				$where .= " AND " . $column . " LIKE '%" . $GLOBALS['ISC_CLASS_DB']->Quote($keyword) . "%'";

			/**
			 * Else is it a negate (non equals) match?
			 */
			} else if (in_array($column, $negateFields) !== false) {
				$where .= " AND " . $column . " != '" . $GLOBALS['ISC_CLASS_DB']->Quote($keyword) . "'";

			/**
			 * Else its just a plain match
			 */
			} else {
				$where .= " AND " . $column . " = '" . $GLOBALS['ISC_CLASS_DB']->Quote($keyword) . "'";
			}
		}

		/**
		 * Just in case
		 */
		if ($where == '') {
			return false;
		}

		$query = "SELECT " . $this->primaryKeyName . " AS entityid";

		if ($this->customKeyName !== '') {
			$query .= ", " . $this->customKeyName . " AS formsessionid";
		}

		$query .= "
					FROM [|PREFIX|]" . $this->tableName . "
					WHERE 1=1 " . $where;

		/**
		 * OK, we have the search SQL. If we don't have to search through the saved form session data
		 * then just return the query result
		 */
		if ($this->customKeyName == '' || !is_array($formSession) || empty($formSession)) {
			return $GLOBALS['ISC_CLASS_DB']->FetchOne($query, 'entityid');

		/**
		 * Else we need to loop through all the matches results and then match against their saved
		 * form session data (if any)
		 */
		} else {
			$result = $GLOBALS['ISC_CLASS_DB']->Query($query);
			while ($row = $GLOBALS['ISC_CLASS_DB']->Fetch($result)) {

				$sessData = array();
				if (isId($row['formsessionid'])) {
					$sessData = $GLOBALS['ISC_CLASS_FORM']->getSavedSessionData($row['formsessionid']);
				}

				if (!is_array($sessData) || empty($sessData) || count($formSession) !== count($sessData)) {
					continue;
				}

				ksort($sessData);
				ksort($formSession);

				if ($sessData == $formSession) {
					return $row['entityid'];
				}
			}
		}

		return false;
	}
}

?>