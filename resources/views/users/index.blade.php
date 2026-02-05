<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
        </h2>
        {{-- <a href="{{ route('users.create') }}" class="bg-slate-400 text-sm rounded-md px-5 py-4">Create</a> --}}
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table-auto w-full">
                        <thead>
                            <tr>
                                <th class="border px-4 py-2">#</th>
                                <th class="border px-4 py-2">Name</th>
                                <th class="border px-4 py-2">Email</th>
                                <th class="border px-4 py-2">Roles</th>
                                <th class="border px-4 py-2">Created At</th>
                                <th class="border px-4 py-2">Actions</th>

                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="border px-4 py-2">{{ $user->id }}</td>
                                    <td class="border px-4 py-2">{{ $user->name }}</td>
                                    <td class="border px-4 py-2">{{ $user->email }}</td>
                                    <td class="border px-4 py-2">{{ $user->roles->pluck('name')->implode(', ') }}</td>
                                    <td class="border px-4 py-2">{{ $user->created_at }}</td>
                                    
                                    <td class="border px-4 py-2">
                                        <div class="flex justify-normal">
                                            @can('edit users')
                                            <a href="{{ route('users.edit', $user->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded-md mr-2">Edit</a>
                                            @endcan
                                            @can('delete users')    
                                            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
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
                        {{ $users->links() }} 
                    </div>  
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
