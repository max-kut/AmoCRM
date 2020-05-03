<?php

namespace AmoPRO\AmoCRM\Models\Account;

use AmoPRO\AmoCRM\Data\Obj;

/**
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $mail
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $incoming_leads
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $catalogs
 *
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $lead_add
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $lead_view
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $lead_edit
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $lead_delete
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $lead_export
 *
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $contact_add
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $contact_view
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $contact_edit
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $contact_delete
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $contact_export
 *
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $company_add
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $company_view
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $company_edit
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $company_delete
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $company_export
 *
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $task_edit
 * @property-read \AmoPRO\AmoCRM\Models\Account\Right $task_delete
 *
 * @property-read \AmoPRO\AmoCRM\Models\Account\RightsByStatus $by_status
 */
final class Rights extends Obj
{
    public function schema(): array
    {
        return [
            'mail'           => Right::class,
            'incoming_leads' => Right::class,
            'catalogs'       => Right::class,
            'lead_add'       => Right::class,
            'lead_view'      => Right::class,
            'lead_edit'      => Right::class,
            'lead_delete'    => Right::class,
            'lead_export'    => Right::class,
            'contact_add'    => Right::class,
            'contact_view'   => Right::class,
            'contact_edit'   => Right::class,
            'contact_delete' => Right::class,
            'contact_export' => Right::class,
            'company_add'    => Right::class,
            'company_view'   => Right::class,
            'company_edit'   => Right::class,
            'company_delete' => Right::class,
            'company_export' => Right::class,
            'task_edit'      => Right::class,
            'task_delete'    => Right::class,
            'by_status'      => RightsByStatus::class
        ];
    }
}