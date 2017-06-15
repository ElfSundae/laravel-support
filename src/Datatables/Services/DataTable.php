<?php

namespace ElfSundae\Laravel\Support\Datatables\Services;

use Yajra\Datatables\Services\DataTable as BaseDataTable;

abstract class DataTable extends BaseDataTable
{
    /**
     * Get attributes for a "static" column that can not be
     * ordered, searched, nor exported.
     *
     * @param  string  $name
     * @param  array  $attributes
     * @return $this
     */
    protected function staticColumn($name, array $attributes = [])
    {
        return array_merge([
            'data' => $name,
            'name' => $name,
            'title' => $this->builder()->getQualifiedTitle($name),
            'defaultContent' => '',
            'render' => null,
            'orderable' => false,
            'searchable' => false,
            'exportable' => false,
            'printable' => true,
            'footer' => '',
        ], $attributes);
    }

    /**
     * Return a render Closure for link.
     *
     * @param  string  $prefix
     * @param  string  $suffix
     * @param  string  $data
     * @param  string  $content
     * @return Closure
     */
    protected function linkRender($prefix = '', $suffix = '', $data = 'data', $content = 'data')
    {
        $prefix = trim($prefix, '/');
        $prefix = $prefix ? '/'.$prefix.'/' : '/';
        $suffix = $suffix ? '/'.$suffix : '';

        return function () use ($prefix, $suffix, $data, $content) {
            return <<<JS
function (data, type, row, meta) {
    if (type == 'display' && data) {
        return '<a href=\"{$prefix}' + {$data} + '{$suffix}\">' + {$content} + '</a>';
    }
    return data;
}
JS;
        };
    }

    /**
     * Get the avatar column data.
     *
     * @param  string  $avatar
     * @param  string  $originalAvatar
     * @param  string  $id
     * @param  string  $class
     * @param  string  $style
     * @return string
     */
    protected function avatarColumnData($avatar, $originalAvatar = null, $id = null, $class = 'img-circle', $style = 'width:28px')
    {
        $originalAvatar = $originalAvatar ?: $avatar;

        if ($avatar) {
            return <<<HTML
<a href='{$originalAvatar}' data-lightbox='avatar-{$id}'>
    <img src='{$avatar}' class='{$class}' style='{$style}'>
</a>
HTML;
        }
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return preg_replace('#datatable$#i', '', class_basename($this)).'-'.date('Ymdhis');
    }

    /**
     * Get default builder parameters.
     *
     * @return array
     */
    protected function getBuilderParameters()
    {
        return [
            'order' => [[0, 'desc']],
        ];
    }
}
