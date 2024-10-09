<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    @include('sweetalert::alert')
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
                                        <th>student name</th>
                                        <th>birthdate</th>
                                        <th>gender</th>
                                        <th>last year score</th>
                                        <th>location</th>
                                        <th>school id</th>
                                    </tr>
                                </thead>
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->name }}</td>
                                        <td>{{ $student->birthdate }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>{{ $student->last_year_score }}</td>
                                        <td>{{ $student->location }}</td>
                                        <td>
                                            @if ($student->school_id)

                                            <a href="{{ route('show.school',['id' =>$student->school_id] )  }}">
                                                {{ $student->school_id }} </a>

                                            @else
                                              Not assigned
                                            @endif

                                        </td>
                                    </tr>
                                @endforeach
                                <form action="{{ route('assignStudents') }}">
                                    <button type="submit" class="btn-success">Assign Students</button>
                                </form>
                                <form action="{{ route('reset') }}">
                                    <button type="submit" class="btn-danger">reset </button>
                                </form>
                            </tbody>

                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
