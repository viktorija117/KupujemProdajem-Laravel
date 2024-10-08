<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Čet za oglas: ') }} {{ $ad->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <!-- Prikaz sa kim se dopisujemo -->
                <div class="mb-6 p-4 bg-gray-100 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold">
                        Dopisujete se sa:
                        @if($messages->first()->sender_id === auth()->id())
                            {{ $messages->first()->receiver->name }}
                        @else
                            {{ $messages->first()->sender->name }}
                        @endif
                    </h3>
                </div>

                <!-- Prikaz svih poruka -->
                <div class="space-y-4">
                    @foreach($messages as $message)
                        @if($message->sender_id === auth()->id())
                            <!-- Moja poruka -->
                            <div class="flex justify-end">
                                <div class="bg-gray-200 text-gray-900 rounded-lg p-4 max-w-md shadow-lg">
                                    <p>{{ $message->message }}</p>
                                    <span class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @else
                            <!-- Poruka sagovornika -->
                            <div class="flex justify-start">
                                <div class="bg-blue-200 text-gray-900 rounded-lg p-4 max-w-md shadow-lg">
                                    <p>{{ $message->message }}</p>
                                    <span class="text-xs text-gray-500">{{ $message->created_at->format('H:i') }}</span>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                <!-- Forma za slanje nove poruke -->
                <form action="{{ route('messages.store', $ad) }}" method="POST" class="mt-6">
                    @csrf
                    <textarea name="message" class="w-full border border-gray-300 rounded-lg p-2" rows="3" placeholder="Unesite poruku"></textarea>
                    <input type="hidden" name="receiver_id" value="{{ $messages->first()->receiver_id ?? $ad->user_id }}">
                    <button type="submit" class="mt-2 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        Pošalji
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
