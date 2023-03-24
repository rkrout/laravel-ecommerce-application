@extends('admin.base')

@section('content')
<div class="container my-4 px-3">
    <div class="row g-3">
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Sliders
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_sliders }}</h1>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Categories
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_categories }}</h1>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Products
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_products }}</h1>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Orders
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_orders }}</h1>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.orders.index') }}" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Placed Orders
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_placed_orders }}</h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Accepted Orders
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_accepted_orders }}</h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Rejected Orders
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_rejected_orders }}</h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Shipped Orders
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_shipped_orders }}</h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Delivered Orders
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_delivered_orders }}</h1>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Customers
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_users }}</h1>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Total Pending Reviews
                </div>
                <div class="card-body text-center">
                    <h1>{{ $total_pending_reviews }}</h1>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('admin.reviews.index') }}" class="btn btn-primary btn-sm">View</a>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4 col-lg-3">
            <div class="card">
                <div class="card-header text-center fw-bold text-primary">
                    Others
                </div>
                <div class="card-body d-flex flex-column gap-2 justify-content-center align-items-center">
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-sm btn-primary">Settings</a>
                    <a href="{{ route('index') }}" class="btn btn-sm btn-primary">View Site</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection