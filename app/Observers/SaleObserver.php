<?php

namespace App\Observers;

use App\Models\Sale;

class SaleObserver
{
    public function updating(Sale $sale)
    {
        if($sale->total_paid > 0)
        {
            $sale->payment_status = 'paying';
            // dd($sale);
        }

        if($sale->total_paid >= $sale->total_amount)
        {
            $sale->payment_status = 'completed';
        }
    }
}
