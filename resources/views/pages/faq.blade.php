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
            <!-- Categories -->
            <div style="margin-bottom: 50px;">
                <h2 style="margin-bottom: 25px; border-left: 5px solid var(--primary-color); padding-left: 15px;">Ordering & Customization</h2>
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>How do I upload my own design?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">On any product page, you'll see a "Customize Your T-Shirt" section. You can upload front and back designs (PNG/JPG) and add specific instructions in the notes field.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>Is there a minimum order quantity?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">No! We believe in personal expression, so you can order even a single custom t-shirt.</p>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 50px;">
                <h2 style="margin-bottom: 25px; border-left: 5px solid var(--primary-color); padding-left: 15px;">Shipping & Returns</h2>
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>Where do you deliver?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">We deliver all across India, including remote locations, through our premium courier partners like BlueDart and Delhivery.</p>
                    </div>
                </div>
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>Can I change my delivery address?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">You can change your address within 12 hours of placing the order by contacting our support team via the Contact page.</p>
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 50px;">
                <h2 style="margin-bottom: 25px; border-left: 5px solid var(--primary-color); padding-left: 15px;">Product Quality</h2>
                <div class="faq-item">
                    <div class="faq-header" onclick="toggleFaq(this)">
                        <span>What printing technology do you use?</span>
                        <i class="fa-solid fa-plus"></i>
                    </div>
                    <div class="faq-content">
                        <p style="padding: 20px;">We use high-end DTG (Direct to Garment) and Screen Printing to ensure vibrant colors that don't fade after washing.</p>
                    </div>
                </div>
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
