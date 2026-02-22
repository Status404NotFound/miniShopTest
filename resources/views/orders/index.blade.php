<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Мои заказы
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded mb-6 font-bold shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($orders->isEmpty())
                    <p class="text-gray-500 text-center py-8">У вас пока нет заказов.</p>
                @else
                    <div class="space-y-6">
                        @foreach($orders as $order)
                            <div class="border rounded-lg p-6 flex flex-col md:flex-row justify-between items-start md:items-center">
                                <div>
                                    <h3 class="font-bold text-lg mb-1">Заказ #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-500 mb-1">Дата: {{ $order->created_at->format('d.m.Y H:i') }}</p>
                                    <p class="text-sm text-gray-600">Адрес: {{ $order->address }}</p>
                                </div>
                                <div class="mt-4 md:mt-0 text-right">
                                    <span class="block text-sm text-gray-500 mb-1">Итоговая сумма</span>
                                    <span class="text-2xl font-bold text-gray-900">{{ $order->getPriceString() }}$</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
