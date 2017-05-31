<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Filemanager </title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2" />

        <!-- jQuery and jQuery UI (REQUIRED) -->
        <script
            src="https://code.jquery.com/jquery-3.2.1.js"
            integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
        crossorigin="anonymous"></script>

        <script
            src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
            integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
        crossorigin="anonymous"></script>

        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css">

        <!-- elFinder CSS (REQUIRED) -->
        <link rel="stylesheet" type="text/css" href='/elFinder/css/elfinder.full.css'>
        <link rel="stylesheet" type="text/css" href='/elFinder/css/theme.css'>
        <!-- elFinder JS (REQUIRED) -->
        <script src="/elFinder/js/elfinder.full.js"></script>

        <!-- elFinder translation (OPTIONAL) -->
        <!--<script src="js/i18n/elfinder.ru.js"></script>-->

        <!-- elFinder initialization (REQUIRED) -->
        <script type="text/javascript" charset="utf-8">

        function getUrlParam(paramName) {
            var reParam = new RegExp('(?:[\?&]|&amp;)' + paramName + '=([^&]+)', 'i');
            var match = window.location.search.match(reParam);

            return (match && match.length > 1) ? match[1] : '';
        }

        $(document).ready(function () {
            var funcNum = getUrlParam('CKEditorFuncNum');

            var elf = $('#filemanager-container').elfinder({
                url: '{{ url("/filemanager/connector") }}',
                getFileCallback: function (file) {
                    
                    if (funcNum == 'filldata') {
                        window.opener.funcNum( file.url );
                    } else {
                        window.opener.CKEDITOR.tools.callFunction(funcNum, file.url);
                    }
                    
                    elf.destroy();
                    window.close();
                },
                customData: {
                    _token: '{{ csrf_token() }}'
                },
                handlers : {
                    dblclick : function(event) { 
                        event.preventDefault();
                        window.opener.prev().val() = file.name;
                        elf.destroy();
                        window.close();
                    }
                },
                resizable: false
            }).elfinder('instance');
        });
        </script>
    </head>
    <body>
        <!-- Element where elFinder will be created (REQUIRED) -->
        <div id="filemanager-container"></div>

    </body>
</html>