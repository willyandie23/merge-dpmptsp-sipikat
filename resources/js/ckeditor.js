// resources/js/ckeditor.js
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

window.ClassicEditor = ClassicEditor;

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("textarea.ckeditor").forEach((textarea) => {
        // Skip kalau sudah diinisialisasi
        if (textarea.dataset.ckeditorInitialized === "true") return;

        ClassicEditor.create(textarea, {
            toolbar: [
                "heading",
                "|",
                "bold",
                "italic",
                "underline",
                "|",
                "link",
                "bulletedList",
                "numberedList",
                "blockQuote",
                "|",
                "alignment",
                "|",
                "imageUpload",
                "mediaEmbed",
                "|",
                "undo",
                "redo",
            ],
            height: "420px",
            placeholder: "Tulis konten di sini...",
        })
            .then((editor) => {
                console.log(
                    "CKEditor berhasil dimuat pada:",
                    textarea.name || textarea.id,
                );
                textarea.dataset.ckeditorInitialized = "true";
            })
            .catch((error) => {
                console.error("CKEditor Error:", error);
            });
    });
});
