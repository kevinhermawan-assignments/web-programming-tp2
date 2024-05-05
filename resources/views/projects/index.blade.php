<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <title>PROJECTKAN</title>
</head>

<body class="bg-gray-100" x-data="{ newProjectModal: false, confirmDeleteModal: false, deleteUrl: '' }">
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
                <h1 class="text-2xl font-bold">Projects</h1>
                <button @click="newProjectModal = true" class="rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white border hover:bg-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-purple-600">Add New Project</button>
            </div>

            <div class="mt-4">
                @if (count($projects) > 0)
                @foreach ($projects as $project)
                <div class="bg-white rounded-lg px-6 py-4 mb-4 flex justify-between items-center border border-gray-200">
                    <a class="cursor-pointer" href="{{ route('tasks.index', $project) }}">
                        <h2 class="text-xl font-semibold hover:text-blue-500">{{ $project->name }}</h2>
                        <div class="text-sm text-gray-600 mt-1">
                            <span>{{ $project->tasks()->where('status', 'backlog')->count() }} backlog, </span>
                            <span>{{ $project->tasks()->where('status', 'ongoing')->count() }} ongoing, </span>
                            <span>{{ $project->tasks()->where('status', 'completed')->count() }} completed</span>
                        </div>
                    </a>
                    <button @click="confirmDeleteModal = true; deleteUrl = '{{ route('projects.destroy', $project) }}';" class="rounded-md bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 border hover:bg-red-100">
                        Delete
                    </button>
                </div>
                @endforeach
                @else
                <div class="bg-white rounded-lg px-6 py-4 mb-4 flex justify-center items-center border border-gray-200">
                    <p class="text-gray-600">There are no tasks available! 🎉</p>
                </div>
                @endif
            </div>

            <!-- Modal for adding new project -->
            <div x-show="newProjectModal" style="background-color: rgba(0,0,0,0.5);" class="fixed inset-0 flex items-center justify-center">
                <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-lg mx-4" @click.away="newProjectModal = false">
                    <h3 class="text-lg font-bold mb-4">New Project</h3>
                    <form action="{{ route('projects.store') }}" method="POST" class="space-y-4">
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
                            <button type="button" @click="newProjectModal = false" class="inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto">Cancel</button>
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-purple-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-purple-500 sm:w-auto">Save Project</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Delete confirmation modal -->
            <div x-show="confirmDeleteModal" style="background-color: rgba(0,0,0,0.5);" class="fixed inset-0 flex items-center justify-center">
                <div class="bg-white p-4 rounded-lg shadow-lg w-full max-w-lg mx-4" @click.away="confirmDeleteModal = false">
                    <h3 class="text-lg font-bold mb-4">Confirm Deletion</h3>
                    <p class="text-gray-600 text-sm">Deleting this project will also remove all associated tasks. Are you sure you want to proceed?</p>
                    <div class="flex justify-end space-x-4 mt-4">
                        <button type="button" @click="confirmDeleteModal = false" class="inline-flex w-full justify-center rounded-md bg-white px-3 py-2 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto">Cancel</button>
                        <form :action="deleteUrl" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex w-full justify-center rounded-md bg-red-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-red-500 sm:w-auto">Delete Project</button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</body>

</html>