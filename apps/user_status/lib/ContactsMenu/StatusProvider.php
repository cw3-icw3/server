<?php

declare(strict_types=1);

/*
 * @copyright 2023 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @author 2023 Christoph Wurst <christoph@winzerhof-wurst.at>
 *
 * @license GNU AGPL version 3 or any later version
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as
 * published by the Free Software Foundation, either version 3 of the
 * License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace OCA\UserStatus\ContactsMenu;

use OCA\UserStatus\Service\StatusService;
use OCP\AppFramework\Db\DoesNotExistException;
use OCP\Contacts\ContactsMenu\IEntry;
use OCP\Contacts\ContactsMenu\IProvider;

class StatusProvider implements IProvider {

	public function __construct(private StatusService $statusService) {
	}

	public function process(IEntry $entry): void {
		$uid = $entry->getProperty('UID');
		if ($uid === null) {
			return;
		}

		try {
			$status = $this->statusService->findByUserId($uid);
		} catch (DoesNotExistException $e) {
			return;
		}

		$entry->setStatus(
			$status->getStatus(),
			$status->getCustomMessage(),
			$status->getCustomIcon(),
		);
	}

}
