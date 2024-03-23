@extends('layouts.app')

@inject('idEncoder', 'App\Services\IdEncodeDecodeService')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 my-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="mt-4 mb-3">Products</h1>
                    <a href="{{ route('product.create') }}" class="btn btn-primary">Add Product</a>
                </div>
                @if (session('success'))
                    <div class="alert alert-success" role="alert">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Sr. No.</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Image</th>
                                <th>Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $product)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $product->category->name }}</td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->description }}</td>
                                    <td>${{ $product->price }}</td>
                                    <td>
                                        @if(isset($product) && $product->image)
                                            <a href="{{ asset('storage/product_images/' . $product->image) }}" target="_blank">View Image</a>
                                            @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>{{ $product->is_active == 1 ? 'Yes' : 'No' }}</td>
                                    <td><a href="{{ route('product.edit', $idEncoder->encodeId($product->id)) }}">Edit</a></td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="text-center" colspan="8">No items found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
