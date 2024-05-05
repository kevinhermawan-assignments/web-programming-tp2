<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>{{ $project->name }} - PROJECTKAN</title>
</head>

<body class="bg-gray-100 " x-data="{ newTaskModal: false, confirmDeleteModal: false, changeStatusModal: false, deleteUrl: '', changeStatusUrl: '', currentStatus: '' }">
    <div class="bg-white border-b border-gray-200 px-4 py-2">
        <div class="container mx-auto">
            <a href="{{ route('projects.index') }}">
                <h1 class="text-xl font-bold flex items-center tracking-widest">PROJECTKAN</h1>
            </a>
            <span class="text-gray-600 text-sm">By Kevin Hermawan</span>
        </div>
    </div>

    <div class="px-4 py-8">
        <div class="container mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-2xl font-semibold flex items-center">
                    {{ $project->name }} / Tasks
                </h1>
                <button @click="newTaskModal = true" class="rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white border hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600">Add New Task</button>
            </div>

            <div class="mt-4 grid md:grid-cols-3 gap-0 sm:gap-4 sm:grid-cols-1">
                <div class="bg-white rounded-lg px-6 py-4 mb-4 flex justify-between items-center border border-gray-200">
                    <h1 class="text-xl font-semibold">📝️ Backlog</h1>
                    <span class="text-gray-600">{{ count($backlogTasks) }}</span>
                </div>

                <div class="bg-white rounded-lg px-6 py-4 mb-4 flex justify-between items-center border border-gray-200">
                    <h1 class="text-xl font-semibold space-x-2">💪️ Ongoing</h1>
                    <span class="text-gray-600">{{ count($ongoingTasks) }}</span>
                </div>

                <div class="bg-white rounded-lg px-6 py-4 mb-4 flex justify-between items-center border border-gray-200">
                    <h1 class="text-xl font-semibold">✅️ Completed</h1>
                    <span class="text-gray-600">{{ count($completedTasks) }}</span>
                </div>
            </div>

            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-gray-100 px-2 text-sm text-gray-500">Tasks</span>
                </div>
            </div>

            <div class="mt-4">
                @if (count($availableTasks) > 0)
                @foreach ($availableTasks as $task)
                <div class="bg-white rounded-lg px-6 py-4 mb-4 flex justify-between items-center border border-gray-200">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $task->name }}</h2>
                        <div class="text-sm text-gray-600 mt-1 uppercase">{{ $task->status }}</div>
                    </div>
                    <div class="flex space-x-2">
                        <button @click="changeStatusModal = true; currentStatus = '{{ $task->status }}'; changeStatusUrl = '{{ route('tasks.update', ['project' => $project->id, 'task' => $task->id]) }}';" class="rounded-md bg-yellow-50 px-3 py-2 text-sm font-semibold text-yellow-600 border hover:bg-yellow-100">
                            Change Status
                        </button>
                        <button @click="confirmDeleteModal = true; deleteUrl = '{{ route('tasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}';" class="rounded-md bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 border hover:bg-red-100">
                            Delete
                        </button>
                    </div>
                </div>
                @endforeach
                @else
                <div class="bg-white rounded-lg px-6 py-4 mb-4 flex justify-center items-center border border-gray-200">
                    <p class="text-gray-600">There are no tasks available! 🎉</p>
                </div>
                @endif
            </div>



            <div class="relative">
                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center">
                    <span class="bg-gray-100 px-2 text-sm text-gray-500">Completed Tasks</span>
                </div>
            </div>

            <div class="mt-4">
                @if (count($completedTasks) > 0)
                @foreach ($completedTasks as $task)
                <div class="bg-white rounded-lg px-6 py-4 mb-4 flex justify-between items-center border border-gray-200">
                    <div>
                        <h2 class="text-xl font-semibold">{{ $task->name }}</h2>
                        <div class="text-sm text-gray-600 mt-1 uppercase">{{ $task->status }}</div>
                    </div>
                    <div class="flex space-x-2">
                        <button @click="changeStatusModal = true; currentStatus = '{{ $task->status }}'; changeStatusUrl = '{{ route('tasks.update', ['project' => $project->id, 'task' => $task->id]) }}';" class="rounded-md bg-yellow-50 px-3 py-2 text-sm font-semibold text-yellow-600 border hover:bg-yellow-100">
                            Change Status
                        </button>
                        <button @click="confirmDeleteModal = true; deleteUrl = '{{ route('tasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}';" class="rounded-md bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 border hover:bg-red-100">
                            Delete
                        </button>
                    </div>
                </div>
                @endforeach
                @else
                <div class="bg-white rounded-lg px-6 py-4 mb-4 flex justify-center items-center border border-gray-200">
                    <p class="text-gray-600">Completed tasks will be displayed here.</p>
                </div>
                @endif
            </div>

            <!-- Modal for adding new task -->
            <div x-show="newTaskModal" style="background-color: rgba(0,0,0,0.5);" class="fixed inset-0 flex items-center justify-center">
                <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-md mx-4" @click.away="newTaskModal = false">
                    <h3 class="text-lg font-bold mb-4">New Task</h3>
                    <form action="{{ route('tasks.store', $project) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                            <div class="mt-2">
                                <input name="name" type="text" required class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                            </div>
                        </div>
                        <div>
                            <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                            <div class="mt-2">
                                <textarea name="description" type="text" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                            </div>
                        </div>
                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="newTaskModal = false" class="inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto">Cancel</button>
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-500 sm:w-auto">Save Task</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Change status modal -->
            <div x-show="changeStatusModal" style="background-color: rgba(0,0,0,0.5);" class="fixed inset-0 flex items-center justify-center">
                <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-md mx-4" @click.away="changeStatusModal = false">
                    <h3 class="text-lg font-bold mb-4">Change Task Status</h3>
                    <form :action="changeStatusUrl" method="POST">
                        @csrf
                        @method('PATCH')
                        <select name="status" class="border-gray-300 border rounded p-2 w-full mb-4">
                            <option value="backlog" :selected="currentStatus == 'backlog'">BACKLOG</option>
                            <option value="ongoing" :selected="currentStatus == 'ongoing'">ONGOING</option>
                            <option value="completed" :selected="currentStatus == 'completed'">COMPLETED</option>
                        </select>
                        <div class="flex justify-end space-x-4">
                            <button type="button" @click="changeStatusModal = false" class="inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto">Cancel</button>
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-yellow-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-yellow-500 sm:w-auto">Save</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete confirmation modal -->
            <div x-show="confirmDeleteModal" style="background-color: rgba(0,0,0,0.5);" class="fixed inset-0 flex items-center justify-center">
                <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-md mx-4" @click.away="confirmDeleteModal = false">
                    <h3 class="text-lg font-bold mb-4">Confirm Deletion</h3>
                    <p class="text-gray-600 text-sm">Are you sure you want to delete this task?</p>
                    <div class="flex justify-end space-x-4 mt-4">
                        <button type="button" @click="confirmDeleteModal = false" class="inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto">Cancel</button>
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">Delete</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>