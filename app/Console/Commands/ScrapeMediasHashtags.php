<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use InstagramScraper\Exception\InstagramException;
use InstagramScraper\Exception\InstagramNotFoundException;
use InstagramScraper\Instagram;
use Unirest\Request as UnirestRequest;

class ScrapeMediasHashtags extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ig:scrape
                                {file : File lists hashtags ex."hashtags.txt" location on base_path()}
                                {limit=100 : Limit the amount of media output in the scrape}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scrape medias by hashtags';

    protected static $instagram;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Instagram $instagram)
    {
        parent::__construct();

        UnirestRequest::verifyPeer(false);
        self::$instagram = $instagram;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $file = $this->argument('file');
        $limit = $this->argument('limit');

        $files = $this->getFile($file);

        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        foreach ($files as $tag) {
            $this->getScrape($tag, $limit);
            $bar->advance();
        }

        $bar->finish();
    }

    private function getFile(string $file)
    {
        $file = base_path($file);
        $hashtags = explode("\n", file_get_contents($file));
        $hashtags = array_map(function ($item) {
                        return trim($item, "#");
                    }, $hashtags);
        $hashtags = array_values(array_filter($hashtags));

        return $hashtags;
    }

    private function getScrape(string $tag, int $limit)
    {
        try {
            if (Str::isAscii($tag) && !empty($tag)) {
                $media = self::$instagram->getMediasByTag($tag, $limit);
                Storage::disk('data_scrape')->put("{$tag}.srz.php", serialize($media));
            }else{
                $this->warn(" {$tag} Not Ascii");
            }
        }catch (InstagramException $e) {
            $this->error($e->getMessage());
            sleep(rand(5, 60));
        }catch (InstagramNotFoundException $e) {
            $this->error($e->getMessage());
            sleep(rand(5, 60));
        }
    }
}
