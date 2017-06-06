// tinymce for news
tinymce.init({
    mode : "textareas",
    editor_selector : "news-create",
    image_title: true,
    automatic_uploads: true,
    file_picker_types: 'image',
    relative_urls : true,
    formats: {
        bold: {inline: 'strong', 'classes': 'bold'},
        italic: {inline: 'i', 'classes': 'italic'},
    },
    skin: 'lightgray',
    menubar: false,
    height: '350',
    autoresize_overflow_padding: 15,
    statusbar: false
});