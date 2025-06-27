document.addEventListener("DOMContentLoaded", function() {
    let currentIndex = 0;
    const slides = document.querySelectorAll('.slider-content img');
    const totalSlides = slides.length;

    function showSlide(index) {
        const sliderContent = document.querySelector('.slider-content');
        sliderContent.style.transform = `translateX(-${index * 100}%)`;
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        showSlide(currentIndex);
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        showSlide(currentIndex);
    }

    document.querySelector('.arrow-left').addEventListener('click', prevSlide);
    document.querySelector('.arrow-right').addEventListener('click', nextSlide);

    setInterval(nextSlide, 6000); 
});


document.addEventListener('DOMContentLoaded', function() {
    const cartIcons = document.querySelectorAll('.fa-shopping-cart');

    cartIcons.forEach(icon => {
        icon.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.getAttribute('data-id');  // Lấy product ID từ data attribute
            addToCart(productId);
        });
    });
});

function addToCart(productId) {
    window.location.href = 'cart.php?action=add&id=' + productId;
}


// Khởi tạo CKEditor
// Hiển thị form CKEditor khi nhấn vào nút "Chỉnh sửa"
document.getElementById('edit-contact-btn').addEventListener('click', function() {
    document.getElementById('edit-contact-form').style.display = 'block'; // Hiển thị form CKEditor
    var contactInfo = localStorage.getItem('contactInfo') || "Thông tin liên hệ chưa được cập nhật."; 
    CKEDITOR.instances['contact-textarea'].setData(contactInfo); // Hiển thị nội dung trong CKEditor
});

// Nút Lưu
document.getElementById('save-contact-btn').addEventListener('click', function() {
    var contactContent = CKEDITOR.instances['contact-textarea'].getData(); // Lấy dữ liệu từ CKEditor
    localStorage.setItem('contactInfo', contactContent); // Lưu dữ liệu vào localStorage
    document.getElementById('display-contact-info').innerHTML = contactContent; // Cập nhật nội dung hiển thị
    document.getElementById('edit-contact-form').style.display = 'none'; // Ẩn CKEditor sau khi lưu
});

// Hiển thị thông tin liên hệ khi tải trang
window.onload = function() {
    var contactInfo = localStorage.getItem('contactInfo') || "Thông tin liên hệ chưa được cập nhật.";
    document.getElementById('display-contact-info').innerHTML = contactInfo; // Hiển thị nội dung đã lưu
};










