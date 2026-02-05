<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Clients') }}
        </h2>
        <a href="{{ route('clients.create') }}" class="bg-slate-400 text-sm rounded-md px-5 py-4">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">#</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Email</th>
                                
                                <th class="border px-4 py-2">Created At</th>
                                <th class="border px-4 py-2">Actions</th>

                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($clients as $client)
                                <tr>
                                    <td class="border px-4 py-2">{{ $client->id }}</td>
                                    <td class="border px-4 py-2">{{ $client->name }}</td>
                                    <td class="border px-4 py-2">{{ $client->email }}</td>
                                  
                                    <td class="border px-4 py-2">{{ $client->created_at }}</td>
                                    
                                    <td class="border px-4 py-2">
                                        <div class="flex justify-normal">
                                            @can('edit clients')
                                            <a href="{{ route('clients.edit', $client->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2">Edit</a>
                                            @endcan
                                            @can('delete clients')    
                                            <form action="{{ route('clients.destroy', $client->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md">Delete</button>
                                            </form>
                                            @endcan
                                        </div> 
                                    </td>
                                </tr>
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
</x-app-layout>
