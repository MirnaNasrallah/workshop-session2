<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('schools') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                    <div class="container">
                        <table class="table table-striped">
                            <tbody>
                                <thead>
                                    <tr>
                                        <th>School name</th>
                                        <th>School location</th>
                                        <th>School Minimum Score</th>
                                        <th>Student Count</th>
                                        <th>Available slots</th>

                                    </tr>
                                </thead>

                                    <tr>
                                        <td>{{ $school->name }}</td>
                                        <td>{{ $school->location }}</td>
                                        <td>{{ $school->minimum_score }}</td>
                                        <td>{{ $school->student_count }}</td>
                                        <td>{{ $school->available_slots }}</td>

                                    </tr>


                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
