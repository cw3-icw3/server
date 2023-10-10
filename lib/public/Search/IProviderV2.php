<?php

declare(strict_types=1);

/**
 * @copyright 2023 Benjamin Gaussorgues <benjamin.gaussorgues@nextcloud.com>
 *
 * @author Benjamin Gaussorgues <benjamin.gaussorgues@nextcloud.com>
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
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 *
 */
namespace OCP\Search;

/**
 * Interface for search providers
 *
 * These providers will be implemented in apps, so they can participate in the
 * global search results of Nextcloud. If an app provides more than one type of
 * resource, e.g. contacts and address books in Nextcloud Contacts, it should
 * register one provider per group.
 *
 * @since 28.0.0
 */
interface IProviderV2 extends IProvider {
	/**
	 * Return the names of filters supported by the application
	 *
	 * If a filter sent by client is not in this list,
	 * the current provider will be ignored.
	 * Example:
	 *   array('term', 'since', 'custom-filter');
	 *
	 * @since 28.0.0
	 * @return string[]
	 */
	public function getSupportedFilters(): array;

	/**
	 * Get alternate IDs handled by this provider
	 *
	 * A search provider can complete results from other search providers.
	 * For example, files and full-text-search can search in files.
	 * If you use `in:files` in a search, provider files will be invoked,
	 * with all other providers declaring `files` in this method
	 *
	 * @since 28.0.0
	 * @return array{array-key, literal-string} IDs
	 */
	public function getAlternateIds(): array;

	/**
	 * Allows application to declare custom filters
	 *
	 * Filter must be a name and a class name implementing IFilter
	 * Example:
	 *   array(
	 *     'mimetype' => Filter\StringFilter::class,
	 *     'is-favorite' => Filter\BoolFilter::class,
	 *   );
	 *
	 * @since 28.0.0
	 * @return array{string, class-string}
	 */
	public function registerCustomFilters(): array;
}
