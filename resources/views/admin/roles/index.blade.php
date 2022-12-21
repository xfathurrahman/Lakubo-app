<x-app-layout>

    <div class="flex justify-end p-2 my-12">
        <a href="{{ route('admin.roles.create') }}" class="px-4 py-2 bg-green-700 hover:bg-green-400 text-gray-50 rounded-md">Tambah Peran</a>
    </div>

    <div class="overflow-x-auto relative shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="py-3 px-6">
                        ID
                    </th>
                    <th scope="col" class="py-3 px-6">
                        Nama Peran
                    </th>
                    <th scope="col" class="py-3 px-6">
                        <div class="flex justify-end mr-12">
                            <div class="flex space-x-2">
                                Aksi
                            </div>
                        </div>
                    </th>
                </tr>
                </thead>
                <tbody>
                @foreach ($roles as $role)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="p-4 w-4">
                            <div class="flex items-center">
                                #{{$role->id}}
                            </div>
                        </td>
                        <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $role->name }}
                        </th>
                        <td>
                            <div class="flex justify-end mr-4">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.roles.edit', $role->id) }}" class="px-4 py-2 bg-blue-500 hover:bg-blue-700 text-white rounded-md">Edit</a>
                                    <form class="px-4 py-2 bg-red-500 hover:bg-red-700 text-white rounded-md" method="POST" action="{{ route('admin.roles.destroy', $role->id) }}" onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

</x-app-layout>
