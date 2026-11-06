{{-- Penggunaan: @include('partials.mountain-card', ['mountain' => $mountain, 'delay' => 0]) --}}
<div class="mountain-card h-100">
    <div class="img-wrapper position-relative">
        <img src="{{ $mountain->image_url }}"
             alt="{{ $mountain->name }}"
             class="card-img-top"
             loading="lazy">
        <div class="overlay"></div>

        @if($mountain->difficulty)
        <span class="badge badge-difficulty bg-{{ $mountain->difficulty_badge }}">
            {{ $mountain->difficulty }}
        </span>
        @endif

        @if($mountain->available_quota <= 5 && $mountain->available_quota > 0)
        <span class="badge bg-danger position-absolute bottom-0 start-0 m-2 rounded-pill">
            <i class="bi bi-fire me-1"></i>Hampir Penuh!
        </span>
        @elseif($mountain->available_quota <= 0)
        <span class="badge bg-dark position-absolute bottom-0 start-0 m-2 rounded-pill">
            <i class="bi bi-slash-circle me-1"></i>Penuh
        </span>
        @endif
    </div>

    <div class="card-body p-4 d-flex flex-column">
        <h5 class="card-title fw-bold mb-1" style="font-size:1rem; line-height:1.3;">
            {{ $mountain->name }}
        </h5>
        @if($mountain->location)
        <p class="text-muted small mb-2">
            <i class="bi bi-geo-alt me-1 text-success"></i>{{ $mountain->location }}
            @if($mountain->altitude)
             · {{ number_format($mountain->altitude) }} mdpl
            @endif
        </p>
        @endif

        <div class="d-flex flex-wrap gap-2 mb-3">
            <span class="badge bg-light text-dark rounded-pill px-3 py-2 border">
                <i class="bi bi-calendar3 me-1 text-success"></i>
                {{ $mountain->departure_date->format('d M Y') }}
            </span>
            <span class="badge bg-light text-dark rounded-pill px-3 py-2 border">
                <i class="bi bi-people me-1 text-success"></i>
                {{ $mountain->registered_count }}/{{ $mountain->quota }}
            </span>
        </div>

        {{-- Progress kuota --}}
        @php $pct = $mountain->quota > 0 ? ($mountain->registered_count / $mountain->quota) * 100 : 0; @endphp
        <div class="mb-3">
            <div class="d-flex justify-content-between small text-muted mb-1">
                <span>Kuota Tersisa</span>
                <span class="fw-semibold {{ $mountain->available_quota <= 5 ? 'text-danger' : 'text-success' }}">
                    {{ $mountain->available_quota }} slot
                </span>
            </div>
            <div class="progress" style="height:5px; border-radius:10px;">
                <div class="progress-bar bg-{{ $pct >= 80 ? 'danger' : ($pct >= 50 ? 'warning' : 'success') }}"style="width:{{ $pct }}%;"></div>
            </div>
        </div>

        <div class="mt-auto d-flex justify-content-between align-items-center">
            <div>
                <div class="text-muted" style="font-size:.72rem;">Mulai dari</div>
                <div class="fw-bold" style="color:var(--primary); font-size:1.05rem;">
                    {{ $mountain->formatted_price }}
                    <span class="text-muted small fw-normal">/orang</span>
                </div>
            </div>
            @if($mountain->available_quota > 0)
            <a href="{{ route('mountains.show', $mountain) }}"
               class="btn btn-primary-custom btn-sm">
                Detail <i class="bi bi-arrow-right ms-1"></i>
            </a>
            @else
            <span class="btn btn-secondary btn-sm disabled">Penuh</span>
            @endif
        </div>
    </div>
</div>