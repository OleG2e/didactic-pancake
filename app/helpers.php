<?php
/**
 * Created by PhpStorm.
 * User: olegbiruk
 * Date: 2019-01-13
 * Time: 19:39
 */


/**
 * @param $message
 */
function flash($message)
{
    session()->flash('message', $message);
}