<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $category->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-8">
                <aside class="w-full md:w-1/4">
                    <product-filters
                        :categories="{{ json_encode($categories) }}"
                        action-url="{{ route('category.show', $category->id) }}"
                        category-id="{{ $category->id }}"
                        min-price="{{ request('min_price') }}"
                        max-price="{{ request('max_price') }}">
                    </product-filters>
                </aside>

                <section class="w-full md:w-3/4">
                    <product-list :products="{{ json_encode(\App\Http\Resources\ProductResource::collection($products->items())) }}"></product-list>

                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-app-layout>
