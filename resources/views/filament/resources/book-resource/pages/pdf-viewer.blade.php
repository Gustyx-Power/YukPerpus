@php
    $pdfUrl = $getRecord()->pdf_file ? Storage::url($getRecord()->pdf_file) : null;
@endphp

@if($pdfUrl)
    <div class="w-full h-[600px]">
        <iframe
            src="{{ $pdfUrl }}"
            class="w-full h-full border-0"
            type="application/pdf"
        ></iframe>
    </div>
@else
    <div class="text-gray-500 text-center py-4">
        Tidak ada file PDF yang tersedia
    </div>
@endif 