<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <index-expenses></index-expenses>
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4" style="height: 85vh;">
                <div
                    class="col-span-12 sm:col-span-4 rounded-lg p-4 items-center mt-10 shadow-xl overflow-clip bg-white">
                    <reciept-index>

                    </reciept-index>
                </div>
                <div class="col-span-12 sm:col-span-8 p-5 rounded-lg mt-10 shadow-xl overflow-clip bg-white">
                    <reciept-details></reciept-details>
                </div>
            </div>



        </div>
    </div>
</x-app-layout>
