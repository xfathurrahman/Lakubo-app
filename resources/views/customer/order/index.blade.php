<x-app-layout>

    @section('breadcrumbs')
        {{ Breadcrumbs::render('my-order') }}
    @endsection

        @if(auth()->user()->orders)
            <div class="grid grid-cols-12 gap-6 mt-5">
                <!-- BEGIN: Data List -->
                <div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
                    <table class="table table-report -mt-2">
                        <thead>
                        @if ($orders->count())
                            <tr>
                                <th class="text-center">PESANAN</th>
                                <th class="text-center whitespace-nowrap">TOTAL TAGIHAN</th>
                                <th class="text-center whitespace-nowrap">STATUS</th>
                                <th class="text-center whitespace-nowrap">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($orders as $order)
                            <tr class="intro-x">
                                <td class="text-left px-0">
                                    <div class="my-2 inline-flex">
                                        <div class="text-lg text-red-400">{{ $order->orderItems->first()->products->stores->name }}</div>
                                        <a href="#" class="btn ml-2 h-6"><i class="fa-solid fa-store mr-2"></i>Kunjungi</a>
                                    </div>
                                    @foreach($order->orderItems as $item)
                                    <div class="block ml-3">
                                        <div class="inline-flex">
                                            <div class="w-10 h-10 image-fit zoom-in">
                                                <img data-action="zoom" alt="Product-img" class="tooltip rounded-full" src="{{ asset("storage/product-image")."/".$item-> products -> productImage -> image_path }}" title="Uploaded {{ Carbon\Carbon::parse($item -> products -> created_at)->diffForHumans() }}">
                                            </div>
                                            <div class="flex flex-col h-10 justify-center align-middle ml-5">
                                                {{ $item -> products -> name }} ({{ $item -> quantity }} Item)
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </td>
                                <td class="text-center">@currency($order-> shipping + $order-> total_price)</td>
                                <td class="w-40">
                                    <div class="flex items-center justify-center text-success"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> {{ $order-> status }} </div>
                                </td>
                                <td class="table-report__action w-56">
                                    <div class="flex justify-center items-center">
                                        <a class="flex items-center mr-3" href="{{ route('customer.order.show', $order->id) }}"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Detail </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        @else
                            <tr>
                                <td colspan="6">
                                    <img class="max-w-3xl max-h-52 mx-auto" src="{{ asset('assets/images/app/not-found-store.png') }}" alt="iklan kosong">
                                    <p class="text-center text-dark py-5">Pesanan anda masih kosong.</p>
                                </td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                <!-- END: Data List -->
                <!-- BEGIN: Pagination -->

                <!-- END: Pagination -->
            </div>
        @else
            <div class="intro-y col-span-11 alert alert-primary alert-dismissible show flex items-center mb-6" role="alert">
                <span><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="info" data-lucide="info" class="lucide lucide-info w-4 h-4 mr-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg></span>
                <span> Anda belum membuka lapak UMKM,
                    <a
                        data-tw-toggle="modal"
                        data-tw-target="#create-store-form"
                        href="#"
                        class="dropdown-item hover:bg-white/5 underline">klik disini
                    </a>
                </span>&nbsp;untuk mendaftar.
                <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg> </button>
            </div>
        @endif

    @section('script')
            {{--<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="config('midtrans.client_key')"></script>

            <script type="text/javascript">
                // For example trigger on button clicked, or any time you need
                var payButton = document.getElementById('pay-button');
                payButton.addEventListener('click', function () {
                    // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
                    window.snap.pay('<?=$snapToken?>');
                    // customer will be redirected after completing payment pop-up
                });
            </script>--}}

            {{--<script>
                document.getElementById('pay-button').onclick = function (){

                    var resultType = document.getElementById('result-type');
                    var resultType = document.getElementById('result-data');

                    function changeResult(type,data) {
                        $("#result-type").val(type);
                        $("#result-data").val(JSON.stringify(data));
                    }

                    snap.pay('<?=$snapToken?>', {
                        onSuccess: function (result) {
                            changeResult('success', result);
                            console.log(result.status_message);
                            console.log(result);
                            $("#payment-form".submit());
                        },
                        onPending: function (result) {
                            changeResult('pending', result);
                            console.log(result.status_message);
                            console.log(result);
                            $("#payment-form".submit());
                        },
                        onError: function (result) {
                            changeResult('error', result);
                            console.log(result.status_message);
                            console.log(result);
                            $("#payment-form".submit());
                        },
                    })

                }
            </script>--}}
    @endsection

</x-app-layout>
