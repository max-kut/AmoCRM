<?php

namespace AmoPRO\AmoCRM\Query;

final class AccountQuery extends AbstractQuery
{
    /**
     * AccountQuery constructor.
     *
     * @param \AmoPRO\AmoCRM\Query\AccountWith|null $with
     */
    public function __construct(?AccountWith $with = null)
    {
        $this->with($with);
    }

    /**
     * @param \AmoPRO\AmoCRM\Query\AccountWith|null $with
     * @return static
     */
    public function with(?AccountWith $with)
    {
        $this->params['with'] = (string)$with ?: null;

        return $this;
    }

    /**
     * @param bool $yes
     * @return static
     */
    public function withFreeUsers(bool $yes = true)
    {
        $this->params['free_users'] = $yes ? 'Y' : null;

        return $this;
    }
}