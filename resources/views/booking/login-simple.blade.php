@extends('layouts.booking')

@section('content')
<div class="max-w-md mx-auto mt-10 p-6 bg-white rounded shadow">
    <h1 class="text-xl font-bold mb-4">簡易ログイン</h1>

    @if(session('error'))
        <p class="text-red-500">{{ session('error') }}</p>
    @endif

    <form method="POST" action="{{ route('login.simple') }}">
        @csrf
        <label for="user_id" class="block mb-2">ユーザーIDを入力してください</label>
        <input type="number" name="user_id" id="user_id" class="border p-2 w-full mb-4" required>

        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">ログイン</button>
    </form>
</div>
@endsection

