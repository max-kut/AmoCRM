<?php

namespace AmoPRO\AmoCRM\Query;

final class AccountWith
{
    private $params = [
        'custom_fields' => false,
        'users'         => false,
        'pipelines'     => false,
        'groups'        => false,
        'note_types'    => false,
        'task_types'    => false
    ];

    /**
     * @return static
     */
    public static function all(): self
    {
        return (new static)->customFields()->groups()->noteTypes()->pipelines()->taskTypes()->users();
    }

    /**
     * @param bool $include
     * @return static
     */
    public function customFields(bool $include = true)
    {
        $this->params['custom_fields'] = $include;

        return $this;
    }

    /**
     * @param bool $include
     * @return static
     */
    public function users(bool $include = true)
    {
        $this->params['users'] = $include;

        return $this;
    }

    /**
     * @param bool $include
     * @return static
     */
    public function pipelines(bool $include = true)
    {
        $this->params['pipelines'] = $include;

        return $this;
    }

    /**
     * @param bool $include
     * @return static
     */
    public function groups(bool $include = true)
    {
        $this->params['groups'] = $include;

        return $this;
    }

    /**
     * @param bool $include
     * @return static
     */
    public function noteTypes(bool $include = true)
    {
        $this->params['note_types'] = $include;

        return $this;
    }

    /**
     * @param bool $include
     * @return static
     */
    public function taskTypes(bool $include = true)
    {
        $this->params['task_types'] = $include;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return implode(',', array_keys(array_filter($this->params)));
    }
}