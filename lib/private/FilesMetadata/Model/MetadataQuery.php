<?php

declare(strict_types=1);

namespace OC\FilesMetadata\Model;

use OC\FilesMetadata\Service\IndexRequestService;
use OC\FilesMetadata\Service\MetadataRequestService;
use OCP\DB\QueryBuilder\IQueryBuilder;
use OCP\FilesMetadata\Model\IMetadataQuery;

class MetadataQuery implements IMetadataQuery {

	public function __construct(
		private IQueryBuilder $queryBuilder,
		private string $alias = 'meta',
		private string $aliasIndex = 'meta_index'
	) {
	}

	public function leftJoinIndex(
		string $fileTableAlias,
		string $fileIdField,
	): void {
		$this->queryBuilder->leftJoin(
			$fileTableAlias, IndexRequestService::TABLE_METADATA_INDEX, $this->aliasIndex,
			$this->queryBuilder->expr()->eq($this->aliasIndex . '.file_id', $fileTableAlias . '.' . $fileIdField)
		);
	}

	public function retrieveMetadata(): void {
		$this->queryBuilder->selectAlias($this->alias . '.json', 'meta_json');
		$this->queryBuilder->leftJoin(
			$this->aliasIndex, MetadataRequestService::TABLE_METADATA, $this->alias,
			$this->queryBuilder->expr()->eq($this->aliasIndex . '.file_id', $this->alias . '.file_id')
		);
	}

	public function enforceMetadataKey(string $metaKey): void {
		$expr = $this->queryBuilder->expr();
		$this->queryBuilder->andWhere(
			$expr->eq(
				$this->getMetadataKeyField(),
				$this->queryBuilder->createNamedParameter($metaKey)
			)
		);
	}

	public function enforceMetadataValue(string $value): void {
		$expr = $this->queryBuilder->expr();
		$this->queryBuilder->andWhere(
			$expr->eq(
				$this->getMetadataKeyField(),
				$this->queryBuilder->createNamedParameter($value)
			)
		);
	}

	public function enforceMetadataValueInt(int $value): void {
		$expr = $this->queryBuilder->expr();
		$this->queryBuilder->andWhere(
			$expr->eq(
				$this->getMetadataValueIntField(),
				$this->queryBuilder->createNamedParameter($value, IQueryBuilder::PARAM_INT)
			)
		);
	}

	public function getMetadataKeyField(): string {
		return $this->aliasIndex . '.meta_key';// TODO: Implement getMetadataValueField() method.
	}

	public function getMetadataValueField(): string {
		return $this->aliasIndex . '.meta_value';// TODO: Implement getMetadataValueField() method.
	}

	public function getMetadataValueIntField(): string {
		return $this->aliasIndex . '.meta_value_int';// TODO: Implement getMetadataValueField() method.
	}
}
