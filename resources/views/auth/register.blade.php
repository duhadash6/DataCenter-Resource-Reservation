@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100 py-8 px-4">
    <div class="w-full max-w-md bg-white border border-gray-200 rounded-lg shadow-sm p-8">
        <h1 class="text-2xl font-semibold text-center text-blue-900 mb-2">Create an Account</h1>
        <h2 class="text-base font-medium text-center text-gray-600 mb-6">Academic Data Center Access</h2>
        
        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf
            
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                    Full Name <span class="text-red-600">*</span>
                </label>
                <input id="name" name="name" type="text" autocomplete="name" required autofocus
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                <span class="text-xs text-red-600 mt-1 block">@error('name') {{ $message }} @enderror</span>
            </div>
            
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                    Email Address <span class="text-red-600">*</span>
                </label>
                <input id="email" name="email" type="email" autocomplete="email" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                <span class="text-xs text-red-600 mt-1 block">@error('email') {{ $message }} @enderror</span>
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                    Password <span class="text-red-600">*</span>
                </label>
                <input id="password" name="password" type="password" autocomplete="new-password" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                <span class="text-xs text-red-600 mt-1 block">@error('password') {{ $message }} @enderror</span>
            </div>
            
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                    Confirm Password <span class="text-red-600">*</span>
                </label>
                <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition" />
                <span class="text-xs text-red-600 mt-1 block">@error('password_confirmation') {{ $message }} @enderror</span>
            </div>
            
            <div>
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">
                    Role <span class="text-red-600">*</span>
                </label>
                <select id="role" name="role" required
                    class="block w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-50 text-gray-900 focus:outline-none focus:ring-2 focus:ring-blue-800 focus:border-blue-800 transition">
                    <option value="">Select a role</option>
                    <option value="user">User / Student</option>
                    <option value="manager">Manager / Researcher</option>
                </select>
                <span class="text-xs text-red-600 mt-1 block">@error('role') {{ $message }} @enderror</span>
            </div>
            
            <button type="submit"
                style="width: 100%; padding: 8px 16px; background-color: #1e3a8a; color: white; font-weight: 500; border-radius: 6px; border: none; cursor: pointer; transition: all 0.3s;">
                Register
            </button>
        </form>
        
        <div class="mt-5 text-center">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a href="{{ route('login') }}" class="text-blue-900 hover:underline focus:outline-none focus:ring-2 focus:ring-blue-800 rounded">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection
