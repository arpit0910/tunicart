@extends('layouts.frontend')

@section('title', 'Contact Us - Tunicart')

@section('content')
    <section class="section">
        <div class="container">
            <div class="section-title">
                <h1>Get in Touch</h1>
                <p>We'd love to hear from you!</p>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 50px;">
                <div style="background: var(--bg-alt); padding: 40px; border-radius: 20px;">
                    <h3 style="margin-bottom: 25px;">Contact Info</h3>
                    <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                        <i class="fa-solid fa-location-dot" style="color: var(--primary-color);"></i>
                        <p>Plot No. 22, Shree Salasar Residency, Rudra Enclave, Lalarpura, Jaipur, Rajasthan, 302041</p>
                    </div>
                    <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                        <i class="fa-solid fa-phone" style="color: var(--primary-color);"></i>
                        <p>+91 89550 14059</p>
                    </div>
                    <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                        <i class="fa-solid fa-envelope" style="color: var(--primary-color);"></i>
                        <p>support@tunicart.in</p>
                    </div>
                </div>

                @if (session('success'))
                    <div
                        style="background: #d4edda; color: #155724; padding: 15px; border-radius: 10px; margin-bottom: 20px;">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST"
                    style="background: var(--white); padding: 40px; border-radius: 20px; box-shadow: var(--shadow);">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <input type="text" name="name" placeholder="Full Name"
                            style="padding: 15px; border-radius: 10px; border: 1px solid #ddd;" required>
                        <input type="email" name="email" placeholder="Email Address"
                            style="padding: 15px; border-radius: 10px; border: 1px solid #ddd;" required>
                    </div>
                    <input type="text" name="subject" placeholder="Subject"
                        style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd; margin-bottom: 20px;"
                        required>
                    <textarea name="message" placeholder="Your Message"
                        style="width: 100%; padding: 15px; border-radius: 10px; border: 1px solid #ddd; height: 150px; margin-bottom: 20px; font-family: inherit;"
                        required></textarea>
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px;">Send Message</button>
                </form>
            </div>
        </div>
    </section>
@endsection
