@extends('layouts.frontend')

@section('title', 'My Custom Designs - Tunicart')

@section('content')
<section class="section">
    <div class="container">
        <div style="display: flex; gap: 30px; flex-wrap: wrap;">
            <!-- Sidebar -->
            <div style="flex: 1; min-width: 250px;">
                <div class="glass" style="padding: 25px; border-radius: 20px;">
                    <h3 style="margin-bottom: 25px; font-size: 1.4rem; font-weight: 800;">My Account</h3>
                    <ul style="display: flex; flex-direction: column; gap: 15px;">
                        <li><a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 10px; color: var(--text-light); transition: var(--transition);">
                            <i class="fa-solid fa-gauge-high"></i> Dashboard
                        </a></li>
                        <li><a href="#" style="display: flex; align-items: center; gap: 10px; color: var(--text-light); transition: var(--transition);">
                            <i class="fa-solid fa-box"></i> My Orders
                        </a></li>
                        <li><a href="{{ route('dashboard.designs') }}" style="font-weight: 700; color: var(--accent-color); display: flex; align-items: center; gap: 10px;">
                            <i class="fa-solid fa-palette"></i> Custom Designs
                        </a></li>
                        <li style="margin-top: 10px; padding-top: 20px; border-top: 1px solid var(--glass-border);">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="color: #ef4444; display: flex; align-items: center; gap: 10px; font-weight: 600;">
                                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                                </a>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Main Content -->
            <div style="flex: 3; min-width: 300px;">
                <div class="glass" style="padding: 40px; border-radius: 20px; border: 1px solid var(--glass-border);">
                    <h2 style="font-size: 2rem; margin-bottom: 10px; font-weight: 900;">Your Design <span style="color: var(--secondary-color);">Portfolio</span></h2>
                    <p style="color: var(--text-light); margin-bottom: 35px; font-size: 1.1rem;">A collection of all the unique masterpieces you've created.</p>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px;">
                        @forelse($designs as $design)
                            <div class="glass" style="border-radius: 20px; overflow: hidden; border: 1px solid var(--glass-border); transition: var(--transition); transform-origin: center;">
                                <div style="position: relative; aspect-ratio: 1/1.2; overflow: hidden;">
                                    <img src="{{ asset('storage/' . ($design->front_mockup ?? $design->product->image)) }}" style="width: 100%; height: 100%; object-fit: cover;">
                                    <div style="position: absolute; top: 15px; right: 15px; background: var(--primary-color); color: #fff; padding: 5px 12px; border-radius: 50px; font-size: 0.7rem; font-weight: 800;">
                                        Order #{{ $design->order_id }}
                                    </div>
                                </div>
                                <div style="padding: 20px; text-align: center;">
                                    <h4 style="margin-bottom: 15px; font-weight: 800;">{{ $design->product->name }}</h4>
                                    <div style="display: flex; gap: 10px; justify-content: center;">
                                        @if($design->front_mockup)
                                            <a href="{{ asset('storage/' . $design->front_mockup) }}" target="_blank" class="btn" style="padding: 8px 12px; font-size: 0.8rem; border: 1px solid var(--glass-border); color: var(--black);">Front View</a>
                                        @endif
                                        @if($design->back_mockup)
                                            <a href="{{ asset('storage/' . $design->back_mockup) }}" target="_blank" class="btn" style="padding: 8px 12px; font-size: 0.8rem; border: 1px solid var(--glass-border); color: var(--black);">Back View</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column: 1/-1; text-align: center; padding: 60px 40px; color: var(--text-light); background: rgba(255,255,255,0.02); border: 1px dashed var(--glass-border); border-radius: 18px;">
                                <i class="fa-solid fa-palette" style="font-size: 3rem; margin-bottom: 20px; opacity: 0.3;"></i>
                                <p>You haven't created any custom designs yet.</p>
                                <a href="{{ route('products.index') }}" class="btn btn-primary" style="display: inline-block; margin-top: 20px;">Start Designing</a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
