<?php

namespace App\View\Components\pdf;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class installment extends Component
{
    public $voucher;
    /**
     * Create a new component instance.
     */
    public function __construct($voucher)
    {
        $this->voucher = $voucher;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view(
            'components.pdf.installment',
            [
                'voucher' => $this->voucher,
            ]
        );
    }
}
