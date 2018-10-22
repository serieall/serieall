CKEDITOR.plugins.addExternal('spoiler', '/js/ckeditor/plugins/spoiler/plugin.js');
CKEDITOR.plugins.addExternal('wordcount', '/js/ckeditor/plugins/wordcount/plugin.js');
CKEDITOR.replace('avis',
    {
        extraPlugins: 'spoiler,wordcount',
        customConfig: '/js/ckeditor/config.js',
        wordcount: {
            showCharCount: true,
            showWordCount: false,
            showParagraphs: false
        }
    });