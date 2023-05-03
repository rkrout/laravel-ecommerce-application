@extends("admin.base")

@section("head")
<title>Products</title>
@endsection

@section("content")
<div class="card">
    <div class="card-header flex items-center justify-between">
        <span class="card-header-title">Products</span>
        <a href="/admin/products/create" class="btn btn-sm btn-primary">Add New</a>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <div class="table min-w-[1024px]">
                <table>
                    <thead>
                        <tr>
                            <th width="25%">Name</th>
                            <th width="15%">Price</th>
                            <th width="10%">Featured</th>
                            <th width="10%">Variations</th>
                            <th width="15%">Image</th>
                            <th width="15%">Last Updated</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($products) == 0)
                            <tr>
                                <td colspan="4" class="text-center">No Category Found</td>
                            </tr>
                        @endif

                        @foreach ($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>

                                <td>{{ $product->price ? "₹ {$product->price}" : "₹ {$product->min_price} - ₹ {$product->max_price}" }}</td>

                                <td>
                                    @if ($product->is_featured) 
                                        <i class="fa fa-check-circle text-green-600"></i> 
                                    @else 
                                        <i class="fa fa-times-circle text-red-600"></i> 
                                    @endif
                                </td>

                                <td>
                                    @if ($product->has_variations) 
                                        <i class="fa fa-check-circle text-green-600"></i> 
                                    @else 
                                        <i class="fa fa-times-circle text-red-600"></i> 
                                    @endif
                                </td>

                                <td>
                                    <img src="{{ explode("|", $product->images)[0] }}" class="w-20 h-20 object-cover rounded-md">
                                </td>

                                {{-- <td>{{ date("d-m-Y", strtotime($product->updated_at))}}</td> --}}
                            
                                <td>
                                    <div class="flex gap-1">
                                        <a href="/admin/products/{{ $product->id }}" class="btn btn-sm btn-warning">
                                            <i class="fa fa-edit"></i>
                                        </a>

                                        <form action="/admin/products/{{ $product->id }}" method="post">
                                            @csrf 
                                            @method("delete")

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection