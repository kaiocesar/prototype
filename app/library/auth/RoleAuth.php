<?php

/* RoleAuth.php - Role-based user authentication component.
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
 * Role-based user authentication component.
 * This component implements user access by clasifyng users in groups where each group
 * has a set of roles. Later in your script you require one or more roles for the user.
 * If you add new groups to your application then you just add some roles to those groups
 * and you don't have to modify your sorce code.
 *
 * @package icreativa
 * @author Julio César Carrascal Urquijo <jcesar@phreaker.net>
 * @version 2.4 pl3
 * @access public
 */
class RoleAuth extends Auth {
//public:

	/**
	 * Constructor.
	 *
	 * @param array		key => val.
	 * @access public
	 */
	function RoleAuth($options = null) {
		$this->_options['groupsTable'] = 'groups';
		$this->_options['groupIdField'] = 'group_id';
		$this->_options['usersGroupsTable'] = 'users_groups';

		$this->_options['rolesTable'] = 'roles';
		$this->_options['roleIdField'] = 'role_id';
		$this->_options['roleNameField'] = 'name';
		$this->_options['groupsRolesTable'] = 'groups_roles';

		$this->Auth($options);
	}


	/**
	 * Require that the user has all roles passed as parameters.
	 * Force the user to identify himself (If he hasn't do it before) and ensures that
	 * he has each specified role. You can pass all the roles you need at once.
	 *
	 * @param string		name of each required role.
	 * @see requireAtLeast()
	 * @access public
	 */
	function requireRoles() {
		$this->forceLogin();

		$userId = $this->user[$this->_options['userIdField']];
		if (!isset($this->user['::roles::'])) {
			$this->user['::roles::'] = $this->_getRoles($userId);
		}

		// check each role.
		$roles = func_get_args();
		foreach ($roles as $role) {
			if (!isset($this->user['::roles::'][$role]) ||
				!$this->user['::roles::'][$role]) {
				$this->_callback(AUTH_ACCESS_DENIED,
					'You are not allowed to access this zone.');
			}
		}
	}


	/**
	 * Require that the user has at least one of the roles passed as parameters.
	 * Force the user to identify himself (If he hasn't do it before) and ensures that he
	 * has "at least" one of the specified roles. You can pass all the roles you need at
	 * once.
	 *
	 * @param string		name of each required roles.
	 * @see requireRoles()
	 * @access public
	 */
	function requireAtLeast() {
		$this->forceLogin();

		$userId = $this->user[$this->_options['userIdField']];
		if (!isset($this->user['::roles::'])) {
			$this->user['::roles::'] = $this->_getRoles($userId);
		}

		// we need at least one role.
		$autorized = false;
		$roles = func_get_args();
		foreach ($roles as $role) {
			if (isset($this->user['::roles::'][$role]) &&
				$this->user['::roles::'][$role]) {
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
	 * Search for the roles a user.
	 * Those roles are in relation to groups it belongs to. Returns an associative array
	 * for easy access.
	 *
	 * @param int			Of the user.
	 * @return array		role1 => true, role2 => true.
	 */
	function _getRoles($userId) {
		$this->_connect();

		$roles = array();
		$sql = sprintf('SELECT DISTINCT roles.%s '.
			'FROM %s users_groups, %s groups_roles, %s roles '.
			'WHERE users_groups.%s = %d AND groups_roles.%s = users_groups.%s AND '.
				'roles.%s = groups_roles.%s',
			$this->_options['roleNameField'], $this->_options['usersGroupsTable'],
			$this->_options['groupsRolesTable'], $this->_options['rolesTable'],
			$this->_options['userIdField'], $userId,
			$this->_options['groupIdField'], $this->_options['groupIdField'],
			$this->_options['roleIdField'], $this->_options['roleIdField']);
		$rs = $this->_conn->Execute($sql);
		if ($rs === false) {
			trigger_error('SQL Syntax error when reading the user\'s groups.'.$sql,
				E_USER_ERROR);
			die();
		} else {
			for (; !$rs->EOF; $rs->MoveNext()) {
				$roles[$rs->fields[0]] = true;
			}
		}
		return $roles;
	}
}

?>
