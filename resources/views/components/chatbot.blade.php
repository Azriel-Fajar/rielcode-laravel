{{-- Chatbot widget - injected once in base layout, just before </body> --}}
@push('scripts')
    @vite(['resources/js/chatbot.js'])
@endpush
