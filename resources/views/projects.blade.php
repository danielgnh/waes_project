<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage projects that you have & add new') }}
        </h2>
    </x-slot>

    @php
    $user = auth()->user();
    @endphp

    @if($user->hasProjects() )
        <!-- Card Blog -->
        <div class="max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Grid -->

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($user->projects()->get() as $project)
                    <!-- Card -->
                    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="h-52 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl">
                            <img src="{{$project->getFirstMedia('logotype')?->getUrl()}}" class="max-h-[200px]" alt="">
                        </div>
                        <div class="p-4 md:p-6">
                        <span class="block mb-1 text-xs font-semibold uppercase text-blue-600">
                          {{$project->status}}
                        </span>
                            <h3 class="text-xl font-semibold text-gray-800">
                                {{$project->name}}
                            </h3>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500">
                                {{$project->description}}
                            </p>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500">
                                From {{$project->start_date->format('m.j.Y')}} to {{$project->end_date->format('m.j.Y')}}
                            </p>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500">
                                Created {{$project->created_at->diffForHumans()}}
                            </p>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500">
                                Project manager <span class="font-semibold">{{ \App\Models\User::find($project->project_manager)->email }}</span>
                            </p>
                        </div>
                        <div class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200">
                            @if($user->id == $project->project_manager)
                                <a href="/panel/projects/{{$project->id}}/edit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-b-xl bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none">
                                    Control Panel
                                </a>
                            @endif
                        </div>
                    </div>
                    <!-- End Card -->
                @endforeach
                <a href="/panel/projects" type="button" class=" flex justify-center flex-col items-center w-full rounded-lg border-2 border-dashed border-gray-300 p-12 text-center hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition duration-150 ease-in-out">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 14.15v4.25c0 1.094-.787 2.036-1.872 2.18-2.087.277-4.216.42-6.378.42s-4.291-.143-6.378-.42c-1.085-.144-1.872-1.086-1.872-2.18v-4.25m16.5 0a2.18 2.18 0 0 0 .75-1.661V8.706c0-1.081-.768-2.015-1.837-2.175a48.114 48.114 0 0 0-3.413-.387m4.5 8.006c-.194.165-.42.295-.673.38A23.978 23.978 0 0 1 12 15.75c-2.648 0-5.195-.429-7.577-1.22a2.016 2.016 0 0 1-.673-.38m0 0A2.18 2.18 0 0 1 3 12.489V8.706c0-1.081.768-2.015 1.837-2.175a48.111 48.111 0 0 1 3.413-.387m7.5 0V5.25A2.25 2.25 0 0 0 13.5 3h-3a2.25 2.25 0 0 0-2.25 2.25v.894m7.5 0a48.667 48.667 0 0 0-7.5 0M12 12.75h.008v.008H12v-.008Z" />
                    </svg>
                    <span class="mt-2 block text-sm font-semibold text-gray-900">Create one more project</span>
                </a>
            </div>
            <!-- End Grid -->
        </div>
    @else
        @if($user->hasRole('project_admin'))
            <div class="text-center mt-6">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No projects</h3>
                <p class="mt-1 text-sm text-gray-500">Tey creating a new one!</p>
                <div class="mt-6">
                    <button type="button" class="inline-flex items-center rounded-md bg-blue-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10.75 4.75a.75.75 0 00-1.5 0v4.5h-4.5a.75.75 0 000 1.5h4.5v4.5a.75.75 0 001.5 0v-4.5h4.5a.75.75 0 000-1.5h-4.5v-4.5z" />
                        </svg>
                        New Project
                    </button>
                </div>
            </div>
        @else
            <div class="text-center mt-6">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path vector-effect="non-scaling-stroke" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                </svg>
                <h3 class="mt-2 text-sm font-semibold text-gray-900">No projects</h3>
                <p class="mt-1 text-sm text-gray-500">Wait for an invitation or contact your manager</p>
            </div>
        @endif

    @endif
</x-app-layout>
