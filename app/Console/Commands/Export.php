<?php
namespace App\Console\Commands;

ini_set('memory_limit', '-1');

use Illuminate\Console\Command;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Export extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ig:export {--site_name=Super Insta} {base_url} {to=html}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export Data to html, blogspot, wordpress';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $base_url = $this->argument('base_url');
        $exportTo = $this->argument('to');
        $site_name = $this->option('site_name');

        $this->html($site_name, $base_url);
    }

    private function getFiles()
    {
        $files = Storage::disk('data_scrape')->allFiles();
        return array_filter($files, function($item){
            if (Str::isAscii($item)) {
                return $item;
            }
        });
    }

    private function getData(string $file)
    {
        try {
            return @unserialize(Storage::disk('data_scrape')->get($file));
        } catch (FileNotFoundException $e) {
            return $e->getMessage();
        }
    }

    private function getDataFile()
    {
        $file = collect($this->getFiles())->shuffle()->first();
        return $this->getData($file);
    }

    private function html(string $site_name, string $base_url)
    {
        $pages = [
            'dmca', 'copyright', 'privacy-policy', 'dmca'
        ];

        // Create Index.html
        Storage::disk('data_export')
                ->put("html/index.html", view('satu.home', [
                    'site_name' => $site_name,
                    'all_files' => $this->getFiles(),
                    'file' => $this->getDataFile(),
                    'pages' => $pages
                ]));

        // Create pages
        foreach ($pages as $page) {
            Storage::disk('data_export')
                ->put("html/{$page}.html", view('satu.pages.page', [
                    'page' => $page,
                    'site_name' => $site_name,
                ]));
        }
        $this->info('Index and Pages Created');

        $files = $this->getFiles();
        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        foreach ($files as $file) {
            $file_name = str_replace('.srz.php', '', $file);

            Storage::disk('data_export')
                ->put("html/{$file_name}.html", view('satu.tag', [
                    'site_name' => $site_name,
                    'all_files' => $this->getFiles(),
                    'tag' => $file_name,
                    'file' => $this->getData($file),
                    'pages' => $pages
                ]));

            $bar->advance();
        }

        $bar->finish();

        $this->getSitemapXml();
    }

    /**
     * Build sitemap.txt on path exports/html. Generate from all files html
     * @param string $base_url
     */
    private function buildSitemap(string $base_url)
    {
        $base_url = Str::endsWith($base_url, '/') ? $base_url : $base_url . '/';

        $data_export = Storage::disk('data_export');
        $files = $data_export->allFiles();
        $files = array_map(function ($item) use ($base_url) {
            if (!Str::contains($item, 'index.html')) {
                return str_replace("html/", $base_url, $item);
            } else {
                return $base_url;
            }
        }, $files);

        $content = implode("\n", $files);
        $data_export->put('html/sitemap.txt', $content);
        $this->info('Sitemap is created');
    }

    public function getSitemapXml(string $base_url)
    {
        $data_export = Storage::disk('data_export');
        $files = $data_export->allFiles();
        $files = array_map(function ($item) use ($base_url) {
            if (!Str::contains($item, 'index.html')) {
                return str_replace("html/", $base_url, $item);
            } else {
                return $base_url;
            }
        }, $files);

        $content = view('sitemap', compact('files'));
        $data_export->put('html/sitemap.xml', $content);
        $this->info('Sitemap is created');
    }
}
