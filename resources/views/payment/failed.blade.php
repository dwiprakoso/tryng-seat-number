<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Gagal</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex items-center justify-center">
        <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full text-center">
            <div class="mb-4">
                <svg class="mx-auto h-16 w-16 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z">
                    </path>
                </svg>
            </div>

            <h1 class="text-2xl font-bold text-gray-900 mb-4">Pembayaran Gagal</h1>

            <p class="text-gray-600 mb-6">
                {{ $message ?? 'Pembayaran gagal atau dibatalkan. Silakan coba lagi.' }}
            </p>

            @if (isset($external_id))
                <p class="text-sm text-gray-500 mb-4">
                    ID Transaksi: {{ $external_id }}
                </p>
            @endif

            <div class="space-y-3">
                <a href="{{ url('/') }}"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded inline-block">
                    Coba Lagi
                </a>
                <a href="{{ url('/') }}"
                    class="w-full bg-gray-300 hover:bg-gray-400 text-gray-700 font-bold py-2 px-4 rounded inline-block">
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</body>

</html>
