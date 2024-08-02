function changeFontSize() {
    document.body.style.fontSize = (document.body.style.fontSize === '16px') ? '20px' : '16px';
}

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function(event) {
        event.preventDefault();
        alert('Form submitted!');
    });
});