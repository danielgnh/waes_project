<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Organisations, which you are assigned to') }}
        </h2>
    </x-slot>

    @php
        $user = auth()->user();
    @endphp

@if($user->hasOrganisations())
        <div class="max-w-7xl px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
            <!-- Grid -->
            <div class="grid grid-cols-1 gap-6">
                @foreach($user->organisations()->get() as $organisation)

                <!-- Card -->
                    <div class="group flex flex-col h-full bg-white border border-gray-200 shadow-sm rounded-xl">
                        <div class="h-52 flex flex-col justify-center items-center bg-blue-600 rounded-t-xl">

                            <img src="{{$organisation->getFirstMedia('logotype')?->getUrl()}}" class="max-h-[200px]" alt="">
                        </div>
                        <div class="p-4 md:p-6">
                        <span class="block mb-1 text-xs font-semibold uppercase text-blue-600">
                          {{$organisation->status}}
                        </span>
                            <div class="flex flex-row gap-2 items-center">
                                <h3 class="text-xl font-semibold text-gray-800">
                                    {{$organisation->name}}
                                </h3>
                                <p class="text-gray-500 dark:text-neutral-500">
                                    {{$organisation->address}}, {{$organisation->city}}, {{$organisation->country}}
                                </p>
                            </div>

                            <p class="mt-3 text-gray-800 dark:text-neutral-500">
                                {{$organisation->description}}
                            </p>
                            <p class="mt-3 text-gray-500 dark:text-neutral-500 text-sm">
                                By any questions, please contact <b>{{ \App\Models\User::find($organisation->manager_id)->email }}</b>
                            </p>
                        </div>
                        @if($user->id == $organisation->manager_id)
                            <div class="mt-auto flex border-t border-gray-200 divide-x divide-gray-200">
                                <a class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-b-xl bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none" href="panel/organisations/{{$organisation->id}}/edit">
                                    Control Panel
                                </a>
                            </div>
                        @endif
                    </div>
                    <!-- End Card -->
                @endforeach
            </div>
            <!-- End Grid -->
        </div>
        <!-- End Card Blog -->
    @else
        <div class="text-center mt-6">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-gray-400">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
            </svg>

            <h3 class="mt-2 text-sm font-semibold text-gray-900">You are not assigned to any organisation</h3>
            <p class="mt-1 text-sm text-gray-500">Contact you manager for getting an invitation</p>
        </div>
    @endif
</x-app-layout>
