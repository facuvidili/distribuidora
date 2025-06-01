<button {{ $attributes->merge(['class' => 'px-4 py-2 bg-blue-600 text-white font-semibold rounded-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-400']) }}>
    {{ $slot }}
</button>
