<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Generated URLs') }}
        </h2>
        <a href="{{ route('genurls.create') }}" class="bg-slate-400 text-sm rounded-md px-5 py-4">Generate</a>
        </div>
    </x-slot>

    @if(!auth()->user()->hasRole('Member'))
         <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Clients') }}
                    </h2>
                    <a href="{{ route('genurls.invite') }}" class="bg-slate-400 text-sm rounded-md px-5 py-4">Invite</a>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">client name</th> 
                                <th class="border px-4 py-2">Total Users</th> 
                                <th class="border px-4 py-2">Total Generate URLs</th>
                                <th class="border px-4 py-2">Total URL Hits</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="border px-4 py-2">{{ $client->client->name }}</td>
                                    <td class="border px-4 py-2">{{ $client->total_users }}</td>
                                    <td class="border px-4 py-2">{{ $client->total_short_urls }}</td>
                                    <td class="border px-4 py-2">{{ $client->total_clicks }}</td>
                                
                                   
                            @endforeach
                        </tbody>
                    </table>  
                    <div class="mt-4">
                        {{ $clients->links() }} 
                    </div>  
                </div>
            </div>
        </div>
    </div>

    @endif

      <div class="py-5">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between">
                    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                        {{ __('Generated Short URLs') }}
                    </h2>
                     {{-- <select name="filter"
                            onchange="this.form.submit()"
                            class="border rounded px-3 py-2">

                        <option value="">All</option>
                        <option value="today" {{ request('filter')=='today'?'selected':'' }}>Today</option>
                        <option value="last_week" {{ request('filter')=='last_week'?'selected':'' }}>Last Week</option>
                        <option value="last_month" {{ request('filter')=='last_month'?'selected':'' }}>Last Month</option>
                        <option value="this_month" {{ request('filter')=='this_month'?'selected':'' }}>This Month</option>
                    </select> --}}
                    <a href="{{ route('genurls.pdf.download') }}" class="bg-slate-400 text-sm rounded-md px-5 py-4">Download</a>
                    </div>

                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">short_code</th> 
                                <th class="border px-4 py-2">long_url</th>
                                <th class="border px-4 py-2">Hits</th>
                                <th class="border px-4 py-2">Client</th>
                                <th class="border px-4 py-2">Created At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($genurls as $genurl)
                                <tr>
                                    <td class="border px-4 py-2">{{ $genurl->short_code }}</td>
                                    <td class="border px-4 py-2">{{ $genurl->long_url }}</td>
                                    <td class="border px-4 py-2">{{ $genurl->clicks }}</td>
                                    <td class="border px-4 py-2">{{ $genurl->client->name }}</td>
                                    <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($genurl->created_at)->format('d M Y') }}</td>
                                   
                            @endforeach
                        </tbody>
                    </table>  
                    <div class="mt-4">
                        {{ $genurls->links() }} 
                    </div>  
                </div>
            </div>

            
        </div>
        
    </div>

</x-app-layout>
