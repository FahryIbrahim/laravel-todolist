<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="flex flex-col text-black bg-white dark:bg-gray-900 dark:text-white">
    <div id="pageContent" class="flex-1 transition-all">
        <header class="container mx-auto">
            <nav class="flex items-center justify-between px-10 py-4">
                <h1 class="text-2xl font-bold">To-Do List</h1>
                <button id="darkModeToggle"
                    class="px-4 py-2 text-black bg-gray-200 rounded-md dark:bg-gray-700 dark:text-white">
                    <i id="themeIcon" class="fa-solid fa-moon icon-fade"></i>
                </button>
            </nav>
        </header>

        <main class="container mx-auto">
            <div class="px-10 title">
                @session('success')
                <!-- Toast -->
                <div class="max-w-xs mb-3 text-sm text-white bg-gray-800 shadow-lg toast rounded-xl dark:bg-neutral-900" role="alert"
                    tabindex="-1" aria-labelledby="hs-toast-solid-color-dark-label">
                    <div id="hs-toast-solid-color-dark-label" class="flex p-4">
                            {{ session('success') }}
                            <div class="ms-auto">
                                <button type="button"
                                class="inline-flex items-center justify-center text-white rounded-lg opacity-50 shrink-0 size-5 hover:text-white hover:opacity-100 focus:outline-none focus:opacity-100"
                                aria-label="Close">
                                <span class="sr-only">Close</span>
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M18 6 6 18"></path>
                                    <path d="m6 6 12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- End Toast -->
                @endsession
                <h1 class="text-xl font-semibold">My Task</h1>
                <div class="container flex justify-between">
                    <p class="inline py-1 mt-2 mr-6 text-sm">You have 3 tasks left!</p>
                    <!-- Button to open the modal -->
                    <button data-modal-target="taskModal" data-modal-toggle="taskModal"
                        class="px-12 py-2 text-white bg-black rounded-md dark:bg-white dark:text-black">
                        Add Task
                    </button>
                </div>
            </div>
            <div class="container mx-auto card-list my-7">
                <!-- Task Cards -->
<!-- Existing Task Cards -->
@foreach ($todos as $todo)
<div class="px-5 py-3 mx-10 mb-4 border-2 border-black rounded-md dark:border-white">
    <input type="checkbox" name="todos[]" id="todo-{{ $todo->id }}" {{ $todo->completed ? 'checked' : '' }}>
    <h2 class="inline ml-2 font-medium {{ $todo->completed ? 'line-through' : '' }}">
        {{ $todo->title }}
    </h2>
    <form class="mx-4 float-end" action="{{route('todos.destroy', $todo)}}" method="post">
        @csrf
        @method('DELETE')
        <button type="submit">
            <i class="fa-solid fa-trash"></i>
        </button>
    </form>
    <p>{{ $todo->desc }}</p>
    <p class="text-red-500">Due {{ $todo->formatted_deadline }}</p>
</div>

@endforeach

            </div>

        </main>
    </div>

    <!-- Modal -->
    <div id="taskModal" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">
        <div class="relative w-full h-full max-w-md md:h-auto">
            <!-- Modal content -->
            <div class="bg-white rounded-lg shadow dark:bg-gray-800">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-700">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Add New Task
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-700 dark:hover:text-white"
                        data-modal-hide="taskModal">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 01-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 01-1.414 1.414L8.586 10 3.636 5.05a1 1 0 011.414-1.414L10 8.586z"
                                clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
                <!-- Modal body -->
                <form action="{{ route('todos.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="mb-4">
                        <label for="title"
                            class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Title</label>
                        <input type="text" name="title" id="title" required
                            class="w-full px-3 py-2 text-gray-900 bg-gray-200 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <div class="mb-4">
                        <label for="desc"
                            class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Description</label>
                        <textarea name="desc" id="desc" rows="4" required
                            class="w-full px-3 py-2 text-gray-900 bg-gray-200 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                    </div>
                    <div class="mb-4">
                        <label for="deadline"
                            class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Deadline</label>
                        <input type="date" name="deadline" id="deadline"
                            class="w-full px-3 py-2 text-gray-900 bg-gray-200 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white">
                    </div>
                    <!-- Ensure that when unchecked, 'completed' is set to false -->
                    <input type="hidden" name="completed" value="0">
                    <div class="mb-4">
                        <label for="completed" class="inline-flex items-center">
                            <!-- Add a hidden input to ensure 'completed' is always sent -->
                            <input type="hidden" name="completed" value="0">
                            <input type="checkbox" name="completed" value="1"
                                {{ old('completed') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm font-medium text-gray-700 dark:text-gray-300">Completed</span>
                        </label>
                    </div>
                    <div class="flex items-center justify-end">
                        <button type="submit"
                            class="px-4 py-2 font-semibold text-white bg-black rounded dark:bg-white dark:text-black hover:bg-green-600">
                            Save Task
                        </button>
                    </div>
                </form>


            </div>
        </div>
    </div>

    <footer class="container py-4 mx-auto text-center">
        <p>Developed by <a href="https://github.com/FahryIbrahim">Fahry Ibrahim</a></p>
    </footer>

    <script src="https://unpkg.com/preline/dist/preline.js"></script>
</body>

</html>
