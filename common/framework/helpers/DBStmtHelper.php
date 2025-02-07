<?php

namespace Rhymix\Framework\Helpers;

use Rhymix\Framework\DB;
use Rhymix\Framework\Debug;
use Rhymix\Framework\Exceptions\DBError;

/**
 * DB Statement helper class.
 *
 * We use instances of this class instead of raw PDOStatement in order to log
 * individual execute() calls of prepared statements. This is controlled by
 * the PDO::ATTR_STATEMENT_CLASS attribute set in the DB class.
 */
class DBStmtHelper extends \PDOStatement
{
	/**
	 * Store the database type (e.g. master) here.
	 */
	protected $_type = 'master';

	/**
	 * Set the database type.
	 */
	public function setType(string $type)
	{
		$this->_type = $type;
	}

	/**
	 * Execute a prepared statement.
	 *
	 * @param array $params
	 * @return bool
	 */
	public function execute($params = null): bool
	{
		$start_time = microtime(true);
		$db_class = DB::getInstance($this->_type);

		try
		{
			$result = parent::execute($params);
			$db_class->clearError();
		}
		catch (\PDOException $e)
		{
			$db_class->setError(-1, $e->getMessage());
			throw new DBError($e->getMessage(), 0, $e);
		}
		finally
		{
			$elapsed_time = microtime(true) - $start_time;
			$db_class->addElapsedTime($elapsed_time);
			if (Debug::isEnabledForCurrentUser())
			{
				Debug::addQuery($db_class->getQueryLog($this->queryString, $elapsed_time));
			}
		}

		return $result;
	}
}
