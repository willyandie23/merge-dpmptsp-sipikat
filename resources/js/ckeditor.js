// resources/js/ckeditor.js
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

window.ClassicEditor = ClassicEditor;

// Inisialisasi otomatis hanya untuk textarea dengan class "ckeditor"
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll("textarea.ckeditor").forEach((element) => {
        // Skip kalau sudah diinisialisasi
        if (
            element.nextElementSibling &&
            element.nextElementSibling.classList.contains("ck-editor")
        ) {
            return;
        }

        ClassicEditor.create(element, {
            toolbar: [
                "heading",
                "|",
                "bold",
                "italic",
                "link",
                "bulletedList",
                "numberedList",
                "blockQuote",
                "|",
                "undo",
                "redo",
            ],
            height: 350,
        }).catch((error) => {
            console.error("CKEditor error:", error);
        });
    });
});
