<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
             <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Generate URLs/Create
            </h2>
            <a href="{{ route('genurls.index') }}" class="bg-slate-700 text-sm rounded-md px-5 py-4">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                  <form action="{{ route('genurls.store') }}" method="post">
                    @csrf
                    <div>
                        <label for="short_urls_name" class="text-sm font-medium">Short Code</label>
                        <div class="mb-3">
                            <input type="text" placeholder="Enter short urls" name="short_urls_name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                              @error('short_urls_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="long_urls_name" class="text-sm font-medium">Long URLs</label>
                        <div class="mb-3">
                            <input type="text" placeholder="Enter long urls" name="long_urls_name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                              @error('long_urls_name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        
                          <label for="roles" class="text-sm font-medim">clients name</label>
                         <div class="grid grid-cols-4">
                                 <select name="client_id" class="border-gray-300 shadow-sm w-1/2 rounded-lg mb-2">
                                    <option value="">Select client</option>
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">
                                            {{ $client->name }}
                                        </option>
                                    @endforeach
                                </select>
                        </div>

                       

                        <button class="bg-slate-400 text-sm rounded-md px-5 py-4">Submit</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
