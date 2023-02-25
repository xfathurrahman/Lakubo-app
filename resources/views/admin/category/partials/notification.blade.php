<div id="session-error-notification-content" class="toastify-content hidden flex">
    <i class="text-primary" data-lucide="x-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium">Kategori Gagal Disimpan.</div>
        <div class="text-slate-500 mt-1">{{ Session::get('error') }}.</div>
    </div>
</div>

<div id="success-notification-content" class="toastify-content hidden flex"> <i class="text-success" data-lucide="check-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium">Kategori Disimpan!</div>
        <div class="text-slate-500 mt-1">{{ Session::get('success') }}.</div>
    </div>
</div>

<div id="error-notification-content" class="toastify-content hidden flex">
    <i class="text-primary" data-lucide="x-circle"></i>
    <div class="ml-4 mr-4">
        <div class="font-medium">Data Tidak Valid.</div>
        <div class="text-slate-500 mt-1">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

@section('script')
    <script>
        $(document).ready(function() {
            @if(Session::has('error'))
            Toastify({
                node: $("#session-error-notification-content").clone().removeClass("hidden")[0],
                duration: -1,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
            @php
                Session::forget('error');
            @endphp
            @endif

            @if(Session::has('success'))
            Toastify({
                node: $("#success-notification-content").clone().removeClass("hidden")[0],
                duration: -1,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
            @php
                Session::forget('success');
            @endphp
            @endif

            @if($errors->any())
            Toastify({
                node: $("#error-notification-content").clone().removeClass("hidden")[0],
                duration: -1,
                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
            }).showToast();
            @endif
        });
    </script>
@endsection
