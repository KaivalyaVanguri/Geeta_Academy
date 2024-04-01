let toolbarOptions = [
    ["bold", "italic", "underline", "strike"],
    [{ header: [1, 2, 3, 4, 5, 6, false] }],
    [{ list: "ordered" }, { list: "bullet" }],
    [{ script: "sub" }, { script: "super" }],
    [{ indent: "+1" }, { indent: "-1" }],
    [{ align: [] }],
    [{ size: ["small", "large", "huge", false] }],
    ["image", "link", "video", "formula"],
    [{ color: [] }, { background: [] }],
    [{ font: [] }],
    ["code-block", "blockquote"]
];

// Initialize the regular Quill editor
let quill = new Quill("#editor", {
    modules: {
        toolbar: toolbarOptions,
    },
    theme: "snow",
});

// Get the initial content from a data attribute
let initialContent = document.getElementById("editor").getAttribute("data-initial-content");
quill.root.innerHTML = initialContent;

// Update the hidden textarea on editor changes
quill.on("text-change", function () {
    var htmlContent = quill.root.innerHTML;
    document.getElementById("hidden-textarea").value = htmlContent;
});

// QuillBot configurations
let quillBotContainer = document.getElementById("editor-bot");
if (quillBotContainer) {
    var quillBot = new Quill(quillBotContainer, {
        modules: {
            toolbar: toolbarOptions,
        },
        theme: "snow",
    });
}