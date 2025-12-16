@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 p-6 bg-white shadow rounded">
    <h1 class="text-xl font-bold mb-4">簡易ログイン</h1>

    @if($errors->any())
        <div class="bg-red-100 text-red-600 p-2 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.simple.submit') }}" method="POST">
        @csrf
        <label for="user_id" class="block mb-2">ユーザーID</label>
        <input type="number" name="user_id" id="user_id" class="border p-2 w-full" required>

        <button type="submit" class="mt-4 bg-blue-600 text-white px-4 py-2 rounded">
            ログイン
        </button>
    </form>
</div>
@endsection