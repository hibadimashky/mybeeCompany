<?php

namespace Modules\Accounting\Utils;

use Modules\Accounting\Models\AccountingCostCenter;

class CostCenterUtil
{
    public static function next_account_center_number($parent_account_id)
    {



        if ($parent_account_id != 'null') {
            $last_parent_costCenter = AccountingCostCenter::find($parent_account_id);

            $parentCode = $last_parent_costCenter->account_center_number;
            $lastChildCostCenter = AccountingCostCenter::where('parent_id', $parent_account_id)
                ->orderBy('id', 'desc')
                ->first();

            if ($lastChildCostCenter) {
                $lastNumber = (int)substr($lastChildCostCenter->account_center_number, strrpos($lastChildCostCenter->account_center_number, '-') + 1);

                $newNumber = $lastNumber + 1;

                return $newCode = $parentCode . '-' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
            } else {
                return $newCode = $parentCode . '-01';
            }
        } else {
            $last_parent_costCenter = AccountingCostCenter::where([['parent_id', '=', $parent_account_id]])->latest()->first();

            if ($last_parent_costCenter) {
                $lastNumber = (int)substr($last_parent_costCenter->account_center_number, strpos($last_parent_costCenter->account_center_number, '-') + 1);

                $newNumber = $lastNumber + 1;

                return  $last_code = 'MCC-' . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
            } else {
                return $last_code = 'MCC-01';
            }
        }
    }
}