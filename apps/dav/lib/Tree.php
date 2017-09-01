<?php
/**
 * @author Vincent Petry <pvince81@owncloud.com>
 *
 * @copyright Copyright (c) 2017, ownCloud GmbH
 * @license AGPL-3.0
 *
 * This code is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License, version 3,
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License, version 3,
 * along with this program.  If not, see <http://www.gnu.org/licenses/>
 *
 */

namespace OCA\DAV;

use OCA\DAV\Connector\Sabre\Exception\Forbidden;
use OCA\DAV\Connector\Sabre\Exception\InvalidPath;
use OCA\DAV\Connector\Sabre\Exception\FileLocked;
use OCP\Files\ForbiddenException;
use OCP\Files\StorageInvalidException;
use OCP\Files\StorageNotAvailableException;
use OCP\Lock\LockedException;
use OC\Files\View;
use Sabre\DAV\Exception\NotFound;
use Sabre\DAV\ICollection;
use OCA\DAV\Connector\Sabre\Node;

/**
 * Sabre tree of nodes.
 *
 * Provides a shortcut when accessing the "files/" subtree to avoid
 * having to walk through every node and trigger unnecessary extra queries.
 */
class Tree extends \Sabre\DAV\Tree {

	/**
	 * Creates the tree
	 *
	 * @param \Sabre\DAV\INode $rootNode
	 */
	public function __construct(ICollection $rootNode) {
		$this->rootNode = $rootNode;
	}

	public function cacheNode(Node $node) {
		$this->cache[trim($node->getPath(), '/')] = $node;
	}

	/**
	 * Returns the INode object for the requested path
	 *
	 * @param string $path
	 * @return \Sabre\DAV\INode
	 * @throws InvalidPath
	 * @throws \Sabre\DAV\Exception\Locked
	 * @throws \Sabre\DAV\Exception\NotFound
	 * @throws \Sabre\DAV\Exception\Forbidden
	 * @throws \Sabre\DAV\Exception\ServiceUnavailable
	 */
	public function getNodeForPath($path) {
		if (strpos($path, 'files/') !== 0) {
			return parent::getNodeForPath($path);
		}


	}
}
