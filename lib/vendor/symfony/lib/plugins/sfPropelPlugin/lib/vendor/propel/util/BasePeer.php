<?php
/*
 *  $Id: BasePeer.php 1608 2010-03-15 23:09:22Z francois $
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the LGPL. For more information please see
 * <http://propel.phpdb.org>.
 */

/**
 * This is a utility class for all generated Peer classes in the system.
 *
 * Peer classes are responsible for isolating all of the database access
 * for a specific business object.  They execute all of the SQL
 * against the database.  Over time this class has grown to include
 * utility methods which ease execution of cross-database queries and
 * the implementation of concrete Peers.
 *
 * @author     Hans Lellelid <hans@xmpl.org> (Propel)
 * @author     Kaspars Jaudzems <kaspars.jaudzems@inbox.lv> (Propel)
 * @author     Heltem <heltem@o2php.com> (Propel)
 * @author     Frank Y. Kim <frank.kim@clearink.com> (Torque)
 * @author     John D. McNally <jmcnally@collab.net> (Torque)
 * @author     Brett McLaughlin <bmclaugh@algx.net> (Torque)
 * @author     Stephen Haberman <stephenh@chase3000.com> (Torque)
 * @version    $Revision: 1608 $
 * @package    propel.util
 */
class BasePeer
{

	/** Array (hash) that contains the cached mapBuilders. */
	private static $mapBuilders = array();

	/** Array (hash) that contains cached validators */
	private static $validatorMap = array();

	/**
	 * phpname type
	 * e.g. 'AuthorId'
	 */
	const TYPE_PHPNAME = 'phpName';

	/**
	 * studlyphpname type
	 * e.g. 'authorId'
	 */
	const TYPE_STUDLYPHPNAME = 'studlyPhpName';

	/**
	 * column (peer) name type
	 * e.g. 'book.AUTHOR_ID'
	 */
	const TYPE_COLNAME = 'colName';

	/**
	 * column fieldname type
	 * e.g. 'author_id'
	 */
	const TYPE_FIELDNAME = 'fieldName';

	/**
	 * num type
	 * simply the numerical array index, e.g. 4
	 */
	const TYPE_NUM = 'num';

	static public function getFieldnames ($classname, $type = self::TYPE_PHPNAME) {

		// TODO we should take care of including the peer class here

		$peerclass = 'Base' . $classname . 'Peer'; // TODO is this always true?
		$callable = array($peerclass, 'getFieldnames');
		$args = array($type);

		return call_user_func_array($callable, $args);
	}

	static public function translateFieldname($classname, $fieldname, $fromType, $toType) {

		// TODO we should take care of including the peer class here

		$peerclass = 'Base' . $classname . 'Peer'; // TODO is this always true?
		$callable = array($peerclass, 'translateFieldname');
		$args = array($fieldname, $fromType, $toType);

		return call_user_func_array($callable, $args);
	}

	/**
	 * Method to perform deletes based on values and keys in a
	 * Criteria.
	 *
	 * @param      Criteria $criteria The criteria to use.
	 * @param      PropelPDO $con A PropelPDO connection object.
	 * @return     int	The number of rows affected by last statement execution.  For most
	 * 				uses there is only one delete statement executed, so this number
	 * 				will correspond to the number of rows affected by the call to this
	 * 				method.  Note that the return value does require that this information
	 * 				is returned (supported) by the PDO driver.
	 * @throws     PropelException
	 */
	public static function doDelete(Criteria $criteria, PropelPDO $con)
	{
		$db = Propel::getDB($criteria->getDbName());
		$dbMap = Propel::getDatabaseMap($criteria->getDbName());

		// Set up a list of required tables (one DELETE statement will
		// be executed per table)

		$tables_keys = array();
		foreach ($criteria as $c) {
			foreach ($c->getAllTables() as $tableName) {
				$tableName2 = $criteria->getTableForAlias($tableName);
				if ($tableName2 !== null) {
					$tables_keys[$tableName2 . ' ' . $tableName] = true;
				} else {
					$tables_keys[$tableName] = true;
				}
			}
		} // foreach criteria->keys()

		$affectedRows = 0; // initialize this in case the next loop has no iterations.

		$tables = array_keys($tables_keys);

		foreach ($tables as $tableName) {

			$whereClause = array();
			$selectParams = array();
			foreach ($dbMap->getTable($tableName)->getColumns() as $colMap) {
				$key = $tableName . '.' . $colMap->getColumnName();
				if ($criteria->containsKey($key)) {
					$sb = "";
					$criteria->getCriterion($key)->appendPsTo($sb, $selectParams);
					$whereClause[] = $sb;
				}
			}

			if (empty($whereClause)) {
				throw new PropelException("Cowardly refusing to delete from table $tableName with empty WHERE clause.");
			}

			// Execute the statement.
			try {
				$sql = "DELETE FROM " . $tableName . " WHERE " .  implode(" AND ", $whereClause);
				$stmt = $con->prepare($sql);
				self::populateStmtValues($stmt, $selectParams, $dbMap, $db);
				$stmt->execute();
				$affectedRows = $stmt->rowCount();
			} catch (Exception $e) {
				Propel::log($e->getMessage(), Propel::LOG_ERR);
				throw new PropelException("Unable to execute DELETE statement.",$e);
			}

		} // for each table

		return $affectedRows;
	}

	/**
	 * Method to deletes all contents of specified table.
	 *
	 * This method is invoked from generated Peer classes like this:
	 * <code>
	 * public static function doDeleteAll($con = null)
	 * {
	 *   if ($con === null) $con = Propel::getConnection(self::DATABASE_NAME);
	 *   BasePeer::doDeleteAll(self::TABLE_NAME, $con);
	 * }
	 * </code>
	 *
	 * @param      string $tableName The name of the table to empty.
	 * @param      PropelPDO $con A PropelPDO connection object.
	 * @return     int	The number of rows affected by the statement.  Note
	 * 				that the return value does require that this information
	 * 				is returned (supported) by the Creole db driver.
	 * @throws     PropelException - wrapping SQLException caught from statement execution.
	 */
	public static function doDeleteAll($tableName, PropelPDO $con)
	{
		try {
			$sql = "DELETE FROM " . $tableName;
			$stmt = $con->prepare($sql);
			$stmt->execute();
			return $stmt->rowCount();
		} catch (Exception $e) {
			Propel::log($e->getMessage(), Propel::LOG_ERR);
			throw new PropelException("Unable to perform DELETE ALL operation.", $e);
		}
	}

	/**
	 * Method to perform inserts based on values and keys in a
	 * Criteria.
	 * <p>
	 * If the primary key is auto incremented the data in Criteria
	 * will be inserted and the auto increment value will be returned.
	 * <p>
	 * If the primary key is included in Criteria then that value will
	 * be used to insert the row.
	 * <p>
	 * If no primary key is included in Criteria then we will try to
	 * figure out the primary key from the database map and insert the
	 * row with the next available id using util.db.IDBroker.
	 * <p>
	 * If no primary key is defined for the table the values will be
	 * inserted as specified in Criteria and null will be returned.
	 *
	 * @param      Criteria $criteria Object containing values to insert.
	 * @param      PropelPDO $con A PropelPDO connection.
	 * @return     mixed The primary key for the new row if (and only if!) the primary key
	 *				is auto-generated.  Otherwise will return <code>null</code>.
	 * @throws     PropelException
	 */
	public static function doInsert(Criteria $criteria, PropelPDO $con) {

		// the primary key
		$id = null;

		$db = Propel::getDB($criteria->getDbName());

		// Get the table name and method for determining the primary
		// key value.
		$keys = $criteria->keys();
		if (!empty($keys)) {
			$tableName = $criteria->getTableName( $keys[0] );
		} else {
			throw new PropelException("Database insert attempted without anything specified to insert");
		}

		$dbMap = Propel::getDatabaseMap($criteria->getDbName());
		$tableMap = $dbMap->getTable($tableName);
		$keyInfo = $tableMap->getPrimaryKeyMethodInfo();
		$useIdGen = $tableMap->isUseIdGenerator();
		//$keyGen = $con->getIdGenerator();

		$pk = self::getPrimaryKey($criteria);

		// only get a new key value if you need to
		// the reason is that a primary key might be defined
		// but you are still going to set its value. for example:
		// a join table where both keys are primary and you are
		// setting both columns with your own values

		// pk will be null if there is no primary key defined for the table
		// we're inserting into.
		if ($pk !== null && $useIdGen && !$criteria->keyContainsValue($pk->getFullyQualifiedName()) && $db->isGetIdBeforeInsert()) {
			try {
				$id = $db->getId($con, $keyInfo);
			} catch (Exception $e) {
				throw new PropelException("Unable to get sequence id.", $e);
			}
			$criteria->add($pk->getFullyQualifiedName(), $id);
		}

		try {
			$adapter = Propel::getDB($criteria->getDBName());

			$qualifiedCols = $criteria->keys(); // we need table.column cols when populating values
			$columns = array(); // but just 'column' cols for the SQL
			foreach ($qualifiedCols as $qualifiedCol) {
				$co