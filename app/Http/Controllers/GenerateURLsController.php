<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortURLs;
use App\Models\Client;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use App\Models\URLClick;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class GenerateURLsController extends Controller implements HasMiddleware
{
    //
    public static function middleware(): array
    {
        return [
            new Middleware('permission:view genurls', only: ['index', 'show']),
            new Middleware('permission:create genurls', only: ['create', 'store']),
            new Middleware('permission:edit genurls', only: ['edit', 'update']),
            new Middleware('permission:delete genurls', only: ['destroy']),
        ];
    }

    public function index()
    {
        $user = auth()->user();
        $clientsQuery = ShortURLs::with('client')
        ->select(
            'client_id',
            DB::raw('COUNT(DISTINCT user_id) as total_users'),
            DB::raw('COUNT(id) as total_short_urls'),
            DB::raw('SUM(clicks) as total_clicks')
        )
        ->groupBy('client_id');
        if (!$user->hasRole('superadmin')) {
            $clientsQuery->where('user_id', $user->id);
        }
        $clients = $clientsQuery->paginate(2);

        $query = ShortURLs::orderBy('created_at', 'desc');
        if (!$user->hasRole('superadmin')) {
            $query->where('user_id', $user->id);
        }
        $genurls = $query->paginate(2);
        return view('generateurls.index',compact('genurls','clients'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();
        return view('generateurls.create', compact('clients'));
    }

    public function store(Request $request)
    {
        //short_urls

        $request->validate([
            'short_urls_name' => 'required|string|max:255',
            'long_urls_name' => 'required|string|max:255',
            'client_id' => 'required|exists:clients,id',
        ]);
        $urls = new ShortURLs();
        $urls->short_code = $request->input('short_urls_name');
        $urls->long_url = $request->input('long_urls_name');
        $urls->client_id = $request->input('client_id');
        $urls->user_id = auth()->id();
        $urls->save();
        return redirect()->route('genurls.index')->with('success', 'Generated URL created successfully.');
       
    } 
    
    public function show($id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function invite()
    {
        return view('generateurls.invite');
    }


    public function hits_urls(Request $request, $code)
    {
        $userAgent =  $request->userAgent();
        $ipaddress =  $request->ip();
        $shortUrl = ShortURLs::where('short_code', $code)->firstOrFail();
        // store hit
        $urls = new URLClick();
        $urls->short_url_id = $shortUrl->id;
        $urls->ip = $request->ip();
        $urls->user_agent =  $request->userAgent();
        $urls->save();
        // increment total hits
        $shortUrl->increment('clicks');
        return redirect()->away($shortUrl->long_url);
            
    }

    public function genurlsPdfDownload(Request $request)
    {
        $user = auth()->user();
        $query = ShortURLs::orderBy('created_at', 'desc');
        if (!$user->hasRole('superadmin')) {
            $query->where('user_id', $user->id);
        }
        $genurls = $query->get();

        $pdf = Pdf::loadView('generateurls.pdfs', compact('genurls'))
                ->setPaper('A4', 'portrait');
        return $pdf->download('generated_urls.pdf');
    }
}
