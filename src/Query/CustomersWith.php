<?php

namespace AmoPRO\AmoCRM\Query;

use AmoPRO\AmoCRM\Query\With\HasCatalogElementsLinks;
use AmoPRO\AmoCRM\Query\With\HasIsPriceModifiedByRobot;
use AmoPRO\AmoCRM\Query\With\HasLossReasonName;

final class CustomersWith extends AbstractWidth
{
    use HasIsPriceModifiedByRobot;
    use HasLossReasonName;
    use HasCatalogElementsLinks;
}