@foreach($custWds as $custWd)
    <tr class="intro-x order-row" id="tr-content" data-transaction-id="{{ $custWd->id }}">
        <style>
            label:after {
                content: '\f103';
                font-family: "Font Awesome 5 Free", serif;
                font-weight: 900;
                color: rgb(96 165 250 / var(--tw-text-opacity));
                position: absolute;
                right: 1em;
            }

            input:checked + label:after {
                content: "\f102";
                font-family: "Font Awesome 5 Free", serif;
                font-weight: 900;
                color: rgb(96 165 250 / var(--tw-text-opacity));
                line-height: .8em;
                margin-top: 5px;
            }

            .accordion__content{
                max-height: 0;
                transition: all 0.4s cubic-bezier(0.865, 0.20 md:w-32, 0.095, 0.87);
            }
            input[name='panel']:checked ~ .accordion__content {
                /* Get this as close to what height you expect */
                max-height: 50em;
            }
            input[name='panel']:checked ~ label {
                background-color: transparent;
            }
        </style>
        <td class="w-5 mt-1 sm:mt-2"><a href="#" class="underline decoration-dotted">#{{ $custWd->id }}</a></td>
        <td class="w-full pl-4 pr-0 sm:px-4 mt-1">
            <div class="accordion flex flex-col items-center justify-center">
                <!--  Panel 1  -->
                <div class="w-full">
                    <input type="checkbox" name="panel" id="panel-{{ $custWd->id }}" class="hidden">
                    <label for="panel-{{ $custWd->id }}" class="relative flex justify-between items-center hover:cursor-pointer bg-gray-100 p-1 rounded">
                        <span class="font-medium text-sm sm:text-lg text-red-400"><i class="fa-solid fa-user mr-3"></i>{{ $custWd->user->name }}</span>
                        <span class="mr-10 text-blue-400">Detail</span>
                    </label>
                    <div class="accordion__content overflow-hidden">
                        <div class="bg-gray-100 p-2 mt-2 rounded text-xxs sm:text-sm w-full">
                            <div class="flex items-center mb-0 sm:mb-2">
                                <span class="w-20 sm:w-32 font-medium"><i class="fa-solid fa-rupiah-sign text-gray-500 ml-0.5 mr-1.5"></i>Jumlah</span>
                                <span>: </span> <p class="whitespace-nowrap text-primary ml-0.5">@currency($custWd->amount)</p>
                            </div>
                            <div class="flex items-center mb-0 sm:mb-2">
                                <span class="w-20 sm:w-32 font-medium"><i class="fa-regular fa-credit-card text-gray-500 mr-2"></i>No. Rek</span>
                                <span>: {{ $custWd->bank_account_number }}</span>
                            </div>
                            <div class="flex items-center mb-0 sm:mb-2">
                                <span class="w-20 sm:w-32 font-medium"><i class="fa-solid fa-signature text-gray-500 mr-2"></i>Atas Nama</span>
                                <span>: {{ $custWd->bank_account_name }}</span>
                            </div>
                            <div class="flex items-center mb-0">
                                <span class="w-20 sm:w-32 font-medium"><i class="fa-solid fa-building-columns text-gray-500 mr-2"></i>Nama Bank</span>
                                <span>: {{ $custWd->bank_name }}</span>
                            </div>
                            <div class="flex items-center mb-0 sm:hidden">
                                <span class="w-20 sm:w-32 font-medium"><i class="fa-regular fa-clock text-gray-500 mr-2"></i>Waktu</span>
                                <span>: {{ \Carbon\Carbon::parse($custWd->created_at)->format('H.i | d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center sm:hidden">
                                <select id="changeStatus" class="rounded-lg py-0 text-xxs sm:text-sm w-full">
                                    <option value="" disabled {{ $custWd->status === 'processing' ? 'selected' : '' }}>Tertunda</option>
                                    <option value="approved" {{ $custWd->status === 'approved' ? 'selected' : '' }}>Setujui</option>
                                    <option value="rejected" {{ $custWd->status === 'rejected' ? 'selected' : '' }}>Tolak</option>
                                </select>
                            </div>
                            @isset($custWd->note)
                            <div class="flex items-center mt-2">
                                <span class="w-20 sm:w-32 font-medium"><i class="fa-regular fa-note-sticky mr-2"></i>Alasan Penolakan</span>
                                <span>: {{ $custWd->note }}</span>
                            </div>
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </td>
        <td class="w-40 mt-1 sm:mt-2 hidden">
            <p class="text-right">
                {{ \Carbon\Carbon::parse($custWd->created_at)->format('H.i d/m/Y') }}
            </p>
        </td>
        <td class="text-center w-40 mt-1.5 hidden sm:block">
            <div class="status">
                @if ($custWd->status === 'processing')
                    <div class="text-center">
                        <select id="changeStatus" class="rounded-lg py-1" data-transaction-id="{{ $custWd->id }}">
                            <option value="" disabled {{ $custWd->status === 'processing' ? 'selected' : '' }}>Tertunda</option>
                            <option value="approved" {{ $custWd->status === 'approved' ? 'selected' : '' }}>Setujui</option>
                            <option value="rejected" {{ $custWd->status === 'rejected' ? 'selected' : '' }}>Tolak</option>
                        </select>
                    </div>
                @elseif ($custWd->status === 'approved')
                    <p class="text-green-500">Disetujui</p>
                @elseif ($custWd->status === 'rejected')
                    <p class="text-red-500">Ditolak</p>
                @endif
            </div>
        </td>
    </tr>
@endforeach
