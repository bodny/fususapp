<?php

namespace App\Http\Controllers;

use ArticleTestDataSeeder;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Artisan;
use RefreshRandomData;
use SensioLabs\AnsiConverter\AnsiToHtmlConverter;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;
use RandomDataSeeder;

/**
 * Class DataGeneratorController
 * @package App\Http\Controllers
 * @copyright (c) 2020
 * @author Tomas Bodnar <bodnarto@gmail.com>
 */
class DataGeneratorController extends Controller
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
    public function index()
    {
        return view('data-generator');
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function truncate()
    {
        $seeder =  new RefreshRandomData();
        $seeder->truncate();

        return back()->with(
            [
                'status' => 'Data were truncated.',
                'level' => 'success',
            ]
        );
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function generateRandomData()
    {
        $output = new BufferedOutput(OutputInterface::VERBOSITY_NORMAL, true);
        $resultCode = Artisan::call('db:seed', array('--class' => RandomDataSeeder::class), $output);

        $converter = new AnsiToHtmlConverter();
        $content = $output->fetch();

        if ($resultCode > 0) {
            return back()->with(
                [
                    'status' => 'Random data generation failed.',
                    'level' => 'danger',
                ]
            );
        }

        return back()->with(
            [
                'status' => 'Random data generated.',
                'level' => 'success',
            ]
        );
    }

    /**
     * @return Application|RedirectResponse|Redirector
     */
    public function generateArticleTestData()
    {
        $output = new BufferedOutput(OutputInterface::VERBOSITY_NORMAL, true);
        $resultCode = Artisan::call('db:seed', array('--class' => ArticleTestDataSeeder::class), $output);

        $converter = new AnsiToHtmlConverter();
        $content = $output->fetch();

        if ($resultCode > 0) {
            return back()->with(
                [
                    'status' => 'Article test data generation failed.',
                    'level' => 'danger',
                ]
            );
        }

        return back()->with(
            [
                'status' => 'Article test data generated.',
                'level' => 'success',
            ]
        );
    }
}
