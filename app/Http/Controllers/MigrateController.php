<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Show;

/**
 * Class ShowController.
 */
class MigrateController extends Controller
{
    public function migrateArticles()
    {
        $articles = Article::all();

        foreach ($articles as $article) {
            if ('/images/articles/old/' == $article->image) {
                $articles_list[] = $article->name;
                if (0 != count($article->episodes)) {
                    $article->image = '/images/shows/'.$article->episodes[0]->season->show->show_url.'.jpg';
                    $article->save();
                } elseif (0 != count($article->seasons)) {
                    $article->image = '/images/shows/'.$article->seasons[0]->show->show_url.'.jpg';
                    $article->save();
                } elseif (0 != count($article->shows)) {
                    $article->image = '/images/shows/'.$article->shows[0]->show_url.'.jpg';
                    $article->save();
                }
            }
        }

        dd($articles_list);
    }

    public function migrateImages()
    {
        $public = public_path();
        $shows = Show::all();

        foreach ($shows as $show) {
            if (!file_exists($public.'/images/shows/'.$show->show_url.'.jpg')) {
                $file = 'https://www.thetvdb.com/banners/posters/'.$show->thetvdb_id.'-1.jpg';
                $file_headers = get_headers($file);
                if (!$file_headers || 'HTTP/1.1 404 Not Found' == $file_headers[0] || 'HTTP/1.1 404 Not Found' == $file_headers[8] || 'HTTP/1.1 403 Forbidden' == $file_headers[8]) {
                    echo '';
                } else {
                    copy($file, $public.'/images/shows/'.$show->show_url.'.jpg');
                }
            }
        }
    }
}
