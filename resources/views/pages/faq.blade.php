@extends('layouts.frontend')

@section('title', 'Frequently Asked Questions - Tunicart')

@section('content')
<section class="section" style="background: var(--bg-alt);">
    <div class="container">
        <div class="section-title">
            <h1>FAQ's</h1>
            <p>Everything you need to know about Tunicart</p>
        </div>

        <div style="max-width: 900px; margin: 0 auto;">
            <div style="margin-bottom: 50px;">
                @forelse($faqs as $faq)
                    <div class="faq-item">
                        <div class="faq-header" onclick="toggleFaq(this)">
                            <span>{{ $faq->question }}</span>
                            <i class="fa-solid fa-plus"></i>
                        </div>
                        <div class="faq-content">
                            <p style="padding: 20px;">{{ $faq->answer }}</p>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #999;">No FAQs added yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>

@section('scripts')
<script>
    function toggleFaq(header) {
        const content = header.nextElementSibling;
        const icon = header.querySelector('i');
        
        if (content.style.maxHeight) {
            content.style.maxHeight = null;
            icon.classList.replace('fa-minus', 'fa-plus');
        } else {
            content.style.maxHeight = content.scrollHeight + "px";
            icon.classList.replace('fa-plus', 'fa-minus');
        }
    }
</script>
@endsection
@endsection
