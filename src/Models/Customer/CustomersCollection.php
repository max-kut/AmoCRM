<?php

namespace AmoPRO\AmoCRM\Models\Customer;

use AmoPRO\AmoCRM\Data\Collection;
use AmoPRO\AmoCRM\Exceptions\ValidationException;
use AmoPRO\AmoCRM\Models\HasErrorsInCollection;

class CustomersCollection extends Collection
{
    use HasErrorsInCollection;

    public function getNestedClassName(): string
    {
        return Customer::class;
    }

    /**
     * @return array|array[]
     */
    public function toRequest(): array
    {
        if ($this->isEmpty()) {
            throw new ValidationException(sprintf('No items in %s for creating, updating or deleting', static::class));
        }

        $body = [
            'add'    => [],
            'update' => [],
            'delete' => []
        ];

        /** @var \AmoPRO\AmoCRM\Models\Customer\Customer $customer */
        foreach ($this->all() as $customer) {
            if($customer->id){
                if($customer->_delete){
                    $body['delete'][] = $customer->id;
                } else {
                    if(empty($customer->updated_at)){
                        throw new ValidationException('Required param "updated_at" for updating customer is empty');
                    }
                    $body['update'][] = $customer->toRequest();
                }
            } else {
                $body['add'][] = $customer->toRequest();
            }
        }

        return $body;
    }

    private $deleted = null;

    /**
     * @return null|\AmoPRO\AmoCRM\Models\Customer\CustomersCollection
     */
    public function getDeleted(): ?CustomersCollection
    {
        return $this->deleted;
    }

    /**
     * @param \AmoPRO\AmoCRM\Models\Customer\CustomersCollection|null $deleted
     *
     * @return static
     */
    public function setDeleted(?CustomersCollection $deleted): self
    {
        $this->deleted = $deleted;

        return $this;
    }
}