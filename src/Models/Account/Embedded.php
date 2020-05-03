<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read \AmoPRO\AmoCRM\Models\Account\UsersCollection $users
 * @property-read \AmoPRO\AmoCRM\Models\Account\CustomFields $custom_fields
 * @property-read \AmoPRO\AmoCRM\Models\Account\NoteTypesCollection $note_types
 * @property-read \AmoPRO\AmoCRM\Models\Account\GroupsCollection $groups
 * @property-read \AmoPRO\AmoCRM\Models\Account\TaskTypesCollection $task_types
 * @property-read \AmoPRO\AmoCRM\Models\Account\PipelinesCollection $pipelines
 */
final class Embedded extends Obj
{
    public function schema(): array
    {
        return [
            'users'         => UsersCollection::class,
            'custom_fields' => CustomFields::class,
            'note_types'    => NoteTypesCollection::class,
            'groups'        => GroupsCollection::class,
            'task_types'    => TaskTypesCollection::class,
            'pipelines'     => PipelinesCollection::class
        ];
    }
}