const image_input = document.querySelector("#image_input");
const preview = document.querySelector('#display_image');
const upload_arrow = document.querySelector(".upload");
image_input.style.opacity = 0;
preview.addEventListener("mouseover", function () {
    upload_arrow.style.opacity = 1;
});
preview.addEventListener("mouseout", function () {
    upload_arrow.style.opacity = 0;
});
preview.addEventListener("click", () =>
    image_input.click());

image_input.addEventListener("change", function () {
    const reader = new FileReader();
    reader.addEventListener("load", () => {
        const uploaded_image = reader.result;
        document.querySelector("#display_image").style.backgroundImage = `url(${uploaded_image})`;
        console.log('done');
    });
    reader.readAsDataURL(this.files[0]);
});
