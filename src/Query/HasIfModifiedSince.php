<?php

namespace AmoPRO\AmoCRM\Query;

use DateTimeInterface;

trait HasIfModifiedSince
{
    protected $ifModifiedSince;

    /**
     * @return \DateTimeInterface|null
     */
    public function getIfModifiedSince(): ?DateTimeInterface
    {
        return $this->ifModifiedSince;
    }

    /**
     * @param mixed $ifModifiedSince
     * @return static
     * @noinspection PhpUnused
     */
    public function setIfModifiedSince(?DateTimeInterface $ifModifiedSince)
    {
        $this->ifModifiedSince = $ifModifiedSince;

        return $this;
    }
}