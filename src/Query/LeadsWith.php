<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Query\With\HasCatalogElementsLinks;
use AmoPRO\AmoCRM\Query\With\HasIsPriceModifiedByRobot;
use AmoPRO\AmoCRM\Query\With\HasLossReasonName;

final class LeadsWith extends AbstractWidth
{
    use HasIsPriceModifiedByRobot;
    use HasLossReasonName;
    use HasCatalogElementsLinks;

    /**
     * @return static
     */
    public static function all(): self
    {
        return (new static)
            ->isPriceModifiedByRobot()
            ->lossReasonName()
            ->catalogElementsLinks();
    }

    /**
     * Если передать данный параметр, то в ответе на запрос метода, вернутся удаленные сделки, которые еще находятся в
     * корзине. В ответ вы получите дату изменения, id пользователя сделавшего последнее изменение, id сделки и
     * параметр is_deleted = true.
     *
     * @param bool $yes
     * @return static
     */
    public function onlyDeleted(bool $yes = true)
    {
        $this->attributes['only_deleted'] = $yes;

        return $this;
    }
}