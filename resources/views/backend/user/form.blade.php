<!-- resources/views/backend/user/form.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ isset($user) ? 'Edit User: ' . $user->name : 'Create User' }}
            </h2>
        </div>
    </x-slot>



    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <div id="user-form" data-user="{{ isset($user) ? json_encode($user) : 'null' }}"></div> 
                </div>
            </div>
            @if(isset($user))
                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                    <div class="max-w-xl">
                        @include('backend.user.partials.delete-form')
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
