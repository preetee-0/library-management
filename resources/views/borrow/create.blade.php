@extends ('layouts.app')
@section('content')

<div class="container">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3>Borrow Book</h3>
        </div>
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <h4>{{ $book->title }}</h4>
            <form action="{{ route('borrow.store', $book->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label>Student ID</label>
                    <input type="text" name="student_id" class="form-control" placeholder="Example: STU098" value="{{ old('student_id') }}" required>
                </div>
                <div class="mb-3">
                    <label>Student Name</label>
                    <input type="text" name="student_name" class="form-control" value="{{ old('student_name') }}" required>
                </div>
                <div class="mb-3">
                    <label>Email <span class="text-danger" id="email-required">*</span></label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" id="email-input">
                    <small class="text-muted" id="email-hint">Required for new users</small>
                </div>
                <div class="mb-3">
                    <label>Phone <span class="text-danger" id="phone-required">*</span></label>
                    <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" id="phone-input">
                    <small class="text-muted" id="phone-hint">Required for new users</small>
                </div>
                <div class="mb-3">
                    <label>Borrow Date</label>
                    <input type="date" name="borrow_date" class="form-control" value="{{ old('borrow_date', date('Y-m-d')) }}">
                </div>
                <div class="mb-3">
                    <label>Return Date</label>
                    <input type="date" name="return_date" class="form-control" value="{{ old('return_date', date('Y-m-d')) }}">
                </div>
                <button class="btn btn-success">Borrow Book</button>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const studentIdInput = document.querySelector('input[name="student_id"]');
    const emailInput = document.getElementById('email-input');
    const phoneInput = document.getElementById('phone-input');
    const emailRequired = document.getElementById('email-required');
    const phoneRequired = document.getElementById('phone-required');
    const emailHint = document.getElementById('email-hint');
    const phoneHint = document.getElementById('phone-hint');

    function checkExistingUser() {
        const studentId = studentIdInput.value.trim();
        
        if (studentId.length > 0) {
            // Make AJAX request to check if user exists
            fetch(`/check-user/${studentId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.exists) {
                        // User exists - make email and phone optional
                        emailInput.removeAttribute('required');
                        phoneInput.removeAttribute('required');
                        emailRequired.style.display = 'none';
                        phoneRequired.style.display = 'none';
                        emailHint.textContent = 'Optional for existing users';
                        phoneHint.textContent = 'Optional for existing users';
                        
                        // Auto-fill existing data if available
                        if (data.user) {
                            if (data.user.email) emailInput.value = data.user.email;
                            if (data.user.phone) phoneInput.value = data.user.phone;
                            if (data.user.name) {
                                document.querySelector('input[name="student_name"]').value = data.user.name;
                            }
                        }
                    } else {
                        // New user - make email and phone required
                        emailInput.setAttribute('required', 'required');
                        phoneInput.setAttribute('required', 'required');
                        emailRequired.style.display = 'inline';
                        phoneRequired.style.display = 'inline';
                        emailHint.textContent = 'Required for new users';
                        phoneHint.textContent = 'Required for new users';
                    }
                })
                .catch(error => console.error('Error checking user:', error));
        } else {
            // Reset to required if student ID is empty
            emailInput.setAttribute('required', 'required');
            phoneInput.setAttribute('required', 'required');
            emailRequired.style.display = 'inline';
            phoneRequired.style.display = 'inline';
            emailHint.textContent = 'Required for new users';
            phoneHint.textContent = 'Required for new users';
        }
    }

    // Check when student ID changes
    studentIdInput.addEventListener('blur', checkExistingUser);
});
</script>
@endpush

@endsection