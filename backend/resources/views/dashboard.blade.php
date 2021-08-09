<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <a href="{{ url('/nova') }}">
                    <div class="p-6 bg-white border-b border-gray-200 items-center">
                        <span class="iconify text-2xl inline" data-icon="cib:laravel-nova" data-inline="true"></span>
                        Nova
                    </div>
                </a>
                <a href="{{ url('/graphql-playground') }}">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <span class="iconify text-2xl inline" data-icon="logos:graphql" data-inline="false"></span>
                        GraphQL Playground
                    </div>
                </a>
                <a href="{{ route('swagger') }}">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <span class="iconify text-2xl inline" data-icon="logos-swagger" data-inline="false"></span>
                        Swagger
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
