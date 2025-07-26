@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto mt-10">
  <div class="bg-white shadow-lg rounded-2xl p-6 mb-10">
    <h2 class="text-xl font-bold text-gray-800 mb-6">📝 Log Your Daily Tasks</h2>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 mb-4 rounded">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('time_logs.store') }}" id="timeLogForm">
        @csrf
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div>
                <label for="work_date" class="block text-sm font-medium text-gray-700 mb-1">📅 Work Date</label>
                <input type="date" name="work_date" id="work_date" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" max="{{ date('Y-m-d') }}" required>
            </div>
        </div>

        <div id="taskContainer">
            <div class="taskEntry grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">🧾 Task Description</label>
                    <input type="text" name="description[]" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required placeholder="E.g., Fix bug in dashboard">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">⏱️ Hours</label>
                    <input type="number" name="hours[]" min="0" max="10" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">🕒 Minutes</label>
                    <input type="number" name="minutes[]" min="0" max="59" class="w-full border rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
                </div>
            </div>
        </div>

        <div class="flex items-center gap-4 mt-4">
            <button type="button" onclick="addTask()" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                ➕ Add Another Task
            </button>
            <button type="submit" class="inline-flex items-center px-6 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                💾 Save Tasks
            </button>
        </div>
    </form>
</div>

    <hr class="my-6">

  <h3 class="text-2xl font-semibold mb-6 text-gray-800">🗓️ Logged Time Entries</h3>

@foreach($logs as $date => $tasks)
    @php
        $totalMinutes = $tasks->sum(fn($task) => ($task->hours * 60) + $task->minutes);
        $totalHours = floor($totalMinutes / 60);
        $remainingMinutes = $totalMinutes % 60;
        $isFullDay = $totalMinutes >= 600;
    @endphp

    <div class="bg-white shadow-md rounded-2xl p-6 mb-8 border border-gray-200">
        <div class="flex justify-between items-center mb-4">
            <div class="flex items-center gap-3">
                <div class="text-indigo-600 text-xl font-bold">
                    {{ \Carbon\Carbon::parse($date)->format('d M Y') }}
                </div>
                <span class="bg-gray-100 text-sm text-gray-600 px-2 py-1 rounded-md">
                    {{ $tasks->count() }} task{{ $tasks->count() > 1 ? 's' : '' }}
                </span>
            </div>

            <div class="text-sm font-semibold text-white px-3 py-1 rounded-lg
                        {{ $isFullDay ? 'bg-red-500' : 'bg-green-500' }}">
                Total: {{ $totalHours }}h {{ $remainingMinutes }}m
            </div>
        </div>

        <div class="divide-y divide-gray-100">
            @foreach($tasks as $task)
                <div class="py-3 flex justify-between items-start">
                    <div>
                        <div class="text-md text-gray-800 font-medium">
                            {{ $task->description }}
                        </div>
                        <div class="text-sm text-gray-500">
                            ⏱️ {{ $task->hours }}h {{ $task->minutes }}m
                        </div>
                    </div>
                    <div class="flex gap-3">
                        <a href="{{ route('time_logs.edit', $task->id) }}"
                           class="text-blue-600 hover:underline text-sm font-medium">
                            ✏️ Edit
                        </a>
                        {{-- Add delete if needed --}}
                        {{-- <form method="POST" action="{{ route('time_logs.destroy', $task->id) }}">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-500 text-sm">🗑️ Delete</button>
                        </form> --}}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endforeach

</div>

<script>
    function addTask() {
        const container = document.getElementById('taskContainer');
        const taskHtml = `
            <div class="taskEntry grid md:grid-cols-3 gap-4 mb-4">
                <div>
                    <input type="text" name="description[]" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required placeholder="E.g., Task name">
                </div>
                <div>
                    <input type="number" name="hours[]" min="0" max="10" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
                <div>
                    <input type="number" name="minutes[]" min="0" max="59" class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" required>
                </div>
            </div>`;
        container.insertAdjacentHTML('beforeend', taskHtml);
    }
</script>
@endsection
