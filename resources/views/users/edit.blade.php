<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
             <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users/Create
            </h2>
            <a href="{{ route('users.index') }}" class="bg-slate-700 text-sm rounded-md px-5 py-4">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                  <form action="{{ route('users.update', $user->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    <div>
                        <label for="name" class="text-sm font-medim">User name</label>
                        <div class="mb-3">
                            <input type="text" placeholder="Enter name" name="name"  value="{{ $user->name }}" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                              @error('name')
                                <p class="text-red-500 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        <label for="email" class="text-sm font-medim">User email</label>
                        <div class="mb-3">
                            <input type="email" readonly name="email" value="{{ $user->email }}" class="border-gray-300 shadow-sm w-1/2 rounded-lg">
                  
                        </div>

                        <label for="roles" class="text-sm font-medim">Assign Roles</label>
                         <div class="grid grid-cols-4">
                                 <select name="roles[]" class="border-gray-300 shadow-sm w-1/2 rounded-lg mb-2">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"
                                            {{ in_array($role->name, $hasRole) ? 'selected' : '' }}>
                                            {{ $role->name }}
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
