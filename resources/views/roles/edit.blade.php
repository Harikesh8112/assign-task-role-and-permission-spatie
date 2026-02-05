<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
             <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles/Create
            </h2>
            <a href="{{ route('roles.index') }}" class="bg-slate-700 text-sm rounded-md px-5 py-4">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                  <form action="{{ route('roles.update', $role->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name" class="text-sm font-medim">Role name</label>
                        <div class="mb-3">
                            <input type="text" value="{{ $role->name }}" name="name" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                            @error('name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                       <div class="grid grid-cols-4">
                            @foreach ($permissions as $permission)
                                <div>
                                    <input type="checkbox" {{ in_array($permission->name, $role->permissions->pluck('name')->toArray()) ? 'checked' : '' }} id="{{ $permission->name }}" name="permissions[]" value="{{ $permission->name }}" class="mr-2">
                                    <label for="{{ $permission->name }}">{{ $permission->name }}</label>
                                </div>
                            @endforeach
                        </div>

                        <button class="bg-slate-400 text-sm rounded-md px-5 py-4">Submit</button>
                    </div>
                  </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
