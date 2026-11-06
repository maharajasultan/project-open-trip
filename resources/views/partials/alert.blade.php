{{-- Dipakai di dalam layout: @include('partials.alert') --}}
@if (session('success') || session('error') || session('warning') || session('info'))
<div class="position-fixed top-0 end-0 p-3" style="z-index: 9999; margin-top: 72px; min-width:300px;">
    @foreach(['success','error','warning','info'] as $type)
        @if(session($type))
        @php
            $icons = ['success'=>'check-circle-fill','error'=>'x-circle-fill',
                      'warning'=>'exclamation-triangle-fill','info'=>'info-circle-fill'];
            $bgMap = ['success'=>'success','error'=>'danger','warning'=>'warning','info'=>'info'];
        @endphp
        <div class="toast show align-items-center text-white border-0 rounded-4 shadow-lg mb-2
                    bg-{{ $bgMap[$type] }}" role="alert" aria-live="assertive">
            <div class="d-flex">
                <div class="toast-body fw-semibold d-flex align-items-center gap-2">
                    <i class="bi bi-{{ $icons[$type] }}"></i>
                    {{ session($type) }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                        data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        @endif
    @endforeach
</div>
@endif