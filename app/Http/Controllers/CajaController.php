<?php
/**
 * Created by PhpStorm.
 * User: lucas.sisi
 * Date: 4/7/2017
 * Time: 12:38
 */

namespace App\Http\Controllers;


class CajaController
{
    public function __construct()
    {

    }

    public function index()
    {
        return view("caja.index");
    }
}