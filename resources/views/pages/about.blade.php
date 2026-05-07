@extends('layouts.frontend')

@section('title', 'About Us - Tunicart')

@section('content')
<section class="section bg-pattern">
    <div class="container">
        <div style="max-width: 800px; margin: 0 auto; text-align: center;">
            <h1 style="font-size: 3rem; margin-bottom: 30px;">Proudly Indian, <span style="color: var(--primary-color);">Global Standards.</span></h1>
            <p style="font-size: 1.2rem; color: var(--text-light); margin-bottom: 50px;">Tunicart was born out of a passion for high-quality apparel and the creative spirit of India. We believe that everyone should be able to wear their thoughts and creativity.</p>
        </div>
        
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: center; margin-top: 50px;">
            <div>
                <img src="https://images.unsplash.com/photo-1523381210434-271e8be1f52b?auto=format&fit=crop&w=800&q=80" alt="Craftsmanship" style="border-radius: 20px; box-shadow: var(--shadow-lg);">
            </div>
            <div>
                <h2 style="margin-bottom: 20px;">Our Journey</h2>
                <p style="margin-bottom: 20px;">Founded in 2024, Tunicart started as a small studio in the heart of India with one goal: to provide premium, customizable t-shirts that don't compromise on quality or comfort.</p>
                <p>We source our cotton from the best Indian mills and use state-of-the-art printing technology to ensure your designs look vibrant and last long.</p>
            </div>
        </div>
    </div>
</section>
@endsection
