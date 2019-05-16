<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\ { Category, Region, Ad, Upload };
use App\Repositories\AdRepository;
use App\Http\Requests\AdStore;
use Carbon\Carbon;

class AdController extends Controller
{
    /**
     * Ad repository.
     *
     * @var App\Repositories\AdRepository
     */
    protected $adRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AdRepository $adRepository)
    {
        $this->adRepository = $adRepository;
    }

    /**
     * Search ads.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $slug
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        setlocale (LC_TIME, 'fr_FR');

        $ads = $this->adRepository->search($request);

        return view('partials.ads', compact('ads'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $regionSlug
     * @param  Integer  $departementCode
     * @param  Integer  $communeCode
     * @return \Illuminate\Http\Response
     */
    public function index(
        Request $request,
        $regionSlug = null,
        $departementCode = null,
        $communeCode = null)
    {
        $categories = Category::select('name', 'id')->oldest('name')->get();
        $regions = Region::select('id','code','name','slug')->oldest('name')->get();
        $region = $regionSlug ? Region::whereSlug($regionSlug)->firstOrFail() : null;
        $page = $request->query('page', 0);

        return view('adsvue', compact('categories', 'regions', 'region', 'departementCode', 'communeCode', 'page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(!$request->session()->has('index')) {
            $request->session()->put('index', Str::random(30));
        }

        $categories = Category::select('name', 'id')->oldest('name')->get();
        $regions = Region::oldest('name')->get();

        return view('create', compact('categories', 'regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\AdStore  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdStore $request)
    {
        $commune = json_decode(file_get_contents('https://geo.api.gouv.fr/communes/' . $request->commune), true);

        $ad = $this->adRepository->create([
            'title' => $request->title,
            'texte' => $request->texte,
            'category_id' => $request->category,
            'region_id' => $request->region,
            'departement' => $request->departement,
            'commune' => $request->commune,
            'commune_name' => $commune['nom'],
            'commune_postal' => $commune['codesPostaux'][0],
            'user_id' => auth()->check() ? auth()->id() : 0,
            'pseudo' => auth()->check() ? auth()->user()->name :$request->pseudo,
            'email' => auth()->check() ? auth()->user()->email : $request->email,
            'limit' => Carbon::now()->addWeeks($request->limit),
        ]);

        if($request->session()->has('index')) {
            $index = $request->session()->get('index');
            Upload::whereIndex($index)->update(['ad_id' => $ad->id, 'index' => 0]);
        }

        return view('adconfirm');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ad  $ad
     * @return \Illuminate\Http\Response
     */
    public function show(Ad $ad)
    {
        $this->authorize('show', $ad);

        $photos = $this->adRepository->getPhotos($ad);

        return view('ad', compact('ad', 'photos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}