<?php

namespace WalkerChiu\Currency\Models\Entities;

use WalkerChiu\Core\Models\Entities\Lang;

class CurrencyLang extends Lang
{
    /**
     * @param array $attributes
     */
    public function __construct(array $attributes = array())
    {
        $this->table = config('wk-core.table.currency.currencies_lang');

        parent::__construct($attributes);
    }
}
