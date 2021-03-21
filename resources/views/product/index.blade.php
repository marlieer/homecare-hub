<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Browse Our Products') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="row">
                @foreach($products as $product)
                    <div class="col-md col-sm-12 d-flex align-items-stretch mb-3 ">
                        <div class="card shadow " style="width: 20rem;">
                            <img class="card-img-top" src="{{ '/storage/images/'.$product->image }}"
                                 alt="{{ $product->name }}">
                            <div class="card-body">
                                <h4 class="card-title">{{ $product->name }}</h4>
                                <p id="available-{{ $product->id }}"
                                   class="card-subtitle {{ $product->status == 'available' ? 'green-text' : 'red-text' }}">
                                    {{ $product->status }} {{ $product->status == 'available' ? ' - ' . $product->quantity . ' left' : ''}}
                                </p>
                                <p class="card-text">{{ $product->description }}</p>

                                @if($product->status == 'available')
                                    <input
                                        id="quantity-{{$product->id}}"
                                        type="number"
                                        class="d-inline w-25 form-control"
                                        value="1"
                                        min="0"
                                        max="{{ $product->quantity }}"/>
                                    <button class="btn btn-info"
                                            type="button" id="add-to-cart">Buy Now
                                    </button>
                                    <p class="hidden">{{ $product->id }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
