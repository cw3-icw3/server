<?php

declare(strict_types=1);

namespace OCP\FilesMetadata\Model;

interface IMetadataQuery {
	public function retrieveMetadata(): void;
	public function enforceMetadataKey(string $metaKey): void;
	public function enforceMetadataValue(string $value): void;
	public function enforceMetadataValueInt(int $value): void;
	public function getMetadataValueField(): string;
	public function getMetadataValueIntField(): string;
}
