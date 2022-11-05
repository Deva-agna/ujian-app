(function (window, document, $) {
  'use strict';

  var Font = Quill.import('formats/font');
  Font.whitelist = ['sofia', 'slabo', 'roboto', 'inconsolata', 'ubuntu'];
  Quill.register(Font, true);

  // Full Editor

  var editorId = ['#input-soal', '#input-jawaban-a', '#input-jawaban-b', '#input-jawaban-c', '#input-jawaban-d'];

  for(editor of editorId){
    createEditor(editor);
  }

  function createEditor(selector){
    var fullEditor = new Quill(selector + '.editor', {
      bounds: '.full-container .editor',
      modules: {
        formula: true,
        syntax: true,
        toolbar: [
          [
            {
              font: []
            },
            {
              size: []
            }
          ],
          ['bold', 'italic', 'underline', 'strike'],
          [
            {
              color: []
            },
            {
              background: []
            }
          ],
          [
            {
              script: 'super'
            },
            {
              script: 'sub'
            }
          ],
          [
            {
              header: '1'
            },
            {
              header: '2'
            },
            'blockquote',
            'code-block'
          ],
          [
            {
              list: 'ordered'
            },
            {
              list: 'bullet'
            },
            {
              indent: '-1'
            },
            {
              indent: '+1'
            }
          ],
          [
            'direction',
            {
              align: []
            }
          ],
          ['link', 'image', 'video', 'formula'],
          ['clean']
        ]
      },
      theme: 'snow'
    });
  }

  var editors = [bubbleEditor, snowEditor, fullEditor];
})(window, document, jQuery);
