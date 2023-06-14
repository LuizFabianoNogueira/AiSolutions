<?php

namespace App\Http\Controllers;

use App\Jobs\SaveDocumentJob;
use App\Models\Category;
use App\Models\Document;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function import(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('imports.import');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addDocument(Request $request): JsonResponse
    {
        $document = new Document();
        $document->fill($request->all());
        $document->category_id = self::getCategoryID($request->get('category'));
        $document->save();

        return response()->json(['status' => 'OK']);
    }

    /**
     * @param $category
     * @return string
     */
    private static function getCategoryID($category): string
    {
        return Category::where('name', trim($category))->first()->id;
    }

    /**
     * @param Request $request
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function addDocumentJob(Request $request): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $uploadedFile = $request->file('jsonFile');
        $content = file_get_contents($uploadedFile->getPathname());
        $jsonData = json_decode($content, true);
        if (isset($jsonData['documentos'])) {
            foreach ($jsonData['documentos'] as $document) {
                $dados = [
                    'title' => $document['titulo'],
                    'category' => $document['categoria'],
                    'contents' => $document['conteúdo'],
                ];
                SaveDocumentJob::dispatch($dados);
            }
        }

        return view('imports.import')->with('message', 'Fila gerada com sucesso!');
    }
}
