<?php

if (! function_exists('optimus_encode')) {
    /**
     * Encode a number with Optimus.
     *
     * @param  int  $number
     * @return int
     */
    function optimus_encode($number)
    {
        return app('optimus')->encode($number);
    }
}

if (! function_exists('optimus_decode')) {
    /**
     * Decode a number with Optimus.
     *
     * @param  int  $number
     * @return int
     */
    function optimus_decode($number)
    {
        return app('optimus')->decode($number);
    }
}
