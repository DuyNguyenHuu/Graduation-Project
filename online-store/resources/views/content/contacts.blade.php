@extends('layouts.template')
@section('content')
    <div class="contact">
        <div class="contact-info">
            <div class="contact-time">
                <h3>Working Days</h3>
                <hr>
                <p>Monday-Friday: 7:00 AM - 5:30 PM</p>
                <p>Saturday: 7:00 AM - 11:30 AM</p>
            </div>
            <div class="contact-store">
                <h3>Store address</h3>
                <hr>
                <p>Our address information</p>
                <p><i class="fa-solid fa-location-dot"></i> 10 Alley 147 Truong Dinh Street, Truong Dinh Ward, Hai Ba Trung District, Hanoi City</p>
                <p><i class="fa-solid fa-mobile"></i> 0985963473</p>
            </div>
        </div>
        <div class="contact-message">
            <h3>Tell Us Your Message</h3>
            <div class="contact-form">
                <form method="POST" action="{{ route('contacts.process') }}">
                    @csrf
                    <label>Full Name</label>
                    <input type="text" name="fullname" placeholder="Fullname" required><br>
                    <label>E-mail</label>
                    <input type="email" name="email" placeholder="E-mail" required><br>
                    <label>Phone</label>
                    <input type="text" name="phone" placeholder="Phone" required>
                    <label>Message</label><br>
                    <textarea type="text" name="message" placeholder="Message"></textarea><br>
                    <button type="submit">Send Message</button>
                </form>
            </div>
        </div>
        @if(session('success'))
            <div id="toastsuccess">
                {{ session('success') }}
            </div>
            <script>
                const toast = document.getElementById('toastsuccess');
                setTimeout(() => { toast.style.opacity = 1; }, 100);
                setTimeout(() => { toast.style.opacity = 0; }, 3000);
            </script>
        @endif
    </div>
@endsection