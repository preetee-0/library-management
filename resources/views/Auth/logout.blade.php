{{-- resources/views/auth/logout.blade.php --}}
@extends('layouts.app')

@section('title', 'Logout')

@section('content')
<div class="py-12">
    <div class="max-w-md mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 text-center">
            
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    Logout Confirmation
                </h2>
                <p class="text-gray-600 mb-6">
                    Are you sure you want to logout from your account?
                </p>
                
                <div class="flex justify-center space-x-4">
                    <a href="{{ url()->previous() }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 transition">
                        Cancel
                    </a>
                    
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="px-6 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                            Yes, Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection