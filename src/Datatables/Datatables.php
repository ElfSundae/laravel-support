<?php

namespace ElfSundae\Laravel\Support\Datatables;

use Yajra\Datatables\Datatables as BaseDatatables;
use ElfSundae\Laravel\Support\Datatables\Engines\EloquentEngine;

class Datatables extends BaseDatatables
{
    /**
     * Datatables using Eloquent.
     *
     * @param  mixed $builder
     * @return \ElfSundae\Laravel\Support\Datatables\Engines\EloquentEngine
     */
    public function usingEloquent($builder)
    {
        return new EloquentEngine($builder, $this->request);
    }
}
