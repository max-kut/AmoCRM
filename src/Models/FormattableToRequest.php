<?php

namespace AmoPRO\AmoCRM\Models;

use AmoPRO\AmoCRM\Exceptions\ValidationException;

trait FormattableToRequest
{
    public function toRequest(): array
    {
        if ($this->isEmpty()) {
            throw new ValidationException(sprintf('No items in %s for creating or updating', static::class));
        }

        $body = [
            'add'    => [],
            'update' => []
        ];

        /** @var \AmoPRO\AmoCRM\Models\CanAddOrUpdate $entity */
        foreach ($this->getIterator() as $entity) {
            if ($entity->id) {
                $this->validateUpdate($entity);
                $body['update'][] = $entity->toRequest();
            } else {
                $this->validateAdd($entity);
                $body['add'][] = $entity->toRequest();
            }
        }

        return $body;
    }

    /**
     * @param \AmoPRO\AmoCRM\Models\CanAddOrUpdate $entity
     */
    private function validateAdd(CanAddOrUpdate $entity): void
    {
        foreach ($entity->requiredAttributesForAdd() as $attributeName) {
            if (empty($entity->{$attributeName})) {
                throw new ValidationException(
                    sprintf('empty required param "%s" in add request in %s', $attributeName, static::class)
                );
            }
        }
    }

    /**
     * @param \AmoPRO\AmoCRM\Models\CanAddOrUpdate $entity
     */
    private function validateUpdate(CanAddOrUpdate $entity): void
    {
        foreach ($entity->requiredAttributesForUpdate() as $attributeName) {
            if (empty($entity->{$attributeName})) {
                throw new ValidationException(
                    sprintf('empty required param "%s" in update request in %s', $attributeName, static::class)
                );
            }
        }
    }
}