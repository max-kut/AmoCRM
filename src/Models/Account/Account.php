<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Attribute;
use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read int $id
 * @property-read int $current_user
 * @property-read string $name
 * @property-read string $subdomain
 * @property-read string $currency
 * @property-read string $timezone
 * @property-read string $timezone_offset
 * @property-read string $language
 * @property-read \AmoPRO\AmoCRM\Models\Account\DatePattern $date_pattern
 * @property-read \AmoPRO\AmoCRM\Models\Account\Embedded $_embedded
 */
final class Account extends Obj
{
    public function schema(): array
    {
        return [
            'id'              => Attribute::TYPE_INT,
            'name'            => Attribute::TYPE_STRING,
            'subdomain'       => Attribute::TYPE_STRING,
            'currency'        => Attribute::TYPE_STRING,
            'timezone'        => Attribute::TYPE_STRING,
            'timezone_offset' => Attribute::TYPE_STRING,
            'language'        => Attribute::TYPE_STRING,
            'current_user'    => Attribute::TYPE_INT,
            'date_pattern'    => DatePattern::class,
            '_embedded'       => Embedded::class
        ];
    }

    /**
     * @return \AmoPRO\AmoCRM\Models\Account\UsersCollection|null
     */
    public function getUsers(): ?UsersCollection
    {
        return $this->_embedded->users;
    }

    /**
     * @return \AmoPRO\AmoCRM\Models\Account\GroupsCollection|null
     */
    public function getGroups(): ?GroupsCollection
    {
        return $this->_embedded->groups;
    }

    /**
     * @return \AmoPRO\AmoCRM\Models\Account\CustomFields|null
     */
    public function getCustomFields(): ?CustomFields
    {
        return $this->_embedded->custom_fields;
    }

    /**
     * @return \AmoPRO\AmoCRM\Models\Account\NoteTypesCollection|null
     */
    public function getNoteTypes(): ?NoteTypesCollection
    {
        return $this->_embedded->note_types;
    }

    /**
     * @return \AmoPRO\AmoCRM\Models\Account\TaskTypesCollection|null
     */
    public function getTaskTypes(): ?TaskTypesCollection
    {
        return $this->_embedded->task_types;
    }

    /**
     * @return \AmoPRO\AmoCRM\Models\Account\PipelinesCollection|null
     */
    public function getPipelines(): ?PipelinesCollection
    {
        return $this->_embedded->pipelines;
    }
}
