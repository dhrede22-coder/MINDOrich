@extends('admin.layouts.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>
        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif

<div class="container-fluid">

    <div class="mb-4">
        <h1 class="h3 mb-1">Settings</h1>
        <p class="text-muted mb-0">
            Manage MINDOrich system settings.
        </p>
    </div>

    <div class="card border-0 shadow-sm">
    <div class="card-body">

        <h5 class="fw-semibold mb-1">
            GCash Payment
        </h5>

        <p class="text-muted mb-4">
            Upload the GCash QR Code that customers will use for online payments.
        </p>

        @if(!empty($settings['gcash_qr_code']))
    <div class="mb-4">
        <label class="form-label fw-semibold">
            Current GCash QR Code
        </label>

        <div>
            <img src="{{ asset('storage/' . $settings['gcash_qr_code']) }}"
                 alt="GCash QR Code"
                 class="img-fluid border rounded"
                 style="max-width: 250px;">
        </div>
    </div>
@endif

        <form action="{{ route('settings.gcash-qr.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            <div class="mb-3">
                <label for="gcash_qr_code" class="form-label fw-semibold">
                    GCash QR Code
                </label>

                <input type="file"
                       name="gcash_qr_code"
                       id="gcash_qr_code"
                       class="form-control"
                       accept="image/png,image/jpeg,image/webp"
                       required>

                <div class="form-text">
                    JPG, PNG, or WebP. Maximum file size: 2 MB.
                </div>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-upload me-2"></i>
                Upload QR Code
            </button>

        </form>

    </div>
</div>

</div>

@endsection