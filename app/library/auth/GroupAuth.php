<?php

/* GroupAuth.php - Group-based user authentication component.
 * Copyright (C) 2002 Julio César Carrascal Urquijo <jcesar@phreaker.net>
 *
 * This  library  is  free  software;  you can redistribute it and/or modify it
 * under  the  terms  of the GNU Library General Public License as published by
 * the  Free  Software Foundation; either version 2 of the License, or (at your
 * option) any later version.
 *
 * This  library is distributed in the hope that it will be useful, but WITHOUT
 * ANY  WARRANTY;  without  even  the  implied  warranty  of MERCHANTABILITY or
 * FITNESS  FOR  A  PARTICULAR  PURPOSE.  See  the  GNU  Library General Public
 * License for more details.
 *
 * You  should  have  received a copy of the GNU Library General Public License
 * along  with  this  library;  if  not, write to the Free Software Foundation,
 * Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA. */


require_once(dirname(__FILE__).'/Auth.php');

/**
 * Group-based user authentication component.
 * This component implements user access by clasifyng users in groups, this way you can
 * require that the user belongs to certain group to access the script.
 *
 * @package icreativa
 * @author Julio César Carrascal Urquijo <jcesar@phreaker.net>
 * @version 2.4 pl3
 * @access public
 */
class GroupAuth extends Auth {
//public:

	/**
	 * Constructor.
	 *
	 * @param array		key => val of options.
	 * @access public
	 */
	function GroupAuth($options = null) {
		$this->_options['groupsTable'] = 'groups';
		$this->_options['groupIdField'] = 'group_id';
		$this->_options['groupNameField'] = 'name';
		$this->_options['usersGroupsTable'] = 'users_groups';

		$this->Auth($options);
	}


	/**
	 * Require that the user belongs to all groups passed as parameters.
	 * Force the user to identify himself (If he hasn't do it before) and
	 * ensures that he/she belongs to each specified group. You can pass all the
	 * groups you need at once.
	 *
	 * @param string		name of each required group.
	 * @see requireAtLeast()
	 * @access public
	 */
	function requireGroups() {
		$this->forceLogin();

		$userId = $this->user[$this->_options['userIdField']];
		if (!isset($this->user['::groups::'])) {
			$this->user['::groups::'] = $this->_getGroups($userId);
		}

		// check each group.
		$groups = func_get_args();
		foreach ($groups as $group) {
			if (!isset($this->user['::groups::'][$group]) ||
				!$this->user['::groups::'][$group]) {
				$this->_callback(AUTH_ACCESS_DENIED,
					'You are not allowed to access this zone.');
			}
		}
	}


	/**
	 * Require that the user belongs to at least to one of this groups.
	 * Force the user to identify himself (If he hasn't do it before) and
	 * ensures that he belongs "at least" to one of the specified groups. You
	 * can pass all the groups you need at once.
	 *
	 * @param string		name of each required group.
	 * @see requireGroups()
	 * @access public
	 */
	function requireAtLeast() {
		$this->forceLogin();

		$userId = $this->user[$this->_options['userIdField']];
		if (!isset($this->user['::groups::'])) {
			$this->user['::groups::'] = $this->_getGroups($userId);
		}

		// we need at least one group.
		$autorized = false;
		$groups = func_get_args();
		foreach ($groups as $group) {
			if (isset($this->user['::groups::'][$group]) &&
				$this->user['::groups::'][$group]) {
				$autorized = true;
			}
		}
		if (!$autorized) {
			$this->_callback(AUTH_ACCESS_DENIED,
				'You are not allowed to access this zone.');
		}
	}

//protected:

	/**
	 * Search the groups a user belongs to.
	 * Returns an associative array for easy access.
	 *
	 * @param int			Of the user.
	 * @return array		group1 => true, group2 => true.
	 */
	function _getGroups($userId) {
		$this->_connect();

		$groups = array();
		$sql = sprintf('SELECT groups.%s FROM %s groups, %s users_groups '.
			'WHERE users_groups.%s = %d AND groups.%s = users_groups.%s',
			$this->_options['groupNameField'], $this->_options['groupsTable'],
			$this->_options['usersGroupsTable'],
			$this->_options['userIdField'], $userId,
			$this->_options['groupIdField'], $this->_options['groupIdField']);
		$rs = $this->_conn->Execute($sql);
		if ($rs === false) {
			trigger_error('SQL Syntax error when reading the user\'s groups.',
				E_USER_ERROR);
			die();
		} else {
			for (; !$rs->EOF; $rs->MoveNext()) {
				$groups[$rs->fields[0]] = true;
			}
		}
		return $groups;
	}
}

?>
