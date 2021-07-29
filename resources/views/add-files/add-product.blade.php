@extends('layouts.layout')
@section('title')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Product</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Products</a></li>
                        <li class="breadcrumb-item active">Add Product</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-4">Add New Product</h4>

                    <form class="form-horizontal" action="{{ route('product.store') }}" method="POST">
                        @if (Session::get('success'))
                            <div class="alert alert-success">
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if (Session::get('fail'))
                            <div class="alert alert-danger">
                                {{ Session::get('fail') }}
                            </div>
                        @endif

                        @csrf
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label for="name">Product Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name') }}" placeholder="Enter Account Group Name">
                                    <span class="text-danger">@error('name'){{ $message }}@enderror</span>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="code">Product Code</label>
                                        <input type="text" class="form-control" id="code" name="code"
                                            placeholder="Enter Product code">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group">
                                        <label for="categories">Product Category</label>
                                        <select id="categories" name="categories" class="form-control">
                                            <option value='{{ old('categories') }}' hidden>Product Category </option>
                                            @foreach ($Categories as $Category)
                                                <option value='{{ $Category->id }}'>{{ $Category->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger">@error('categories'){{ $message }}@enderror</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <div class="input-group mb-2 mr-sm-3">
                                                <div class="input-group-prepend">
                                                    <div class="input-group-text">$</div>
                                                </div>
                                                <input type="text" class="form-control" id="price" name="price" value="0"
                                                    placeholder="Enter Price">
                                            </div>
                                            <span class="text-danger">@error('price'){{ $message }}@enderror</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea id="description" name="description" class="form-control" rows="2"
                                            placeholder="Description"></textarea>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="tax">TAX Rate</label>
                                                <div class="input-group mb-2 mr-sm-3">
                                                    <input type="text" class="form-control" id="tax" name="tax"
                                                        placeholder="Enter TAX Rate">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">$</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="discount">Discount Rate</label>
                                                <div class="input-group mb-2 mr-sm-3">
                                                    <input type="text" class="form-control" id="discount" name="discount"
                                                        placeholder="Enter Discount Rate">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">$</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="quantity">Product Quantity</label>
                                                <input type="text" class="form-control" id="quantity" name="quantity"
                                                    placeholder="Enter Product Quantity">
                                            </div>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-primary w-md">Submit</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
