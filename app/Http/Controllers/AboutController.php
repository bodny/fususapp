<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;

/**
 * Class AboutController
 * @package App\Http\Controllers
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class AboutController extends Controller
{
    /**
     * @return Renderable
     */
    public function __invoke()
    {
        return view('about');
    }
}
