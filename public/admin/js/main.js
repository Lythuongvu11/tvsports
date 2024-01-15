$(document).ready
    (function () {
        "use strict";

        var treeviewMenu = $('.app-menu');

        // Toggle Sidebar
        $('[data-toggle="sidebar"]').click(function (event) {
            event.preventDefault();
            $('.app').toggleClass('sidenav-toggled');
        });

        // Activate sidebar treeview toggle
        $("[data-toggle='treeview']").click(function (event) {
            event.preventDefault();
            if (!$(this).parent().hasClass('is-expanded')) {
                treeviewMenu.find("[data-toggle='treeview']").parent().removeClass('is-expanded');
            }
            $(this).parent().toggleClass('is-expanded');
        });

        // Set initial active toggle
        $("[data-toggle='treeview.'].is-expanded").parent().toggleClass('is-expanded');
        //Activate bootstrip tooltips

        $("[data-toggle='tooltip']").tooltip();

    });
//avatar
$(document).ready(function() {
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#show-image').attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#image-input").change(function() {
    readURL(this);
});
});
//image add
$(document).ready(function () {
    $("#inputImage").on("change", function () {
        readURL(this);
    });

    // Gọi hàm khi trang được tải
    setupImageInputs();

    // Xử lý khi click vào nút thêm ảnh
    $("#addImageButton").on("click", function () {
        // Gọi hàm khi thêm ảnh mới
        addImageInput();
    });
});

// Hàm để thiết lập ô input ảnh phụ và nút xóa
function setupImageInputs() {
    $(".btn-delete-image").on("click", function () {
        $(this).closest(".input-group").remove();
    });
}

// Hàm để thêm ô input ảnh phụ mới
function addImageInput() {
    let newInput = `
        <div class="input-group mb-3">
            <input type="file" name="image_products[]" class="form-control" multiple>
            <div class="input-group-append">
                <button class="btn btn-outline-secondary btn-delete-image" type="button">-</button>
            </div>
        </div>`;

    // Append new input to container
    $("#image-container .input-group:last").after(newInput);

    // Gọi lại hàm để cập nhật sự kiện cho nút xóa
    setupImageInputs();
}
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
//order
$(function () {
    $(document).on("change", ".select-status", function (e) {
        e.preventDefault();
        let url = $(this).data("action");
        let data = {
            status: $(this).val(),
        };

        $.post(url, data, (res) => {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Thay đổi trạng thái đơn hàng thành công",
                showConfirmButton: false,
                timer: 1500,
            });
        });
    });
});



