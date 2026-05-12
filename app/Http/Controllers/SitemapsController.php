<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App;
use URL;
use File;
use DB;

//models
use App\Models\Client\Client;
use App\Models\Keyword;


class SitemapsController extends Controller
{
	public function index()
	{
		$keywords = DB::table('keyword');		 
		$keywords = $keywords->select('updated_at','slug');		 
		$keywords = $keywords->get();
		return response()->view('client.sitemap', ['keywords' => $keywords])->header('Content-Type', 'text/xml');
	}
	public function city()
	{
		$keywords = DB::table('keyword');		 
		$keywords = $keywords->select('updated_at','slug');		 
		$keywords = $keywords->get();
		return response()->view('client.sitemap_city', ['keywords' => $keywords])->header('Content-Type', 'text/xml');
 
	}
	public function storeSitemap()
	{
		$sitemap = App::make("sitemap");

		// ************
		// STATIC LINKS
		$sitemap->add(URL::to('/'), (new \DateTime())->format(DATE_ATOM), '1.00', 'weekly');
		$sitemap->add(URL::to('/disclaimer'), (new \DateTime())->format(DATE_ATOM), '0.80', 'weekly');
		$sitemap->add(URL::to('/business-owners'), (new \DateTime())->format(DATE_ATOM), '0.80', 'weekly');
		$sitemap->add(URL::to('/clients'), (new \DateTime())->format(DATE_ATOM), '0.80', 'weekly');
		// STATIC LINKS
		// ************

		// ********************
		// GETTING STATIC FILES
		$directory = resource_path();
		if (File::exists($directory . "/views/client/html")) {
			$files = File::allFiles($directory . "/views/client/html");
			foreach ($files as $file) {
				//echo (string)$file."\n";
				$file = explode('/', $file);
				$file = end($file);
				$file = preg_replace('/php/i', 'html', $file);
				$sitemap->add(URL::to('/' . $file), (new \DateTime())->format(DATE_ATOM), '0.80', 'weekly');
			}
		}
		 

		// ****************************************
		// SEARCHLIST URL BASED ON CITY AND KEYWORD
		$keywords = DB::table('keyword');
		$keywords = $keywords->join('cities', 'cities.id', '=', 'keyword.city_id');
		$keywords = $keywords->select('keyword.keyword','keyword.slug', 'cities.city');
		 
		$keywords = $keywords->get();
		foreach ($keywords as $keyword) {
			$sitemap->add(URL::to('/' . generate_slug($keyword->city) . '/' . $keyword->slug), $keyword->updated_at, '0.80', 'weekly');
		}
	 
		$sitemap->store('xml', 'sitemap');
	}


	public function blog()
	{
 
		$blogs = DB::table('blogdetails');
		$blogs = $blogs->select('title', 'slug','updated_at');
		$blogs = $blogs->get();

		$keywords = DB::table('keyword');
		$keywords = $keywords->select('slug', 'updated_at');
		$keywords = $keywords->get();
		return response()->view('client.sitemap-blog', ['blogs' => $blogs,'keywords'=>$keywords])->header('Content-Type', 'text/xml');
	}


	public function online()
	{
		$keywords = DB::table('keyword');
		$keywords = $keywords->select('slug', 'updated_at');
		$keywords = $keywords->get();
		return response()->view('client.sitemap-online', ['keywords'=>$keywords])->header('Content-Type', 'text/xml');
	}

	public function keyword()
	{
		$keywords = DB::table('keyword');
		$keywords = $keywords->select('slug', 'updated_at');
		$keywords = $keywords->get();
		return response()->view('client.sitemap_keyword', ['keywords'=>$keywords])->header('Content-Type', 'text/xml');
	}
	public function allcity()
	{
		$keywords = DB::table('keyword');
		$keywords = $keywords->select('slug', 'updated_at');
		$keywords = $keywords->get();
		return response()->view('client.sitemap_allcity', ['keywords'=>$keywords])->header('Content-Type', 'text/xml');
	}

}
