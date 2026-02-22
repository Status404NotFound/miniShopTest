<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Каталог / {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 flex flex-col md:flex-row gap-8">

                <div class="w-full md:w-1/2 bg-gray-200 h-96 rounded-lg flex items-center justify-center">
                    <span class="text-gray-400">Фото товара</span>
                </div>

                <div class="w-full md:w-1/2 flex flex-col">
                    <h1 class="text-4xl font-extrabold mb-4">{{ $product->name }}</h1>
                    <p class="text-blue-600 font-medium mb-4">Категория: <a href="{{ route('category.show', $product->category_id) }}" class="hover:underline">{{ $product->category->name }}</a></p>
                    <p class="text-gray-600 mb-6 flex-grow">{{ $product->description }}</p>

                    <div class="border-t pt-4 mt-auto">
                        <div class="flex justify-between items-center mb-6">
                            <span class="text-3xl font-bold text-gray-900">{{ $product->getPriceString() }}$</span>
                            <span class="text-sm text-gray-500">В наличии: {{ $product->stock }} шт.</span>
                        </div>

                        <add-to-cart-button
                            :product-id="{{ $product->id }}"
                            :stock="{{ $product->stock }}">
                        </add-to-cart-button>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
