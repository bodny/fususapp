<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;
use RefreshRandomData;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use Whoops\Util\HtmlDumperOutput;

/**
 * Class SoftwareUsabilityController
 * @package App\Http\Controllers
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class SoftwareUsabilityController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('software-usability.index');
    }

    public function analyze()
    {
        $output = new BufferedOutput(OutputInterface::VERBOSITY_NORMAL, true);
        Artisan::call('fususapp:run', [], $output);

        $converter = new AnsiToHtmlConverter();
        $content = $output->fetch();

        return view('software-usability.analyze', [
            'command_output' => nl2br($converter->convert($content)),
        ]);
    }
}
