<script>
    function appendImages(el, _target_el) {
        const target_el = document.getElementById(_target_el);

        function renderImages() {
            let images = el.files;
            for (i = 0; i < images.length; i++) {

                let div_element = document.createElement('div')
                div_element.setAttribute("class", "col-xl-2 col-lg-4 col-md-3 col-sm-4 col-6 mt-4 dynamic-img position-relative");
                div_element.setAttribute("id", "gallery" + i);

                let close_btn = document.createElement("button");
                close_btn.setAttribute("type", "button");
                close_btn.setAttribute("data-index", i);
                close_btn.setAttribute("class", "btn-close inline-close");
                close_btn.addEventListener("click", function (e) {
                    updateImages(e.target.getAttribute("data-index"), e.target);
                });

                div_element.appendChild(close_btn);

                let img_container = document.createElement('div');
                img_container.setAttribute("class", "img-container ratio-4by3");

                let src_img = document.createElement("img");
                let img_url = URL.createObjectURL(el.files[i]);

                src_img.setAttribute("src", img_url);
                src_img.setAttribute("alt", img_url.name);
                src_img.setAttribute("class", "card-img");

                img_container.appendChild(src_img);

                div_element.appendChild(img_container);

                target_el.appendChild(div_element);

            }
        }

        renderImages();

        function updateImages(_i, _element) {
            const dt = new DataTransfer();
            const files = el.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i]
                if (Number(_i) !== i)
                    dt.items.add(file) // here you exclude the file. thus removing it.
            }

            _element.parentElement.remove();
            el.files = dt.files;

        }

        target_el.style.display = "flex";
    }
</script>

<style>
    .dynamic-img .btn-close {
        top: -10px;
        right: 0;
        position: absolute;
        transform: none !important;
        padding: 5px;
        border-radius: 16px;
        margin-left: 5px;
        background-color: #eee;
    }

    .ratio-4by3 {
        aspect-ratio: 4/3;
    }

    .ratio-4by3 img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }


    select[multiple].input-group-lg > .form-control,
    select[multiple].input-group-lg > .input-group-addon,
    select[multiple].input-group-lg > .input-group-btn > .btn,
    textarea.input-group-lg > .form-control,
    textarea.input-group-lg > .input-group-addon,
    textarea.input-group-lg > .input-group-btn > .btn {
        height: auto;
    }

    select[multiple],
    select[size] {
        height: auto;
    }

    select[multiple].input-sm,
    textarea.input-sm {
        height: auto;
    }

    select[multiple].form-group-sm .form-control,
    textarea.form-group-sm .form-control {
        height: auto;
    }

    select[multiple].form-group-lg .form-control,
    textarea.form-group-lg .form-control {
        height: auto;
    }
</style>