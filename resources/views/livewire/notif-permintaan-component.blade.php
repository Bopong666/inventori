<li class="nav-item">
    <a class="nav-link fs-5 ps-4" href="{{ route('permintaan') }}"> Permintaan

        @if ($cek)
        <span class="position-absolute ms-1 top-2 translate-middle p-2 bg-danger border border-light rounded-circle">
            <span class="visually-hidden">New alerts</span>
        </span>
        @endif
    </a>
</li>