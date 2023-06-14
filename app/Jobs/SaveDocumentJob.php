<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Document;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveDocumentJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var
     */
    private $data;

    /**
     * Create a new job instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $data = $this->data;
        $document = new Document();
        $document->fill($data);
        $document->category_id = self::getCategoryID($data['category']);
        $document->save();
    }

    /**
     * @param $category
     * @return string
     */
    private static function getCategoryID($category): string
    {
        return Category::where('name', trim($category))->first()->id;
    }
}
