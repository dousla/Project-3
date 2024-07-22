document.getElementById('registrationForm').addEventListener('submit', function (e) {
    const studentID = document.getElementById('student_id').value;
    const firstName = document.getElementById('first_name').value;
    const lastName = document.getElementById('last_name').value;
    const email = document.getElementById('email').value;
    const phone = document.getElementById('phone').value;
    
    const studentIDPattern = /^\d{8}$/;
    const namePattern = /^[A-Za-z]+$/;
    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const phonePattern = /^\d{3}-\d{3}-\d{4}$/;

    if (!studentIDPattern.test(studentID)) {
        alert('Student ID must be 8 digits.');
        e.preventDefault();
        return;
    }

    if (!namePattern.test(firstName) || !namePattern.test(lastName)) {
        alert('Names must contain only letters.');
        e.preventDefault();
        return;
    }

    if (!emailPattern.test(email)) {
        alert('Invalid email format.');
        e.preventDefault();
        return;
    }

    if (!phonePattern.test(phone)) {
        alert('Phone number must be in the form 999-999-9999.');
        e.preventDefault();
        return;
    }
});
