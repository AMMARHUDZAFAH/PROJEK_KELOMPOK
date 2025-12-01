@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">📋 Checkout</h2>

    <div class="row">
        <!-- Checkout Form -->
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('checkout.process') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <h5>📍 Alamat Pengiriman</h5>
                            <div class="mb-3">
                                <label class="form-label"><strong>Nama Lengkap</strong></label>
                                <input type="text" class="form-control" value="{{ $user->name }}" readonly>
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Nomor Telepon</strong></label>
                                <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $user->phone) }}" required placeholder="08xxxxxxxxx">
                                @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label"><strong>Alamat Lengkap</strong></label>
                                <textarea name="address" class="form-control @error('address') is-invalid @enderror" 
                                          rows="3" required placeholder="Jalan, nomor, RT/RW, kelurahan, kecamatan, kota, provinsi, kode pos">{{ old('address', $user->address) }}</textarea>
                                @error('address') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="mb-4">
                            <h5>💳 Metode Pembayaran</h5>
                            <div class="alert alert-info">
                                <strong>Transfer Bank</strong> - Silakan transfer ke rekening kami setelah membuat pesanan
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Lanjutkan ke Pembayaran</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card sticky-top" style="top:20px">
                <div class="card-body">
                    <h5 class="card-title mb-3">📦 Ringkasan Pesanan</h5>

                    <div class="mb-3" style="max-height:300px;overflow-y:auto">
                        @foreach($items as $item)
                        <div class="d-flex justify-content-between mb-2 pb-2 border-bottom">
                            <div>
                                <p class="mb-0 small"><strong>{{ $item->product->name }}</strong></p>
                                <small class="text-muted">x{{ $item->quantity }}</small>
                            </div>
                            <span>Rp {{ number_format($item->product->price * $item->quantity, 0) }}</span>
                        </div>
                        @endforeach
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span>Rp {{ number_format($total, 0) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Pengiriman:</span>
                        <span class="text-success">Gratis</span>
                    </div>
                    <div class="d-flex justify-content-between fs-5 mb-3">
                        <strong>Total:</strong>
                        <strong class="text-primary">Rp {{ number_format($total, 0) }}</strong>
                    </div>

                    <small class="text-muted">✓ Pengiriman gratis ke seluruh Indonesia<br>✓ Garansi uang kembali 100%</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
