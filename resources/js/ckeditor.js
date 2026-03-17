// resources/js/ckeditor.js
import ClassicEditor from "@ckeditor/ckeditor5-build-classic";

window.ClassicEditor = ClassicEditor;

// Auto-init CKEditor di semua textarea dengan id="editor"
document.addEventListener("DOMContentLoaded", () => {
    const editorElement = document.querySelector("#editor");
    if (editorElement) {
        ClassicEditor.create(editorElement, {
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
            height: 450,
        }).catch((error) => {
            console.error("CKEditor error:", error);
        });
    }
});
