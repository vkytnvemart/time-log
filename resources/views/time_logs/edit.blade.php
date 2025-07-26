@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10">
    <div class="bg-white shadow-xl rounded-2xl p-6 max-w-xl mx-auto mt-10">
    <h2 class="text-xl font-bold text-gray-800 mb-6">✏️ Edit Task</h2>

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('time_logs.update', $timeLog->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">📅 Work Date</label>
            <input type="text" value="{{ \Carbon\Carbon::parse($timeLog->work_date)->format('d M Y') }}" class="w-full border-gray-300 bg-gray-100 rounded-md shadow-sm cursor-not-allowed" readonly>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-1">🧾 Task Description</label>
            <input type="text" name="description" value="{{ $timeLog->description }}" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">⏱️ Hours</label>
                <input type="number" name="hours" value="{{ $timeLog->hours }}" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">🕒 Minutes</label>
                <input type="number" name="minutes" value="{{ $timeLog->minutes }}" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
            </div>
        </div>

        <button type="submit" class="w-full px-6 py-2 bg-indigo-600 text-white font-semibold rounded-md hover:bg-indigo-700">
            💾 Update Task
        </button>
    </form>
</div>

</div>
@endsection
