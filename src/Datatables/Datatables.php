<?php

namespace ElfSundae\Laravel\Support\Datatables;

use ElfSundae\Laravel\Support\Datatables\Engines\EloquentEngine;
use Yajra\Datatables\Datatables as BaseDatatables;

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
